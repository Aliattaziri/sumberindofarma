<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\ProductCategory;
use App\Constants\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminMedicineImportController extends Controller
{
    public function showImportForm()
    {
        return view('admin.medicines.import', [
            'categories' => ProductCategory::getList()
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'max:2048'],
        ]);

        $file = $request->file('file');
        $ext  = strtolower($file->getClientOriginalExtension());

        if (!in_array($ext, ['csv', 'xls', 'xlsx'])) {
            return back()->withErrors(['file' => 'Format harus CSV / XLS / XLSX']);
        }

        if (in_array($ext, ['xls', 'xlsx'])) {
            return $this->importExcel($file);
        }

        return $this->importCsv($file);
    }

    public function downloadTemplate()
    {
        $columns = ['KELOMPOK', 'PABRIK', 'NAMA PRODUK', 'SEDIAAN', 'RETAIL', 'STOK', 'KOMPOSISI', 'INDIKASI', 'GOLONGAN'];
        $widths  = [12, 18, 30, 10, 12, 8, 25, 30, 12];

        $rows = [
            ['PBF',    'KIMIA FARMA', 'Paracetamol 500mg',   'fls', '5000',   '100', 'Paracetamol 500 mg', 'Demam & nyeri',          'BEBAS'],
            ['APOTEK', 'BERNOFARM',   'Aspirin 80mg',        'box', '12000',  '80',  'Aspirin 80 mg',      'Nyeri & demam',          'KERAS'],
            ['PBF',    'OMRON',       'Tensimeter Digital',  '',    '350000', '20',  '-',                  'Mengukur tekanan darah', 'BEBAS'],
        ];

        return \App\Helpers\XlsxWriter::downloadSpreadsheetXml('template_medicines.xls', $columns, $rows, $widths);
    }

    /**
     * =========================
     * CSV IMPORT
     * =========================
     */
    private function importCsv($file)
    {
        $content = file_get_contents($file->getRealPath());

        $content = preg_replace('/^\xEF\xBB\xBF/', '', $content);
        $lines   = array_values(array_filter(explode("\n", $content)));

        if (count($lines) < 2) {
            return back()->withErrors(['file' => 'File kosong']);
        }

        // AUTO DETECT DELIMITER
        $delimiter = str_contains($lines[0], ';') ? ';' : ',';

        $header = array_map(
            fn($h) => strtoupper(trim($h)),
            str_getcsv($lines[0], $delimiter)
        );

        // Normalisasi alias: RETAIL → HARGA
        $header = array_map(fn($h) => $h === 'RETAIL' ? 'HARGA' : $h, $header);

        $required = ['PABRIK', 'NAMA PRODUK'];

        $missing = array_diff($required, $header);

        if (!empty($missing)) {
            return back()->withErrors([
                'file' => 'Header kurang: ' . implode(', ', $missing)
            ]);
        }

        $rows = [];
        foreach (array_slice($lines, 1) as $line) {
            $rows[] = str_getcsv($line, $delimiter);
        }

        return $this->processRows($header, $rows, $delimiter);
    }

    /**
     * =========================
     * EXCEL IMPORT
     * =========================
     */
    private function importExcel($file)
    {
        $content = file_get_contents($file->getRealPath());

        // XML-based Excel (.xls)
        if (strpos($content, '<Workbook') !== false) {
            return $this->importExcelXml($content);
        }

        // Modern XLSX (ZIP/PK format) — parse via ZipArchive
        if (strpos($content, 'PK') === 0) {
            return $this->importXlsx($file->getRealPath());
        }

        return back()->withErrors([
            'file' => 'Format Excel tidak dikenali'
        ]);
    }

    private function importExcelXml(string $content)
    {
        try {
            $content = preg_replace('/^\xEF\xBB\xBF/', '', $content);
            $content = preg_replace('/<\?mso-application[^?]*\?>/i', '', $content);

            $dom = new \DOMDocument();
            if (!@$dom->loadXML($content, LIBXML_NONET | LIBXML_COMPACT)) {
                return back()->withErrors(['file' => 'File rusak atau tidak terbaca']);
            }

            $xpath = new \DOMXPath($dom);
            $rowNodes = $xpath->query('//*[local-name()="Worksheet"]//*[local-name()="Table"]//*[local-name()="Row"]');

            if (!$rowNodes || $rowNodes->length < 2) {
                return back()->withErrors(['file' => 'Data kosong']);
            }

            $rows = [];
            foreach ($rowNodes as $rowNode) {
                $rowData = [];
                $cellNodes = $xpath->query('./*[local-name()="Cell"]', $rowNode);
                $colIndex = 0;

                foreach ($cellNodes as $cellNode) {
                    $indexAttr = $xpath->evaluate('string(@*[local-name()="Index"])', $cellNode);
                    if ($indexAttr !== '') {
                        $targetIndex = max(0, ((int) $indexAttr) - 1);
                        while ($colIndex < $targetIndex) {
                            $rowData[] = '';
                            $colIndex++;
                        }
                    }

                    $value = trim((string) $xpath->evaluate('string(./*[local-name()="Data"])', $cellNode));
                    $rowData[] = $value;
                    $colIndex++;
                }

                if (!empty(array_filter($rowData, fn($v) => $v !== null && $v !== ''))) {
                    $rows[] = $rowData;
                }
            }

            if (count($rows) < 2) {
                return back()->withErrors(['file' => 'Data kosong']);
            }

            $header = array_map(fn($h) => strtoupper(trim($h)), $rows[0]);

            return $this->processRows($header, array_slice($rows, 1));
        } catch (\Throwable $e) {
            return back()->withErrors(['file' => 'File rusak atau tidak terbaca: ' . $e->getMessage()]);
        }
    }

    private function importXlsx(string $path): \Illuminate\Http\RedirectResponse
    {
        if (!class_exists('ZipArchive')) {
            return back()->withErrors(['file' => 'Ekstensi ZipArchive tidak tersedia.']);
        }

        $zip = new \ZipArchive();
        if ($zip->open($path) !== true) {
            return back()->withErrors(['file' => 'File XLSX tidak dapat dibuka.']);
        }

        $sharedStrings = [];
        $sharedStringsXml = $zip->getFromName('xl/sharedStrings.xml');
        if ($sharedStringsXml !== false) {
            $sharedStrings = $this->parseSharedStrings($sharedStringsXml);
        }

        $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
        $zip->close();

        if ($sheetXml === false) {
            return back()->withErrors(['file' => 'Sheet tidak ditemukan dalam file XLSX.']);
        }

        $rows = $this->parseXlsxSheet($sheetXml, $sharedStrings);
        if (count($rows) < 2) {
            return back()->withErrors(['file' => 'Data kosong']);
        }

        $header = array_map(fn($h) => strtoupper(trim($h)), $rows[0]);
        return $this->processRows($header, array_slice($rows, 1));
    }

    private function parseSharedStrings(string $xml): array
    {
        $sharedStrings = [];
        if (empty($xml)) {
            return $sharedStrings;
        }

        $xml = preg_replace('/xmlns[^=]*="[^"]*"/i', '', $xml);
        $ss = @simplexml_load_string($xml);
        if (!$ss) {
            return $sharedStrings;
        }

        foreach ($ss->si as $si) {
            $text = '';
            foreach ($si->r as $r) {
                $text .= (string) $r->t;
            }

            if ($text === '') {
                $text = (string) $si->t;
            }

            $sharedStrings[] = trim($text);
        }

        return $sharedStrings;
    }

    private function parseXlsxSheet(string $sheetXml, array $sharedStrings): array
    {
        $sheetXml = preg_replace('/xmlns[^=]*="[^"]*"/i', '', $sheetXml);
        $sheet = @simplexml_load_string($sheetXml);
        if (!$sheet) {
            return [];
        }

        $rows = [];
        foreach ($sheet->sheetData->row as $row) {
            $rowData = [];
            $lastColIdx = -1;

            foreach ($row->c as $cell) {
                $cellRef = (string) $cell['r'];
                preg_match('/^([A-Z]+)/', $cellRef, $colMatch);
                $colLetters = $colMatch[1] ?? 'A';
                $colIdx = 0;
                foreach (str_split($colLetters) as $ch) {
                    $colIdx = $colIdx * 26 + (ord($ch) - ord('A') + 1);
                }
                $colIdx--;

                while ($lastColIdx < $colIdx - 1) {
                    $rowData[] = '';
                    $lastColIdx++;
                }

                $type = (string) $cell['t'];
                $value = (string) $cell->v;

                if ($type === 's') {
                    $value = $sharedStrings[(int) $value] ?? '';
                } elseif ($type === 'inlineStr') {
                    $value = (string) $cell->is->t;
                }

                $rowData[] = trim($value);
                $lastColIdx = $colIdx;
            }

            if (!empty(array_filter($rowData))) {
                $rows[] = $rowData;
            }
        }

        return $rows;
    }

    private function processRows($header, $rows, $delimiter = ',')
    {
        $rows = array_values(array_filter($rows, function ($row) {
            if (!is_array($row)) {
                return false;
            }

            return !empty(array_filter($row, function ($value) {
                return $value !== null && $value !== '';
            }));
        }));

        if (count($rows) < 1) {
            return back()->withErrors(['file' => 'Data kosong']);
        }

        $header = array_map(function ($h) {
            if ($h === 'RETAIL') {
                return 'HARGA';
            }
            return strtoupper(trim((string) $h));
        }, $header);

        $required = ['PABRIK', 'NAMA PRODUK'];
        $missing = array_diff($required, $header);

        if (!empty($missing)) {
            return back()->withErrors([
                'file' => 'Header kurang: ' . implode(', ', $missing)
            ]);
        }

        DB::beginTransaction();

        try {
            foreach ($rows as $row) {
                $padded = array_pad(array_slice($row, 0, count($header)), count($header), '');
                $data = array_combine($header, $padded);
                $data = array_map('trim', $data);

                if (empty($data['NAMA PRODUK'])) {
                    continue;
                }

                $harga = $this->parseHarga($data['HARGA'] ?? '0');
                $stok = (int) preg_replace('/[^0-9]/', '', $data['STOK'] ?? '0');
                $terjual = (int) preg_replace('/[^0-9]/', '', $data['TERJUAL'] ?? '0');
                $sku = !empty($data['SKU']) ? $data['SKU'] : null;
                $golongan = strtoupper($data['GOLONGAN'] ?? '');
                $isResep = $golongan === 'KERAS';
                $sediaan = !empty($data['SEDIAAN']) ? strtolower($data['SEDIAAN']) : null;

                $kelompok = null;
                if (!empty($data['KELOMPOK'])) {
                    $k = strtoupper($data['KELOMPOK']);
                    if (in_array($k, ['PBF', 'APOTEK'])) {
                        $kelompok = $k;
                    }
                }

                $kategoriProduk = !empty($data['KATEGORI'])
                    ? ProductCategory::ensureExists($data['KATEGORI'])
                    : null;

                $parts = array_filter(array_map('trim', [
                    $data['DESKRIPSI'] ?? '',
                    $data['KOMPOSISI'] ?? '',
                    $data['INDIKASI'] ?? '',
                ]));
                $deskripsi = !empty($parts) ? implode(' | ', $parts) : $data['NAMA PRODUK'];

                $updateData = [
                    'sku' => $sku,
                    'kelompok' => $kelompok,
                    'kategori' => $data['PABRIK'],
                    'kategori_produk' => $kategoriProduk,
                    'brand' => !empty($data['BRAND']) ? $data['BRAND'] : $data['PABRIK'],
                    'sediaan' => $sediaan,
                    'harga' => $harga,
                    'stok' => $stok,
                    'terjual' => $terjual,
                    'deskripsi' => $deskripsi,
                    'komposisi' => !empty($data['KOMPOSISI']) ? $data['KOMPOSISI'] : null,
                    'indikasi' => !empty($data['INDIKASI']) ? $data['INDIKASI'] : null,
                    'is_resep' => $isResep,
                    'is_grosir' => false,
                ];

                if (empty(trim($updateData['deskripsi'] ?? ''))) {
                    $updateData['deskripsi'] = $data['NAMA PRODUK'];
                }

                Medicine::updateOrCreate([
                    'nama_obat' => $data['NAMA PRODUK'],
                    'kelompok' => $kelompok ?? '',
                ], $updateData);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['file' => 'Error: ' . $e->getMessage()]);
        }

        return redirect()->route('admin.medicines.index')
            ->with('success', 'Import berhasil');
    }


    /**
     * =========================
     * PARSE HARGA (INDONESIA FORMAT)
     * =========================
     */
    private function parseHarga($value)
    {
        if (!$value) return 0;

        $value = str_replace(['Rp', 'rp', ' '], '', $value);

        if (str_contains($value, ',')) {
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);
        } else {
            $value = str_replace('.', '', $value);
        }

        return (float) $value;
    }

    /**
     * =========================
     * VALIDATION (opsional, tidak memblokir baris)
     * =========================
     */
    private function validateRow($data, $line)
    {
        $err = [];

        if (empty($data['PABRIK']))
            $err[] = "Baris {$line}: PABRIK kosong";

        return $err;
    }
}