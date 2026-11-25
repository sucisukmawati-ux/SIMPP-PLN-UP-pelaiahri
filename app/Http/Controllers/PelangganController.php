<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Services\PelangganWorkbookImporter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PelangganController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
        ]);
        $search = $validated['search'] ?? null;

        $pelangganList = Pelanggan::query()
            ->when($search, function (Builder $query, string $search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('id_pelanggan', 'like', "%{$search}%")
                        ->orWhere('nama', 'like', "%{$search}%")
                        ->orWhere('petugas', 'like', "%{$search}%")
                        ->orWhere('nomor_telepon', 'like', "%{$search}%");
                });
            })
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('pelanggan.index', [
            'pelangganList' => $pelangganList,
            'search' => $search,
        ]);
    }

    public function locations(): View
    {
        return view('pelanggan.locations', [
            'pelangganList' => Pelanggan::query()->orderBy('nama')->paginate(20),
        ]);
    }

    public function importForm(): View
    {
        return view('pelanggan.import');
    }

    public function notifications(): View
    {
        return view('pelanggan.notifications', [
            'pelangganList' => Pelanggan::query()
                ->where('status', 'aktif')
                ->whereNotNull('nomor_telepon')
                ->where('nomor_telepon', '!=', '')
                ->orderBy('nama')
                ->paginate(20),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $pelanggan = Pelanggan::create($request->validate($this->rules(), $this->messages()));

        return redirect()->route('pelanggan.show', $pelanggan)
            ->with('status', 'Data pelanggan berhasil ditambahkan.');
    }

    public function show(Pelanggan $pelanggan): View
    {
        return view('pelanggan.show', ['pelanggan' => $pelanggan]);
    }

    public function update(Request $request, Pelanggan $pelanggan): RedirectResponse
    {
        $pelanggan->update($request->validate($this->rules($pelanggan), $this->messages()));

        return redirect()->route('pelanggan.show', $pelanggan)
            ->with('status', 'Data pelanggan berhasil diperbarui.');
    }

    public function destroy(Pelanggan $pelanggan): RedirectResponse
    {
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')
            ->with('status', 'Data pelanggan berhasil dihapus.');
    }

    public function import(Request $request, PelangganWorkbookImporter $workbookImporter): RedirectResponse
    {
        $uploadedFile = $request->file('file');
        $isWorkbook = strtolower($uploadedFile?->getClientOriginalExtension() ?? '') === 'xlsx';
        $fileRules = $isWorkbook
            ? ['required', 'file', 'extensions:xlsx', 'max:10240']
            : ['required', 'file', 'mimes:csv,txt', 'max:10240'];
        $validated = $request->validate(['file' => $fileRules]);
        $file = $validated['file'];
        $records = $isWorkbook
            ? $workbookImporter->read($file->getPathname())
            : $this->readCsv($file);

        $this->validateImportRecords($records, ! $isWorkbook);

        $customerIds = array_column($records, 'id_pelanggan');

        if (count(array_unique($customerIds)) !== count($customerIds)) {
            throw ValidationException::withMessages([
                'file' => 'File memiliki ID pelanggan yang duplikat.',
            ]);
        }

        if (Pelanggan::query()->whereIn('id_pelanggan', $customerIds)->exists()) {
            throw ValidationException::withMessages([
                'file' => 'Sebagian ID pelanggan di file sudah terdaftar. Hapus atau perbarui datanya terlebih dahulu.',
            ]);
        }

        DB::transaction(function () use ($records): void {
            foreach ($records as $record) {
                Pelanggan::create($record);
            }
        });

        return redirect()->route('pelanggan.import.form')
            ->with('status', count($records).' pelanggan berhasil diimpor.');
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function readCsv(UploadedFile $file): array
    {
        $handle = fopen($file->getPathname(), 'rb');

        if ($handle === false) {
            throw ValidationException::withMessages([
                'file' => 'File CSV tidak dapat dibaca.',
            ]);
        }

        try {
            $headers = fgetcsv($handle, null, ',', '"', '\\');

            if ($headers === false) {
                throw ValidationException::withMessages([
                    'file' => 'File CSV kosong atau tidak memiliki header.',
                ]);
            }

            $headers = array_map(
                static fn (mixed $header): string => mb_strtolower(trim(preg_replace('/^\xEF\xBB\xBF/', '', (string) $header) ?? '')),
                $headers,
            );

            if (! in_array('id_pelanggan', $headers, true) || ! in_array('nama', $headers, true)) {
                throw ValidationException::withMessages([
                    'file' => 'Header CSV wajib memiliki kolom id_pelanggan dan nama.',
                ]);
            }

            $records = [];

            while (($values = fgetcsv($handle, null, ',', '"', '\\')) !== false) {
                if ($values === [null]) {
                    continue;
                }

                $values = array_pad($values, count($headers), '');
                $row = array_combine($headers, array_slice($values, 0, count($headers)));

                if ($row === false) {
                    continue;
                }

                $records[] = [
                    'id_pelanggan' => trim((string) ($row['id_pelanggan'] ?? '')),
                    'nama' => trim((string) ($row['nama'] ?? '')),
                    'petugas' => trim((string) ($row['petugas'] ?? '')) ?: null,
                    'unit' => trim((string) ($row['unit'] ?? '')) ?: '22140',
                    'nomor_telepon' => trim((string) ($row['nomor_telepon'] ?? '')) ?: null,
                    'alamat' => trim((string) ($row['alamat'] ?? '')) ?: null,
                    'latitude' => trim((string) ($row['latitude'] ?? '')) ?: null,
                    'longitude' => trim((string) ($row['longitude'] ?? '')) ?: null,
                    'status' => mb_strtolower(trim((string) ($row['status'] ?? ''))) ?: 'aktif',
                ];

                if (count($records) > 5000) {
                    throw ValidationException::withMessages([
                        'file' => 'File CSV maksimal berisi 5.000 pelanggan.',
                    ]);
                }
            }
        } finally {
            fclose($handle);
        }

        if ($records === []) {
            throw ValidationException::withMessages([
                'file' => 'File CSV tidak berisi data pelanggan.',
            ]);
        }

        return $records;
    }

    /**
     * @param  array<int, array<string, mixed>>  $records
     */
    private function validateImportRecords(array $records, bool $requireName): void
    {
        foreach ($records as $index => $record) {
            $validator = Validator::make($record, [
                'id_pelanggan' => ['required', 'string', 'max:32'],
                'nama' => [$requireName ? 'required' : 'nullable', 'string', 'max:160'],
                'petugas' => ['nullable', 'string', 'max:160'],
                'unit' => ['required', 'string', 'max:32'],
                'nomor_telepon' => ['nullable', 'string', 'max:32'],
                'alamat' => ['nullable', 'string', 'max:2000'],
                'latitude' => ['nullable', 'numeric', 'between:-90,90'],
                'longitude' => ['nullable', 'numeric', 'between:-180,180'],
                'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
            ]);

            if ($validator->fails()) {
                throw ValidationException::withMessages([
                    'file' => 'Baris '.($index + 2).': '.$validator->errors()->first(),
                ]);
            }
        }
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    private function rules(?Pelanggan $pelanggan = null): array
    {
        $customerIdRule = Rule::unique('pelanggan', 'id_pelanggan');

        if ($pelanggan !== null) {
            $customerIdRule->ignore($pelanggan);
        }

        return [
            'id_pelanggan' => ['required', 'string', 'max:32', $customerIdRule],
            'nama' => ['required', 'string', 'max:160'],
            'petugas' => ['nullable', 'string', 'max:160'],
            'unit' => ['required', 'string', 'max:32'],
            'nomor_telepon' => ['nullable', 'string', 'max:32'],
            'alamat' => ['nullable', 'string', 'max:2000'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'status' => ['required', Rule::in(['aktif', 'nonaktif'])],
        ];
    }

    /**
     * @return array<string, string>
     */
    private function messages(): array
    {
        return [
            'id_pelanggan.required' => 'ID pelanggan wajib diisi.',
            'id_pelanggan.unique' => 'ID pelanggan tersebut sudah terdaftar.',
            'nama.required' => 'Nama pelanggan wajib diisi.',
            'petugas.string' => 'Nama petugas harus berupa teks.',
            'unit.required' => 'Unit pelanggan wajib diisi.',
            'latitude.between' => 'Latitude harus berada di antara -90 dan 90.',
            'longitude.between' => 'Longitude harus berada di antara -180 dan 180.',
        ];
    }
}
