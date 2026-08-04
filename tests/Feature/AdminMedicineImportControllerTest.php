<?php

namespace Tests\Feature;

use App\Http\Controllers\AdminMedicineImportController;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AdminMedicineImportControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->nullable();
            $table->string('nama_obat');
            $table->string('sediaan')->nullable();
            $table->string('kelompok')->nullable();
            $table->string('kategori')->nullable();
            $table->string('brand')->nullable();
            $table->string('kategori_produk')->nullable();
            $table->decimal('harga', 12, 2)->default(0);
            $table->integer('stok')->default(0);
            $table->integer('terjual')->default(0);
            $table->string('grade')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('komposisi')->nullable();
            $table->text('indikasi')->nullable();
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('medicines');
        parent::tearDown();
    }

    public function test_import_accepts_blank_columns_and_parses_price(): void
    {
        $path = tempnam(sys_get_temp_dir(), 'import');
        file_put_contents($path, "PABRIK,NAMA PRODUK,SEDIAAN,HARGA,STOK,TERJUAL,KOMPOSISI,INDIKASI\nKIMIA FARMA,Paracetamol 500mg,,Rp 12.500, , ,Paracetamol 500 mg,Demam\n");

        $file = new UploadedFile($path, 'test.csv', 'text/csv', null, true);
        $request = new Request();
        $request->setMethod('POST');
        $request->files->set('file', $file);

        $response = (new AdminMedicineImportController())->import($request);

        $this->assertTrue($response->isRedirect());
        $this->assertDatabaseHas('medicines', [
            'nama_obat' => 'Paracetamol 500mg',
            'kategori' => 'KIMIA FARMA',
            'harga' => '12500.00',
        ]);

        @unlink($path);
    }

        public function test_import_excel_xml_keeps_column_alignment_when_cells_are_empty(): void
        {
                $xml = <<<'XML'
<?xml version="1.0"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">
    <Worksheet ss:Name="Sheet1">
        <Table>
            <Row>
                <Cell><Data ss:Type="String">SKU</Data></Cell>
                <Cell><Data ss:Type="String">PABRIK</Data></Cell>
                <Cell><Data ss:Type="String">BRAND</Data></Cell>
                <Cell><Data ss:Type="String">NAMA PRODUK</Data></Cell>
                <Cell><Data ss:Type="String">SEDIAAN</Data></Cell>
                <Cell><Data ss:Type="String">DESKRIPSI</Data></Cell>
                <Cell><Data ss:Type="String">HARGA</Data></Cell>
                <Cell><Data ss:Type="String">STOK</Data></Cell>
                <Cell><Data ss:Type="String">TERJUAL</Data></Cell>
                <Cell><Data ss:Type="String">KOMPOSISI</Data></Cell>
                <Cell><Data ss:Type="String">INDIKASI</Data></Cell>
                <Cell><Data ss:Type="String">KATEGORI</Data></Cell>
            </Row>
            <Row>
                <Cell><Data ss:Type="String">SKU-101</Data></Cell>
                <Cell><Data ss:Type="String">KIMIA FARMA</Data></Cell>
                <Cell><Data ss:Type="String">KALBE</Data></Cell>
                <Cell><Data ss:Type="String">Produk XML</Data></Cell>
                <Cell ss:Index="6"><Data ss:Type="String">Deskripsi XML</Data></Cell>
                <Cell><Data ss:Type="String">12.500</Data></Cell>
                <Cell><Data ss:Type="String">15</Data></Cell>
                <Cell><Data ss:Type="String">2</Data></Cell>
                <Cell><Data ss:Type="String">Komposisi XML</Data></Cell>
                <Cell><Data ss:Type="String">Indikasi XML</Data></Cell>
                <Cell><Data ss:Type="String">OBAT</Data></Cell>
            </Row>
        </Table>
    </Worksheet>
</Workbook>
XML;

                $path = tempnam(sys_get_temp_dir(), 'import_xml');
                file_put_contents($path, $xml);

                $file = new UploadedFile($path, 'test.xls', 'application/vnd.ms-excel', null, true);
                $request = new Request();
                $request->setMethod('POST');
                $request->files->set('file', $file);

                $response = (new AdminMedicineImportController())->import($request);

                $this->assertTrue($response->isRedirect());
                $this->assertDatabaseHas('medicines', [
                        'sku' => 'SKU-101',
                        'nama_obat' => 'Produk XML',
                        'brand' => 'KALBE',
                        'harga' => '12500.00',
                        'stok' => 15,
                        'terjual' => 2,
                ]);

                @unlink($path);
        }
}
