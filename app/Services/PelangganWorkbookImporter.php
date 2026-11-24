<?php

namespace App\Services;

use Illuminate\Validation\ValidationException;
use PharData;
use SimpleXMLElement;
use UnexpectedValueException;

class PelangganWorkbookImporter
{
    private const MAIN_NAMESPACE = 'http://schemas.openxmlformats.org/spreadsheetml/2006/main';

    private const OFFICE_RELATIONSHIP_NAMESPACE = 'http://schemas.openxmlformats.org/officeDocument/2006/relationships';

    private const PACKAGE_RELATIONSHIP_NAMESPACE = 'http://schemas.openxmlformats.org/package/2006/relationships';

    private const MAX_XML_SIZE = 20 * 1024 * 1024;

    /**
     * @return array<int, array<string, mixed>>
     */
    public function read(string $path): array
    {
        try {
            $archive = new PharData($path, 0, null, \Phar::ZIP);
        } catch (UnexpectedValueException|\PharException) {
            $this->invalidWorkbook('File Excel bukan workbook XLSX yang valid.');
        }

        $workbook = $this->loadXml($this->readArchiveFile($archive, 'xl/workbook.xml'));
        $relationships = $this->loadXml($this->readArchiveFile($archive, 'xl/_rels/workbook.xml.rels'));
        $sharedStrings = $this->readSharedStrings($archive);
        $worksheetPath = $this->firstWorksheetPath($workbook, $relationships);
        $worksheet = $this->loadXml($this->readArchiveFile($archive, $worksheetPath));
        $sheetData = $worksheet->children(self::MAIN_NAMESPACE)->sheetData;

        if (! isset($sheetData)) {
            $this->invalidWorkbook('Isi lembar kerja Excel tidak valid.');
        }

        $rows = $sheetData->children(self::MAIN_NAMESPACE)->row;

        if (count($rows) < 2) {
            throw ValidationException::withMessages([
                'file' => 'File Excel tidak berisi data pelanggan.',
            ]);
        }

        $headers = $this->readRow($rows[0], $sharedStrings);
        $headerIndexes = [];

        foreach ($headers as $index => $header) {
            $headerIndexes[mb_strtoupper(trim($header))] = $index;
        }

        foreach (['PETUGAS', 'IDPEL', 'NOMOR HP', 'X', 'Y'] as $requiredHeader) {
            if (! array_key_exists($requiredHeader, $headerIndexes)) {
                throw ValidationException::withMessages([
                    'file' => 'Header Excel wajib memiliki kolom PETUGAS, IDPEL, NOMOR HP, X, dan Y.',
                ]);
            }
        }

        $records = [];

        for ($index = 1; $index < count($rows); $index++) {
            $row = $rows[$index];
            $values = $this->readRow($row, $sharedStrings);

            if (collect($values)->every(static fn (string $value): bool => trim($value) === '')) {
                continue;
            }

            if (count($records) >= 5000) {
                throw ValidationException::withMessages([
                    'file' => 'File Excel maksimal berisi 5.000 pelanggan.',
                ]);
            }

            $rowNumber = (string) $row->attributes()['r'] ?: (string) ($index + 1);
            $customerId = trim($this->valueAt($values, $headerIndexes['IDPEL']));

            if ($customerId === '') {
                throw ValidationException::withMessages([
                    'file' => 'Baris '.$rowNumber.': IDPEL wajib diisi.',
                ]);
            }

            $records[] = [
                'id_pelanggan' => $customerId,
                'nama' => null,
                'petugas' => trim($this->valueAt($values, $headerIndexes['PETUGAS'])) ?: null,
                'unit' => '22140',
                'nomor_telepon' => trim($this->valueAt($values, $headerIndexes['NOMOR HP'])) ?: null,
                'alamat' => null,
                'latitude' => $this->normalizeCoordinate(
                    $this->valueAt($values, $headerIndexes['X']),
                    1,
                    -90,
                    90,
                    'X',
                    $rowNumber,
                ),
                'longitude' => $this->normalizeCoordinate(
                    $this->valueAt($values, $headerIndexes['Y']),
                    3,
                    -180,
                    180,
                    'Y',
                    $rowNumber,
                ),
                'status' => 'aktif',
            ];
        }

        if ($records === []) {
            throw ValidationException::withMessages([
                'file' => 'File Excel tidak berisi data pelanggan.',
            ]);
        }

        return $records;
    }

    /**
     * @return array<int, string>
     */
    private function readSharedStrings(PharData $archive): array
    {
        if (! isset($archive['xl/sharedStrings.xml'])) {
            return [];
        }

        $xml = $this->loadXml($this->readArchiveFile($archive, 'xl/sharedStrings.xml'));
        $strings = [];

        foreach ($xml->children(self::MAIN_NAMESPACE)->si as $item) {
            $strings[] = $this->readRichText($item);
        }

        return $strings;
    }

    private function firstWorksheetPath(SimpleXMLElement $workbook, SimpleXMLElement $relationships): string
    {
        $sheets = $workbook->children(self::MAIN_NAMESPACE)->sheets->children(self::MAIN_NAMESPACE)->sheet;

        if (count($sheets) === 0) {
            $this->invalidWorkbook('File Excel tidak memiliki lembar kerja yang dapat dibaca.');
        }

        $relationshipId = (string) $sheets[0]->attributes(self::OFFICE_RELATIONSHIP_NAMESPACE)->id;

        foreach ($relationships->children(self::PACKAGE_RELATIONSHIP_NAMESPACE)->Relationship as $relationship) {
            $attributes = $relationship->attributes();

            if ((string) $attributes['Id'] !== $relationshipId) {
                continue;
            }

            $target = ltrim((string) $attributes['Target'], '/');

            if (preg_match('/^worksheets\/sheet\d+\.xml$/', $target) === 1) {
                return 'xl/'.$target;
            }

            if (preg_match('/^xl\/worksheets\/sheet\d+\.xml$/', $target) === 1) {
                return $target;
            }

            break;
        }

        $this->invalidWorkbook('Lembar kerja utama Excel tidak dapat ditemukan.');
    }

