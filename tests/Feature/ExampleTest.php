<?php

namespace Tests\Feature;

use App\Models\Pelanggan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_homepage_renders_the_login_screen(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('Masuk ke SIMPP')
            ->assertSee('Username')
            ->assertSee('Kata sandi');
    }

    public function test_the_dashboard_renders(): void
    {
        $this->get('/dashboard')
            ->assertOk()
            ->assertSee('Ringkasan Operasional')
            ->assertSee('Tagihan Bulan Ini');
    }

    public function test_data_pelanggan_page_directly_lists_customers_and_create_action(): void
    {
        $customer = Pelanggan::factory()->create([
            'id_pelanggan' => '221400000057',
            'nama' => 'Pelanggan Uji',
        ]);

        $this->get(route('pelanggan.index'))
            ->assertOk()
            ->assertSee('Daftar Pelanggan')
            ->assertSee('Pelanggan Uji')
            ->assertSee('Tambah Pelanggan')
            ->assertSee(route('pelanggan.show', $customer));
    }

    public function test_customer_can_be_created_from_the_customer_page(): void
    {
        $response = $this->post(route('pelanggan.store'), [
            'id_pelanggan' => '221400000057',
            'nama' => 'Pelanggan Baru',
            'petugas' => 'Petugas Baru',
            'unit' => '22140',
            'nomor_telepon' => '081234567890',
            'alamat' => 'Jalan Pelanggan 10',
            'latitude' => '-3.8000000',
            'longitude' => '114.8000000',
            'status' => 'aktif',
        ]);

        $customer = Pelanggan::query()->where('id_pelanggan', '221400000057')->firstOrFail();

        $response->assertRedirect(route('pelanggan.show', $customer));
        $this->assertDatabaseHas('pelanggan', [
            'id_pelanggan' => '221400000057',
            'nama' => 'Pelanggan Baru',
            'petugas' => 'Petugas Baru',
            'alamat' => 'Jalan Pelanggan 10',
        ]);
    }

    public function test_customer_id_must_be_unique(): void
    {
        Pelanggan::factory()->create(['id_pelanggan' => '221400000057']);

        $this->from(route('pelanggan.index'))
            ->post(route('pelanggan.store'), [
                'id_pelanggan' => '221400000057',
                'nama' => 'Duplikat',
                'unit' => '22140',
                'status' => 'aktif',
            ])
            ->assertRedirect(route('pelanggan.index'))
            ->assertSessionHasErrors([
                'id_pelanggan' => 'ID pelanggan tersebut sudah terdaftar.',
            ]);

        $this->assertDatabaseCount('pelanggan', 1);
    }

    public function test_customer_detail_contains_update_and_delete_actions(): void
    {
        $customer = Pelanggan::factory()->create();

        $this->get(route('pelanggan.show', $customer))
            ->assertOk()
            ->assertSee('Simpan Perubahan')
            ->assertSee('Hapus Pelanggan')
            ->assertSee($customer->id_pelanggan);
    }

    public function test_customer_details_can_be_updated_and_deleted(): void
    {
        $customer = Pelanggan::factory()->create([
            'id_pelanggan' => '221400000057',
            'nama' => 'Nama Lama',
        ]);

        $this->put(route('pelanggan.update', $customer), [
            'id_pelanggan' => '221400000057',
            'nama' => 'Nama Baru',
            'petugas' => 'Petugas Baru',
            'unit' => '22140',
            'nomor_telepon' => '081234567890',
            'alamat' => 'Alamat Baru',
            'latitude' => null,
            'longitude' => null,
            'status' => 'nonaktif',
        ])
            ->assertRedirect(route('pelanggan.show', $customer));

        $this->assertDatabaseHas('pelanggan', [
            'id' => $customer->id,
            'nama' => 'Nama Baru',
            'petugas' => 'Petugas Baru',
            'alamat' => 'Alamat Baru',
            'status' => 'nonaktif',
        ]);

        $this->delete(route('pelanggan.destroy', $customer))
            ->assertRedirect(route('pelanggan.index'));

        $this->assertDatabaseMissing('pelanggan', ['id' => $customer->id]);
    }

    public function test_customer_location_page_links_to_saved_coordinates(): void
    {
        Pelanggan::factory()->create([
            'latitude' => '-3.8000000',
            'longitude' => '114.8000000',
        ]);

        $this->get(route('pelanggan.locations'))
            ->assertOk()
            ->assertSee('Lokasi Pelanggan')
            ->assertSee('https://www.google.com/maps?q=-3.8,114.8');
    }

    public function test_csv_customer_import_persists_valid_rows(): void
    {
        $file = UploadedFile::fake()->createWithContent(
            'customers.csv',
            "id_pelanggan,nama,unit,nomor_telepon,alamat,status\n221400000057,Pelanggan CSV,22140,081234567890,Jalan Contoh,aktif\n",
        );

        $this->post(route('pelanggan.import'), ['file' => $file])
            ->assertRedirect(route('pelanggan.import.form'))
            ->assertSessionHas('status', '1 pelanggan berhasil diimpor.');

        $this->assertDatabaseHas('pelanggan', [
            'id_pelanggan' => '221400000057',
            'nama' => 'Pelanggan CSV',
            'alamat' => 'Jalan Contoh',
        ]);
    }

    public function test_csv_customer_import_rejects_existing_ids_without_partial_import(): void
    {
        Pelanggan::factory()->create(['id_pelanggan' => '221400000057']);
        $file = UploadedFile::fake()->createWithContent(
            'customers.csv',
            "id_pelanggan,nama\n221400000057,Pelanggan Duplikat\n221400000058,Pelanggan Baru\n",
        );

        $this->from(route('pelanggan.import.form'))
            ->post(route('pelanggan.import'), ['file' => $file])
            ->assertRedirect(route('pelanggan.import.form'))
            ->assertSessionHasErrors([
                'file' => 'Sebagian ID pelanggan di file sudah terdaftar. Hapus atau perbarui datanya terlebih dahulu.',
            ]);

        $this->assertDatabaseMissing('pelanggan', ['id_pelanggan' => '221400000058']);
        $this->assertDatabaseCount('pelanggan', 1);
    }

    public function test_xlsx_import_saves_petugas_and_restores_coordinate_decimals(): void
    {
        $file = $this->createCustomerWorkbook([
            [
                'petugas' => 'Petugas Uji',
                'id_pelanggan' => '221400000057',
                'nomor_telepon' => '081234567890',
                'latitude' => '-36738933',
                'longitude' => '11461474',
                'tanggal' => '2026-11-24',
                'status' => 'JANJI BAYAR',
            ],
        ]);

        $this->post(route('pelanggan.import'), ['file' => $file])
            ->assertRedirect(route('pelanggan.import.form'))
            ->assertSessionHas('status', '1 pelanggan berhasil diimpor.');

        $this->assertDatabaseHas('pelanggan', [
            'id_pelanggan' => '221400000057',
            'nama' => null,
            'petugas' => 'Petugas Uji',
            'nomor_telepon' => '081234567890',
            'latitude' => '-3.6738933',
            'longitude' => '114.6147400',
            'status' => 'aktif',
        ]);
    }

    public function test_invalid_xlsx_upload_returns_a_file_error(): void
    {
        $file = UploadedFile::fake()->createWithContent('customers.xlsx', 'not an XLSX archive');

        $this->from(route('pelanggan.import.form'))
            ->post(route('pelanggan.import'), ['file' => $file])
            ->assertRedirect(route('pelanggan.import.form'))
            ->assertSessionHasErrors('file');

        $this->assertDatabaseCount('pelanggan', 0);
    }

    public function test_customer_notification_opens_whatsapp_with_a_prefilled_message(): void
    {
        Pelanggan::factory()->create([
            'id_pelanggan' => '221400000057',
            'nama' => 'Pelanggan Uji',
            'nomor_telepon' => '081234567890',
            'status' => 'aktif',
        ]);

        $this->get(route('pelanggan.notifications'))
            ->assertOk()
            ->assertSee('Pelanggan Uji')
            ->assertSee('https://wa.me/6281234567890?text=', false)
            ->assertSee('Kirim melalui WhatsApp');
    }

    public function test_customers_without_names_have_a_safe_display_and_notification_greeting(): void
    {
        Pelanggan::factory()->create([
            'nama' => null,
            'nomor_telepon' => '081234567890',
        ]);

        $this->get(route('pelanggan.index'))
            ->assertOk()
            ->assertSee('Nama belum dilengkapi');

        $this->get(route('pelanggan.notifications'))
            ->assertOk()
            ->assertSee('text=Yth.%20Pelanggan%2C', false);
    }

    public function test_legacy_customer_edit_page_redirects_to_customer_management(): void
    {
        $this->get('/pelanggan/edit')
            ->assertRedirect(route('pelanggan.index'));

        $this->get(route('pelanggan.manage'))
            ->assertRedirect(route('pelanggan.index'));
    }

    /**
     * @param  array<int, array<string, string>>  $records
     */
    private function createCustomerWorkbook(array $records): UploadedFile
    {
        $namespace = 'http://schemas.openxmlformats.org/spreadsheetml/2006/main';
        $strings = ['PETUGAS', 'IDPEL', 'NOMOR HP', 'X', 'Y', 'TGL ANTAR', 'STATUS'];

        foreach ($records as $record) {
            $strings[] = $record['petugas'];
            $strings[] = $record['id_pelanggan'];
            $strings[] = $record['nomor_telepon'];
            $strings[] = $record['tanggal'];
            $strings[] = $record['status'];
        }

        $stringIndexes = array_flip($strings);
        $sharedStrings = '<sst xmlns="'.$namespace.'" count="'.count($strings).'" uniqueCount="'.count($strings).'">';

        foreach ($strings as $value) {
            $sharedStrings .= '<si><t>'.htmlspecialchars($value, ENT_XML1).'</t></si>';
        }

        $sharedStrings .= '</sst>';

        $worksheet = '<worksheet xmlns="'.$namespace.'"><sheetData>';
        $headers = ['PETUGAS', 'IDPEL', 'NOMOR HP', 'X', 'Y', 'TGL ANTAR', 'STATUS'];

        $worksheet .= '<row r="1">';

        foreach ($headers as $index => $header) {
            $column = chr(65 + $index);
            $worksheet .= '<c r="'.$column.'1" t="s"><v>'.$stringIndexes[$header].'</v></c>';
        }

        $worksheet .= '</row>';

        foreach ($records as $index => $record) {
            $rowNumber = $index + 2;
            $worksheet .= '<row r="'.$rowNumber.'">';
            $values = [
                $record['petugas'],
                $record['id_pelanggan'],
                $record['nomor_telepon'],
                $record['latitude'],
                $record['longitude'],
                $record['tanggal'],
                $record['status'],
            ];

            foreach ($values as $columnIndex => $value) {
                $column = chr(65 + $columnIndex);
                $cellType = $columnIndex === 3 || $columnIndex === 4 ? '' : ' t="s"';
                $cellValue = $cellType === '' ? $value : $stringIndexes[$value];
                $worksheet .= '<c r="'.$column.$rowNumber.'"'.$cellType.'><v>'.$cellValue.'</v></c>';
            }

            $worksheet .= '</row>';
        }

        $worksheet .= '</sheetData></worksheet>';
        $workbook = '<?xml version="1.0" encoding="UTF-8"?>'
            .'<workbook xmlns="'.$namespace.'" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            .'<sheets><sheet name="Sheet1" sheetId="1" r:id="rId1"/></sheets></workbook>';
        $relationships = '<?xml version="1.0" encoding="UTF-8"?>'
            .'<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            .'<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
            .'</Relationships>';
        $zipPath = sys_get_temp_dir().DIRECTORY_SEPARATOR.'customer-import-'.bin2hex(random_bytes(6)).'.zip';

        try {
            $archive = new \PharData($zipPath, 0, null, \Phar::ZIP);
            $archive['xl/workbook.xml'] = $workbook;
            $archive['xl/_rels/workbook.xml.rels'] = $relationships;
            $archive['xl/sharedStrings.xml'] = $sharedStrings;
            $archive['xl/worksheets/sheet1.xml'] = $worksheet;
            unset($archive);

            $content = file_get_contents($zipPath);
        } finally {
            if (is_file($zipPath)) {
                unlink($zipPath);
            }
        }

        return UploadedFile::fake()->createWithContent('customers.xlsx', $content);
    }
}
