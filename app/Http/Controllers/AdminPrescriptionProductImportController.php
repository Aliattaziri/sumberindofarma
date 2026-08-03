<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminPrescriptionProductImportController extends Controller
{
    /**
     * Download template import produk resep.
     */
    public function downloadTemplate()
    {
        $filename = 'template_import_produk_resep_' . now()->format('Ymd_His') . '.xls';
        $columns = ['SKU', 'PABRIK', 'BRAND', 'NAMA PRODUK', 'SEDIAAN', 'DESKRIPSI', 'HARGA', 'STOK', 'TERJUAL', 'KOMPOSISI', 'INDIKASI', 'KATEGORI'];
        $widths  = [12, 18, 18, 30, 10, 30, 12, 8, 10, 22, 22, 22];

        $rows = [
            ['SKU-001', 'KIMIA FARMA', 'KIMIA FARMA', 'Paracetamol 500mg', 'fls', 'Pereda demam dan nyeri ringan', '5000', '100', '20', 'Paracetamol 500 mg', 'Demam & nyeri', 'OBAT'],
            ['SKU-002', 'WARDAH', 'WARDAH', 'Pelembab Wajah SPF30', 'box', 'Moisturizer ringan untuk kulit sensitif', '85000', '50', '12', 'Aqua, Glycerin, SPF30', 'Melembabkan & melindungi kulit', 'SKINCARE & KOSMETIK'],
            ['SKU-003', 'OMRON', 'OMRON', 'Tensimeter Digital', '', 'Alat pemeriksa tekanan darah portabel', '350000', '20', '5', '-', 'Mengukur tekanan darah', 'ALAT KESEHATAN'],
        ];

        return \App\Helpers\XlsxWriter::downloadSpreadsheetXml($filename, $columns, $rows, $widths);
    }

    /**
     * Tampilkan form import.
     */
    public function showImportForm()
    {
        return view('admin.prescriptions.products.import');
    }

    /**
     * Proses import file CSV / XLS / XLSX.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'max:10240'],
        ], [
            'file.required' => 'File wajib dipilih.',
            'file.max' => 'Ukuran file maksimal 10MB.',
        ]);

        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());
        $content = file_get_contents($file->getRealPath());

        if (!in_array($extension, ['csv', 'xls', 'xlsx', 'txt'], true)) {
            return back()->withErrors(['file' => 'Format file harus CSV/Excel (.csv, .xls, .xlsx).']);
        }

        if ($extension === 'xlsx') {
            return $this->importXlsx($file);
        }

        if (strpos($content, '<Workbook') !== false || strpos($content, 'urn:schemas-microsoft-com:office:spreadsheet') !== false) {
            return $this->importSpreadsheetXml($content, $file->getRealPath());
        }

        return $this->importCsv($file);
    }

    private function importXlsx($file)
    {
        $path = $file->getRealPath();

        if (class_exists('ZipArchive')) {
            return $this->importXlsxViaZip($path);
        }

        return $this->importXlsxViaPhar($path);
    }

    private function importXlsxViaZip(string $path)
    {
        $zip = new \ZipArchive();
        if ($zip->open($path) !== true) {
            return back()->withErrors(['file' => 'File XLSX tidak dapat dibuka.']);
        }

        $sharedStrings = $this->parseSharedStrings($zip->getFromName('xl/sharedStrings.xml') ?: '');
        $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
        $zip->close();

        if ($sheetXml === false) {
            return back()->withErrors(['file' => 'Sheet tidak ditemukan dalam file XLSX.']);
        }

        return $this->processRows($this->parseSheetXml($sheetXml, $sharedStrings));
    }

    private function importXlsxViaPhar(string $path)
    {
        $tmpZip = sys_get_temp_dir() . '/' . uniqid('xlsx_') . '.zip';
        copy($path, $tmpZip);

        try {
            $phar = new \PharData($tmpZip);

            $ssContent = '';
            if (isset($phar['xl/sharedStrings.xml'])) {
                $ssContent = file_get_contents($phar['xl/sharedStrings.xml']->getPathname());
            }

            if (!isset($phar['xl/worksheets/sheet1.xml'])) {
                return back()->withErrors(['file' => 'Sheet tidak ditemukan dalam file XLSX.']);
            }

            $sheetXml = file_get_contents($phar['xl/worksheets/sheet1.xml']->getPathname());
            $sharedStrings = $this->parseSharedStrings($ssContent);

            return $this->processRows($this->parseSheetXml($sheetXml, $sharedStrings));
        } catch (\Exception $e) {
            return back()->withErrors(['file' => 'Gagal membaca XLSX: ' . $e->getMessage() . '. Coba simpan ulang sebagai CSV dari Excel.']);
        } finally {
            @unlink($tmpZip);
        }
    }

    private function importSpreadsheetXml(string $content, ?string $path = null)
    {
        try {
            $content = $this->normalizeXmlContent($content);
            $content = preg_replace('/<\?mso-application[^?]*\?>/i', '', $content);

            libxml_use_internal_errors(true);
            libxml_clear_errors();

            $dom = new \DOMDocument();
            if (!@$dom->loadXML($content, LIBXML_NONET | LIBXML_COMPACT | LIBXML_NOERROR | LIBXML_NOWARNING)) {
                // Fallback parser via PhpSpreadsheet untuk beberapa varian XML Excel.
                $rows = $this->tryParseSpreadsheetXmlWithPhpSpreadsheet($content, $path);
                if (!empty($rows)) {
                    return $this->processRows($rows);
                }

                $firstError = libxml_get_last_error();
                $detail = $firstError ? trim($firstError->message) : '';
                return back()->withErrors(['file' => 'File Excel XML tidak bisa dibaca.' . ($detail !== '' ? ' Detail: ' . $detail : '')]);
            }

            $xpath = new \DOMXPath($dom);
            $rowNodes = $xpath->query('//*[local-name()="Worksheet"]//*[local-name()="Table"]//*[local-name()="Row"]');

            if (!$rowNodes || $rowNodes->length < 2) {
                return back()->withErrors(['file' => 'File Excel kosong atau hanya berisi header.']);
            }

            $rows = [];
            foreach ($rowNodes as $rowNode) {
                $rowData = [];
                $cellNodes = $xpath->query('./*[local-name()="Cell"]', $rowNode);

                foreach ($cellNodes as $cellNode) {
                    $dataNodes = $xpath->query('./*[local-name()="Data"]', $cellNode);
                    $rowData[] = trim((string) ($dataNodes->item(0)?->textContent ?? ''));
                }

                if (!empty(array_filter($rowData))) {
                    $rows[] = $rowData;
                }
            }

            if (count($rows) < 2) {
                return back()->withErrors(['file' => 'File Excel kosong atau hanya berisi header.']);
            }

            return $this->processRows($rows);
        } catch (\Throwable $e) {
            return back()->withErrors(['file' => 'File Excel XML tidak bisa dibaca: ' . $e->getMessage()]);
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors(false);
        }
    }

    private function importCsv($file)
    {
        $content = file_get_contents($file->getRealPath());

        if (mb_detect_encoding($content, ['UTF-16', 'UTF-16LE', 'UTF-16BE'], true)) {
            $content = mb_convert_encoding($content, 'UTF-8', 'UTF-16');
        }

        $content = preg_replace('/^\xEF\xBB\xBF/', '', $content);
        $content = str_replace(["\r\n", "\r"], "\n", $content);
        $lines = array_values(array_filter(explode("\n", $content)));

        if (count($lines) < 2) {
            return back()->withErrors(['file' => 'File kosong atau tidak valid.']);
        }

        $rows = [];
        foreach ($lines as $line) {
            $delimiter = ',';
            if (substr_count($line, ';') > substr_count($line, ',')) {
                $delimiter = ';';
            }
            $row = str_getcsv($line, $delimiter, '"', '\\');
            $row = array_map(fn($v) => trim(preg_replace('/[^\x20-\x7E\xA0-\xFF]/', '', $v)), $row);
            $rows[] = $row;
        }

        return $this->processRows($rows);
    }

    private function normalizeXmlContent(string $content): string
    {
        if (mb_detect_encoding($content, ['UTF-16', 'UTF-16LE', 'UTF-16BE'], true)) {
            $content = mb_convert_encoding($content, 'UTF-8', 'UTF-16');
        } elseif (!mb_check_encoding($content, 'UTF-8')) {
            $detected = mb_detect_encoding($content, ['Windows-1252', 'ISO-8859-1', 'ASCII'], true);
            if ($detected) {
                $content = mb_convert_encoding($content, 'UTF-8', $detected);
            }
        }

        $content = preg_replace('/^\xEF\xBB\xBF/', '', $content);
        // Hapus karakter kontrol invalid XML tapi pertahankan tab/newline/carriage return.
        $content = preg_replace('/[^\x09\x0A\x0D\x20-\x7E\x{80}-\x{10FFFF}]/u', '', $content) ?? $content;

        return $content;
    }

    private function tryParseSpreadsheetXmlWithPhpSpreadsheet(string $content, ?string $path = null): array
    {
        if (!class_exists('PhpOffice\\PhpSpreadsheet\\Reader\\Xml')) {
            return [];
        }

        $tmpPath = null;
        try {
            if ($path !== null && is_file($path)) {
                $loadPath = $path;
            } else {
                $tmpPath = tempnam(sys_get_temp_dir(), 'xml_import_');
                if ($tmpPath === false) {
                    return [];
                }
                file_put_contents($tmpPath, $content);
                $loadPath = $tmpPath;
            }

            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xml();
            $spreadsheet = $reader->load($loadPath);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray('', true, true, false);

            $cleanRows = [];
            foreach ($rows as $row) {
                if (!empty(array_filter($row, fn($v) => trim((string) $v) !== ''))) {
                    $cleanRows[] = array_map(fn($v) => trim((string) $v), $row);
                }
            }

            return $cleanRows;
        } catch (\Throwable $e) {
            return [];
        } finally {
            if ($tmpPath !== null && is_file($tmpPath)) {
                @unlink($tmpPath);
            }
        }
    }

    private function processRows(array $rows)
    {
        if (count($rows) < 2) {
            return back()->withErrors(['file' => 'File kosong atau tidak valid.']);
        }

        $headerIndex = 0;
        foreach ($rows as $i => $row) {
            $normalized = array_map(fn($h) => $this->normalizeHeader($h), $row);
            if (in_array('NAMAPRODUK', $normalized, true) || in_array('NAMA', $normalized, true) || in_array('PRODUK', $normalized, true)) {
                $headerIndex = $i;
                break;
            }
        }

        $header = $rows[$headerIndex] ?? [];
        $headerKeys = array_map(fn($h) => $this->resolveHeaderKey((string) $h), $header);

        if (!in_array('NAMA_PRODUK', $headerKeys, true)) {
            return back()->withErrors([
                'file' => 'Header tidak cocok. Kolom nama produk wajib ada (contoh: NAMA PRODUK).',
            ]);
        }

        $imported = 0;
        $skipped = 0;
        $allowedKategoriProduk = ['OBAT', 'SKINCARE & KOSMETIK', 'ALAT KESEHATAN'];
        $outlet = Auth::user()?->outlet_name;

        DB::beginTransaction();
        try {
            foreach (array_slice($rows, $headerIndex + 1) as $row) {
                $row = array_pad($row, count($header), '');
                $row = array_slice($row, 0, count($header));

                $data = [];
                foreach ($headerKeys as $index => $headerKey) {
                    $data[$headerKey] = $row[$index] ?? '';
                }

                $namaProduk = trim((string) ($data['NAMA_PRODUK'] ?? ''));
                if ($namaProduk === '') {
                    $skipped++;
                    continue;
                }

                $sku = trim((string) ($data['SKU'] ?? ''));
                $pabrik = trim((string) ($data['PABRIK'] ?? ''));
                if ($outlet) {
                    $pabrik = $outlet;
                }
                $brand = trim((string) $this->getValue($data, ['BRAND', 'PABRIK', 'MERK']));
                $harga = $this->parseHarga((string) ($data['HARGA'] ?? '0'));
                $stok = (int) preg_replace('/[^0-9]/', '', (string) ($data['STOK'] ?? '0'));
                $terjual = (int) preg_replace('/[^0-9]/', '', (string) ($data['TERJUAL'] ?? '0'));
                $komposisi = trim((string) ($data['KOMPOSISI'] ?? ''));
                $indikasi = trim((string) ($data['INDIKASI'] ?? ''));
                $deskripsi = trim((string) ($data['DESKRIPSI'] ?? ''));

                $kategoriProdukRaw = strtoupper(trim((string) ($data['KATEGORI'] ?? 'OBAT')));
                $kategoriProduk = in_array($kategoriProdukRaw, $allowedKategoriProduk, true) ? $kategoriProdukRaw : 'OBAT';

                $sediaan = null;
                if (!empty($data['SEDIAAN'])) {
                    $sediaan = strtolower(trim((string) $data['SEDIAAN']));
                    if (!in_array($sediaan, ['fls', 'box'], true)) {
                        $sediaan = null;
                    }
                }

                $deskripsiBagian = array_filter([$deskripsi, $komposisi, $indikasi], fn($v) => $v !== null && trim((string) $v) !== '');
                $finalDeskripsi = !empty($deskripsiBagian) ? implode(' | ', $deskripsiBagian) : $namaProduk;

                $match = !empty($sku)
                    ? ['sku' => $sku, 'kategori' => $pabrik]
                    : ['nama_obat' => $namaProduk, 'kategori' => $pabrik];

                $medicine = Medicine::firstOrNew($match);
                $medicine->sku = $sku ?: null;
                $medicine->nama_obat = $namaProduk;
                $medicine->sediaan = $sediaan;
                $medicine->kategori = $pabrik;
                $medicine->brand = $brand ?: null;
                $medicine->kategori_produk = $kategoriProduk;
                $medicine->harga = $harga;
                $medicine->stok = $stok;
                $medicine->terjual = $terjual;
                $medicine->deskripsi = $finalDeskripsi;
                $medicine->komposisi = $komposisi !== '' ? $komposisi : null;
                $medicine->indikasi = $indikasi !== '' ? $indikasi : null;
                $medicine->is_resep = true;
                $medicine->save();

                $imported++;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['file' => 'Error saat menyimpan data: ' . $e->getMessage()]);
        }

        return redirect()->route('admin.prescription-products.index')
            ->with('success', "Import berhasil: {$imported} produk ditambahkan/diperbarui, {$skipped} baris dilewati.");
    }

    private function parseSharedStrings(string $xml): array
    {
        $sharedStrings = [];
        if ($xml === '') {
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

    private function parseSheetXml(string $sheetXml, array $sharedStrings): array
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

    private function resolveHeaderKey(string $header): string
    {
        $normalized = $this->normalizeHeader($header);

        $aliases = [
            'SKU' => ['SKU', 'KODEPRODUK', 'KODE', 'PRODUCTCODE'],
            'PABRIK' => ['PABRIK', 'PRODUSEN', 'MANUFACTURER'],
            'BRAND' => ['BRAND', 'MERK', 'MEREK'],
            'NAMA_PRODUK' => ['NAMAPRODUK', 'NAMA', 'NAMABARANG', 'PRODUK', 'PRODUCTNAME'],
            'SEDIAAN' => ['SEDIAAN', 'KEMASAN', 'PACKAGING'],
            'DESKRIPSI' => ['DESKRIPSI', 'DESCRIPTION'],
            'HARGA' => ['HARGA', 'RETAIL', 'PRICE'],
            'STOK' => ['STOK', 'STOCK', 'QTY', 'JUMLAH'],
            'TERJUAL' => ['TERJUAL', 'SALES', 'TOTALTERJUAL'],
            'KOMPOSISI' => ['KOMPOSISI', 'COMPOSITION'],
            'INDIKASI' => ['INDIKASI', 'INDICATION', 'MANFAAT'],
            'KATEGORI' => ['KATEGORI', 'KATEGORIPRODUK', 'CATEGORY', 'TIPE', 'JENIS'],
        ];

        foreach ($aliases as $key => $values) {
            if (in_array($normalized, $values, true)) {
                return $key;
            }
        }

        return $normalized;
    }

    private function normalizeHeader(string $header): string
    {
        $value = strtoupper(trim(preg_replace('/[^\x20-\x7E]/', '', $header)));
        return preg_replace('/[^A-Z0-9]+/', '', $value);
    }

    private function getValue(array $data, array $keys): string
    {
        foreach ($keys as $key) {
            if (array_key_exists($key, $data) && $data[$key] !== null && $data[$key] !== '') {
                return (string) $data[$key];
            }
        }

        return '';
    }

    private function parseHarga(string $value): float
    {
        if ($value === '') {
            return 0;
        }

        $value = str_replace(['Rp', 'rp', ' '], '', $value);
        if (str_contains($value, ',')) {
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);
        } else {
            $value = str_replace('.', '', $value);
        }

        return (float) $value;
    }
}