    /**
     * @return array<int, string>
     */
    private function readRow(SimpleXMLElement $row, array $sharedStrings): array
    {
        $values = [];

        foreach ($row->children(self::MAIN_NAMESPACE)->c as $cell) {
            $attributes = $cell->attributes();
            $reference = (string) $attributes['r'];

            if (preg_match('/^([A-Z]+)\d+$/i', $reference, $matches) !== 1) {
                $this->invalidWorkbook('Isi lembar kerja Excel tidak valid.');
            }

            $columnIndex = 0;

            foreach (str_split(strtoupper($matches[1])) as $letter) {
                $columnIndex = ($columnIndex * 26) + ord($letter) - 64;
            }

            $cellType = (string) $attributes['t'];
            $children = $cell->children(self::MAIN_NAMESPACE);
            $value = isset($children->v) ? (string) $children->v : '';

            if ($cellType === 's') {
                $sharedStringIndex = filter_var($value, FILTER_VALIDATE_INT);

                if ($sharedStringIndex === false || ! array_key_exists($sharedStringIndex, $sharedStrings)) {
                    $this->invalidWorkbook('Isi lembar kerja Excel tidak valid.');
                }

                $value = $sharedStrings[$sharedStringIndex];
            } elseif ($cellType === 'inlineStr') {
                $value = isset($children->is) ? $this->readRichText($children->is) : '';
            }

            $values[$columnIndex - 1] = trim($value);
        }

        if ($values !== []) {
            ksort($values);
        }

        return $values;
    }

    private function readRichText(SimpleXMLElement $element): string
    {
        $text = '';

        foreach ($element->children(self::MAIN_NAMESPACE) as $child) {
            if ($child->getName() === 't') {
                $text .= (string) $child;
            } elseif ($child->getName() === 'r') {
                $run = $child->children(self::MAIN_NAMESPACE);
                $text .= isset($run->t) ? (string) $run->t : '';
            }
        }

        return $text;
    }

    private function normalizeCoordinate(
        string $value,
        int $degreeDigits,
        float $minimum,
        float $maximum,
        string $column,
        string $rowNumber,
    ): ?string {
        $value = trim($value);

        if ($value === '') {
            return null;
        }

        if (! is_numeric($value)) {
            $this->invalidCoordinate($column, $rowNumber);
        }

        $numericValue = (float) $value;

        if ($numericValue < $minimum || $numericValue > $maximum) {
            if (floor(abs($numericValue)) !== abs($numericValue)) {
                $this->invalidCoordinate($column, $rowNumber);
            }

            $integer = sprintf('%.0f', $numericValue);
            $negative = str_starts_with($integer, '-');
            $digits = ltrim($integer, '-');

            if (strlen($digits) <= $degreeDigits) {
                $this->invalidCoordinate($column, $rowNumber);
            }

            $integerPart = substr($digits, 0, $degreeDigits);
            $fractionalPart = substr($digits, $degreeDigits);
            $normalizedValue = ($negative ? '-' : '').$integerPart.'.'.$fractionalPart;
            $numericValue = (float) $normalizedValue;
        }

        if ($numericValue < $minimum || $numericValue > $maximum) {
            $this->invalidCoordinate($column, $rowNumber);
        }

        return number_format($numericValue, 7, '.', '');
    }

    private function valueAt(array $values, int $index): string
    {
        return $values[$index] ?? '';
    }

    private function readArchiveFile(PharData $archive, string $path): string
    {
        if (! isset($archive[$path])) {
            $this->invalidWorkbook('File Excel tidak lengkap atau rusak.');
        }

        $file = $archive[$path];

        if ($file->getSize() > self::MAX_XML_SIZE) {
            $this->invalidWorkbook('Ukuran data di dalam file Excel terlalu besar.');
        }

        try {
            $contents = $file->getContent();
        } catch (\PharException) {
            $this->invalidWorkbook('Isi file Excel tidak dapat dibaca.');
        }

        if (strlen($contents) > self::MAX_XML_SIZE) {
            $this->invalidWorkbook('Ukuran data di dalam file Excel terlalu besar.');
        }

        return $contents;
    }

    private function loadXml(string $contents): SimpleXMLElement
    {
        $previousErrorMode = libxml_use_internal_errors(true);

        try {
            $xml = simplexml_load_string($contents, SimpleXMLElement::class, LIBXML_NONET | LIBXML_COMPACT);
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previousErrorMode);
        }

        if (! $xml instanceof SimpleXMLElement) {
            $this->invalidWorkbook('Struktur XML di dalam file Excel tidak valid.');
        }

        return $xml;
    }

    private function invalidCoordinate(string $column, string $rowNumber): never
    {
        throw ValidationException::withMessages([
            'file' => 'Baris '.$rowNumber.': koordinat '.$column.' tidak valid.',
        ]);
    }

    private function invalidWorkbook(string $message = 'File Excel tidak valid atau tidak dapat dibaca.'): never
    {
        throw ValidationException::withMessages([
            'file' => $message,
        ]);
    }
}
