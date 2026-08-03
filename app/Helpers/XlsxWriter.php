<?php

namespace App\Helpers;

/**
 * XlsxWriter — Generate XLSX file murni (ZIP + XML) tanpa library eksternal.
 * Terbuka langsung rapi di Excel tanpa warning apapun.
 */
class XlsxWriter
{
    /**
     * Generate XLSX dan kembalikan sebagai HTTP response download.
     *
     * @param  string  $filename   Nama file tanpa path, misal "template_produk.xlsx"
     * @param  array   $headers    Array string kolom header baris pertama
     * @param  array   $rows       Array of array data baris
     * @param  array   $widths     Optional lebar kolom dalam karakter (default 20)
     * @return \Illuminate\Http\Response
     */
    public static function download(
        string $filename,
        array  $headers,
        array  $rows,
        array  $widths = []
    ) {
        // Prefer the minimal XLSX builder first because it is the most
        // deterministic across browsers, VS Code preview, and Excel imports.
        $xlsx = self::build($headers, $rows, $widths);

        if ($xlsx === null) {
            $xlsx = self::buildWithNativeExcel($headers, $rows, $widths);
        }

        if ($xlsx === null) {
            $xlsx = self::buildPhpSpreadsheet($headers, $rows, $widths);
        }

        return response($xlsx, 200, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Content-Length'      => strlen($xlsx),
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'no-store, no-cache, must-revalidate, max-age=0, post-check=0, pre-check=0',
            'Expires'             => '0',
            'Last-Modified'       => gmdate('D, d M Y H:i:s') . ' GMT',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    /**
     * Build a native XLSX with PhpSpreadsheet.
     */
    private static function buildPhpSpreadsheet(array $headers, array $rows, array $widths = []): ?string
    {
        if (!class_exists('PhpOffice\\PhpSpreadsheet\\Spreadsheet')) {
            return null;
        }

        try {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Template');

            $headerFill = [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E5E7EB'],
            ];

            $borderStyle = [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['rgb' => 'D1D5DB'],
            ];

            $headerRow = 1;
            foreach ($headers as $index => $header) {
                $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
                $cell = $columnLetter . $headerRow;
                $sheet->setCellValue($cell, $header);
                $sheet->getStyle($cell)->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => '1F2937']],
                    'fill' => $headerFill,
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                    'borders' => [
                        'top' => $borderStyle,
                        'bottom' => $borderStyle,
                        'left' => $borderStyle,
                        'right' => $borderStyle,
                    ],
                ]);
            }

            $sheet->getRowDimension(1)->setRowHeight(28);

            foreach ($rows as $rowIndex => $row) {
                $excelRow = $rowIndex + 2;
                $sheet->getRowDimension($excelRow)->setRowHeight(48);

                foreach ($headers as $columnIndex => $header) {
                    $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($columnIndex + 1);
                    $cell = $columnLetter . $excelRow;
                    $value = $row[$columnIndex] ?? '';
                    $sheet->setCellValueExplicit($cell, (string) $value, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);

                    $style = [
                        'font' => ['color' => ['rgb' => '4B5563']],
                        'alignment' => [
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                            'wrapText' => true,
                        ],
                        'borders' => [
                            'top' => $borderStyle,
                            'bottom' => $borderStyle,
                            'left' => $borderStyle,
                            'right' => $borderStyle,
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'FFFFFF'],
                        ],
                    ];

                    if ($columnIndex === 6 || $columnIndex === 7 || $columnIndex === 8) {
                        $style['alignment']['horizontal'] = \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER;
                    }

                    if ($columnIndex === 11) {
                        $kategori = strtoupper(trim((string) $value));
                        $style['font']['bold'] = true;
                        $style['alignment']['horizontal'] = \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER;

                        if ($kategori === 'OBAT') {
                            $style['font']['color'] = ['rgb' => '991B1B'];
                            $style['fill']['startColor'] = ['rgb' => 'FEE2E2'];
                        } elseif ($kategori === 'SKINCARE & KOSMETIK') {
                            $style['font']['color'] = ['rgb' => 'BE185D'];
                            $style['fill']['startColor'] = ['rgb' => 'FCE7F3'];
                        } elseif ($kategori === 'ALAT KESEHATAN') {
                            $style['font']['color'] = ['rgb' => 'B91C1C'];
                            $style['fill']['startColor'] = ['rgb' => 'FEF2F2'];
                        }
                    }

                    $sheet->getStyle($cell)->applyFromArray($style);
                }
            }

            foreach ($headers as $index => $header) {
                $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1);
                $sheet->getColumnDimension($columnLetter)->setWidth($widths[$index] ?? 20);
            }

            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $tempPath = tempnam(sys_get_temp_dir(), 'xlsx_');
            if ($tempPath === false) {
                return null;
            }

            $xlsxPath = $tempPath . '.xlsx';
            @unlink($tempPath);
            $writer->save($xlsxPath);
            $binary = file_get_contents($xlsxPath);

            @unlink($xlsxPath);
            $spreadsheet->disconnectWorksheets();

            return $binary !== false ? $binary : null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Build a real XLSX through Excel COM automation on Windows.
     * Returns null when Excel automation is unavailable.
     */
    private static function buildWithNativeExcel(array $headers, array $rows, array $widths = []): ?string
    {
        if (PHP_OS_FAMILY !== 'Windows' || !function_exists('shell_exec')) {
            return null;
        }

        $tempBase   = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'xlsx_' . uniqid();
        $jsonPath   = $tempBase . '.json';
        $scriptPath = $tempBase . '.ps1';
        $outputPath = $tempBase . '.xlsx';

        $payload = [
            'sheetName' => 'Template',
            'headers'   => array_values($headers),
            'rows'      => array_values($rows),
            'widths'    => array_values($widths),
        ];

        file_put_contents($jsonPath, json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        $script = <<<'PS1'
param(
    [string]$JsonPath,
    [string]$OutputPath
)

$ErrorActionPreference = 'Stop';
Add-Type -AssemblyName System.Drawing;

$payload = Get-Content -LiteralPath $JsonPath -Raw | ConvertFrom-Json;
$excel = $null;
$workbook = $null;
$sheet = $null;

try {
    $excel = New-Object -ComObject Excel.Application;
    $excel.Visible = $false;
    $excel.DisplayAlerts = $false;
    $excel.ScreenUpdating = $false;

    $workbook = $excel.Workbooks.Add();
    $sheet = $workbook.Worksheets.Item(1);
    $sheet.Name = [string]$payload.sheetName;

    $headerColor = [System.Drawing.ColorTranslator]::ToOle([System.Drawing.Color]::FromArgb(229, 231, 235));
    $headerTextColor = [System.Drawing.ColorTranslator]::ToOle([System.Drawing.Color]::FromArgb(31, 41, 55));
    $bodyTextColor = [System.Drawing.ColorTranslator]::ToOle([System.Drawing.Color]::FromArgb(75, 85, 99));
    $borderColor = [System.Drawing.ColorTranslator]::ToOle([System.Drawing.Color]::FromArgb(209, 213, 219));
    $obatFill = [System.Drawing.ColorTranslator]::ToOle([System.Drawing.Color]::FromArgb(254, 226, 226));
    $obatFont = [System.Drawing.ColorTranslator]::ToOle([System.Drawing.Color]::FromArgb(153, 27, 27));
    $skincareFill = [System.Drawing.ColorTranslator]::ToOle([System.Drawing.Color]::FromArgb(252, 231, 243));
    $skincareFont = [System.Drawing.ColorTranslator]::ToOle([System.Drawing.Color]::FromArgb(190, 24, 93));
    $alatFill = [System.Drawing.ColorTranslator]::ToOle([System.Drawing.Color]::FromArgb(254, 242, 242));
    $alatFont = [System.Drawing.ColorTranslator]::ToOle([System.Drawing.Color]::FromArgb(185, 28, 28));

    $columnCount = [int]$payload.headers.Count;
    for ($index = 0; $index -lt $columnCount; $index++) {
        $sheet.Columns.Item($index + 1).ColumnWidth = [double]$payload.widths[$index];
    }

    for ($index = 0; $index -lt $columnCount; $index++) {
        $cell = $sheet.Cells.Item(1, $index + 1);
        $cell.Value2 = [string]$payload.headers[$index];
    }

    $headerRange = $sheet.Range($sheet.Cells.Item(1, 1), $sheet.Cells.Item(1, $columnCount));
    $headerRange.Font.Bold = $true;
    $headerRange.Font.Color = $headerTextColor;
    $headerRange.Interior.Color = $headerColor;
    $headerRange.WrapText = $true;
    $headerRange.HorizontalAlignment = -4108;
    $headerRange.VerticalAlignment = -4108;
    $headerRange.Borders.LineStyle = 1;
    $headerRange.Borders.Weight = 2;
    $sheet.Rows.Item(1).RowHeight = 28;

    for ($rowIndex = 0; $rowIndex -lt $payload.rows.Count; $rowIndex++) {
        $excelRow = $rowIndex + 2;
        $row = $payload.rows[$rowIndex];
        $sheet.Rows.Item($excelRow).RowHeight = 48;

        for ($colIndex = 0; $colIndex -lt $columnCount; $colIndex++) {
            $value = '';
            if ($colIndex -lt $row.Count) {
                $value = [string]$row[$colIndex];
            }

            $cell = $sheet.Cells.Item($excelRow, $colIndex + 1);
            $cell.Value2 = $value;
            $cell.Font.Color = $bodyTextColor;
            $cell.VerticalAlignment = -4108;
            $cell.WrapText = $true;
            $cell.Borders.LineStyle = 1;
            $cell.Borders.Weight = 2;
            $cell.Borders.Color = $borderColor;

            if ($colIndex -eq 6 -or $colIndex -eq 7 -or $colIndex -eq 8) {
                $numeric = 0;
                if ([double]::TryParse($value, [ref]$numeric)) {
                    $cell.Value2 = $numeric;
                    $cell.HorizontalAlignment = -4108;
                    $cell.NumberFormat = '0';
                }
            }

            if ($colIndex -eq 11) {
                if ([string]::IsNullOrWhiteSpace($value)) {
                    $kategori = '';
                } else {
                    $kategori = $value.Trim().ToUpperInvariant();
                }
                $cell.HorizontalAlignment = -4108;
                $cell.WrapText = $true;
                switch ($kategori) {
                    'OBAT' {
                        $cell.Interior.Color = $obatFill;
                        $cell.Font.Bold = $true;
                        $cell.Font.Color = $obatFont;
                    }
                    'SKINCARE & KOSMETIK' {
                        $cell.Interior.Color = $skincareFill;
                        $cell.Font.Bold = $true;
                        $cell.Font.Color = $skincareFont;
                    }
                    'ALAT KESEHATAN' {
                        $cell.Interior.Color = $alatFill;
                        $cell.Font.Bold = $true;
                        $cell.Font.Color = $alatFont;
                    }
                }
            }
        }
    }

    $workbook.SaveAs($OutputPath, 51);
    $workbook.Close($false);
    $excel.Quit();

    return $OutputPath;
}
finally {
    if ($sheet -ne $null) {
        [System.Runtime.InteropServices.Marshal]::ReleaseComObject($sheet) | Out-Null;
    }
    if ($workbook -ne $null) {
        [System.Runtime.InteropServices.Marshal]::ReleaseComObject($workbook) | Out-Null;
    }
    if ($excel -ne $null) {
        [System.Runtime.InteropServices.Marshal]::ReleaseComObject($excel) | Out-Null;
    }
    if (Test-Path -LiteralPath $JsonPath) {
        Remove-Item -LiteralPath $JsonPath -Force;
    }
    if (Test-Path -LiteralPath $OutputPath) {
        # keep file for caller
    }
}
PS1;

        file_put_contents($scriptPath, $script);

        $command = 'powershell -NoProfile -Sta -ExecutionPolicy Bypass -File ' . escapeshellarg($scriptPath)
            . ' -JsonPath ' . escapeshellarg($jsonPath)
            . ' -OutputPath ' . escapeshellarg($outputPath);

        $output = shell_exec($command);

        @unlink($scriptPath);

        if (!file_exists($outputPath) || filesize($outputPath) === 0) {
            @unlink($jsonPath);
            @unlink($outputPath);
            return null;
        }

        $xlsx = file_get_contents($outputPath);
        @unlink($jsonPath);
        @unlink($outputPath);

        return $xlsx !== false ? $xlsx : null;
    }

    /**
     * Generate SpreadsheetML (.xls XML) dan kembalikan sebagai HTTP response download.
     */
    public static function downloadSpreadsheetXml(
        string $filename,
        array  $headers,
        array  $rows,
        array  $widths = []
    ) {
        $xml = self::buildSpreadsheetXml($headers, $rows, $widths);

        return response($xml, 200, [
            'Content-Type'        => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Content-Length'      => strlen($xml),
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ]);
    }

    /**
     * Build SpreadsheetML XML string.
     */
    public static function buildSpreadsheetXml(array $headers, array $rows, array $widths = []): string
    {
        $escape = static fn($value) => htmlspecialchars((string) $value, ENT_XML1 | ENT_QUOTES, 'UTF-8');
        $normalize = static fn($value) => strtoupper(trim((string) $value));

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<?mso-application progid="Excel.Sheet"?>';
        $xml .= '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"';
        $xml .= ' xmlns:o="urn:schemas-microsoft-com:office:office"';
        $xml .= ' xmlns:x="urn:schemas-microsoft-com:office:excel"';
        $xml .= ' xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">';

        $xml .= '<Styles>';
        $xml .= '<Style ss:ID="Default" ss:Name="Normal">';
        $xml .= '<Alignment ss:Vertical="Center" ss:WrapText="1"/>';
        $xml .= '<Font ss:FontName="Calibri" ss:Size="11"/>';
        $xml .= '<Borders>';
        $xml .= '<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D1D5DB"/>';
        $xml .= '<Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D1D5DB"/>';
        $xml .= '<Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D1D5DB"/>';
        $xml .= '<Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D1D5DB"/>';
        $xml .= '</Borders>';
        $xml .= '<Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/>';
        $xml .= '<NumberFormat/>';
        $xml .= '<Protection/>';
        $xml .= '</Style>';
        $xml .= '<Style ss:ID="Header">';
        $xml .= '<Font ss:Bold="1" ss:Color="#1F2937"/>';
        $xml .= '<Interior ss:Color="#E5E7EB" ss:Pattern="Solid"/>';
        $xml .= '<Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>';
        $xml .= '<Borders>';
        $xml .= '<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D1D5DB"/>';
        $xml .= '<Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D1D5DB"/>';
        $xml .= '<Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D1D5DB"/>';
        $xml .= '<Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D1D5DB"/>';
        $xml .= '</Borders>';
        $xml .= '</Style>';
        $xml .= '<Style ss:ID="Body">';
        $xml .= '<Alignment ss:Vertical="Center" ss:WrapText="1"/>';
        $xml .= '<Font ss:FontName="Calibri" ss:Size="11" ss:Color="#4B5563"/>';
        $xml .= '<Borders>';
        $xml .= '<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D1D5DB"/>';
        $xml .= '<Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D1D5DB"/>';
        $xml .= '<Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D1D5DB"/>';
        $xml .= '<Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D1D5DB"/>';
        $xml .= '</Borders>';
        $xml .= '<Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/>';
        $xml .= '</Style>';
        $xml .= '<Style ss:ID="Number">';
        $xml .= '<Alignment ss:Horizontal="Center" ss:Vertical="Center"/>';
        $xml .= '<Font ss:FontName="Calibri" ss:Size="11" ss:Color="#4B5563"/>';
        $xml .= '<Borders>';
        $xml .= '<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D1D5DB"/>';
        $xml .= '<Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D1D5DB"/>';
        $xml .= '<Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D1D5DB"/>';
        $xml .= '<Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D1D5DB"/>';
        $xml .= '</Borders>';
        $xml .= '<Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/>';
        $xml .= '</Style>';
        $xml .= '<Style ss:ID="CategoryObat">';
        $xml .= '<Font ss:Bold="1" ss:Color="#991B1B"/>';
        $xml .= '<Interior ss:Color="#FEE2E2" ss:Pattern="Solid"/>';
        $xml .= '<Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>';
        $xml .= '<Borders>';
        $xml .= '<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D1D5DB"/>';
        $xml .= '<Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D1D5DB"/>';
        $xml .= '<Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D1D5DB"/>';
        $xml .= '<Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D1D5DB"/>';
        $xml .= '</Borders>';
        $xml .= '</Style>';
        $xml .= '<Style ss:ID="CategorySkincare">';
        $xml .= '<Font ss:Bold="1" ss:Color="#BE185D"/>';
        $xml .= '<Interior ss:Color="#FCE7F3" ss:Pattern="Solid"/>';
        $xml .= '<Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>';
        $xml .= '<Borders>';
        $xml .= '<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D1D5DB"/>';
        $xml .= '<Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D1D5DB"/>';
        $xml .= '<Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D1D5DB"/>';
        $xml .= '<Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D1D5DB"/>';
        $xml .= '</Borders>';
        $xml .= '</Style>';
        $xml .= '<Style ss:ID="CategoryAlat">';
        $xml .= '<Font ss:Bold="1" ss:Color="#B91C1C"/>';
        $xml .= '<Interior ss:Color="#FEF2F2" ss:Pattern="Solid"/>';
        $xml .= '<Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>';
        $xml .= '<Borders>';
        $xml .= '<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D1D5DB"/>';
        $xml .= '<Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D1D5DB"/>';
        $xml .= '<Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D1D5DB"/>';
        $xml .= '<Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#D1D5DB"/>';
        $xml .= '</Borders>';
        $xml .= '</Style>';
        $xml .= '</Styles>';

        $xml .= '<Worksheet ss:Name="Template">';
        $xml .= '<Table>';

        foreach ($headers as $ci => $header) {
            $width = $widths[$ci] ?? 20;
            $xml .= '<Column ss:Width="' . (float) $width . '"/>';
        }

        $xml .= '<Row ss:AutoFitHeight="0" ss:Height="24">';
        foreach ($headers as $header) {
            $xml .= '<Cell ss:StyleID="Header"><Data ss:Type="String">' . $escape($header) . '</Data></Cell>';
        }
        $xml .= '</Row>';

        foreach ($rows as $row) {
            $xml .= '<Row ss:AutoFitHeight="0" ss:Height="48">';
            foreach ($headers as $index => $header) {
                $value = $row[$index] ?? '';
                $type  = is_numeric($value) ? 'Number' : 'String';
                $style = 'Body';

                if ($index === 6) {
                    $style = 'Number';
                } elseif ($index === 7 || $index === 8) {
                    $style = 'Number';
                } elseif ($index === 11) {
                    $kategori = $normalize($value);
                    if ($kategori === 'OBAT') {
                        $style = 'CategoryObat';
                    } elseif ($kategori === 'SKINCARE & KOSMETIK') {
                        $style = 'CategorySkincare';
                    } elseif ($kategori === 'ALAT KESEHATAN') {
                        $style = 'CategoryAlat';
                    } else {
                        $style = 'Body';
                    }
                }

                $xml .= '<Cell ss:StyleID="' . $style . '"><Data ss:Type="' . $type . '">' . $escape($value) . '</Data></Cell>';
            }
            $xml .= '</Row>';
        }

        $xml .= '</Table>';
        $xml .= '<WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">';
        $xml .= '<ProtectObjects>False</ProtectObjects>';
        $xml .= '<ProtectScenarios>False</ProtectScenarios>';
        $xml .= '</WorksheetOptions>';
        $xml .= '</Worksheet>';
        $xml .= '</Workbook>';

        return $xml;
    }

    /**
     * Build XLSX binary string.
     */
    public static function build(array $headers, array $rows, array $widths = []): string
    {
        // ── 1. Build sheet XML ────────────────────────────────────────────────
        $sharedStrings = [];
        $siIndex       = [];
        $sharedStringRefs = 0;

        $getSi = function (string $val) use (&$sharedStrings, &$siIndex, &$sharedStringRefs): int {
            $sharedStringRefs++;
            if (!isset($siIndex[$val])) {
                $siIndex[$val]   = count($sharedStrings);
                $sharedStrings[] = $val;
            }
            return $siIndex[$val];
        };

        // Style indexes (see cellXfs below):
        // 0 = default
        // 1 = header  (bold white on blue, center, border)
        // 2 = number  (right-aligned, border, white bg)
        // 3 = text    (left-aligned, border, white bg)
        // 4 = number-alt (right-aligned, border, zebra bg)
        // 5 = text-alt   (left-aligned, border, zebra bg)
        // 6 = currency   (number format #,##0, white bg)
        // 7 = currency-alt (number format #,##0, zebra bg)

        $sheetRows = '';

        // Header row
        $sheetRows .= '<row r="1" ht="20" customHeight="1">';
        foreach ($headers as $ci => $h) {
            $col  = self::colLetter($ci);
            $cell = $col . '1';
            $si   = $getSi((string) $h);
            $sheetRows .= '<c r="' . $cell . '" t="s" s="1"><v>' . $si . '</v></c>';
        }
        $sheetRows .= '</row>';

        // Data rows
        foreach ($rows as $ri => $row) {
            $rowNum   = $ri + 2;
            $isOdd    = ($ri % 2 === 0); // ri=0 → first data row → white
            $isTotal  = (isset($row[0]) && $row[0] === '__TOTAL__');
            $isEmpty  = ($isTotal === false && implode('', array_map('strval', $row)) === '');

            $sheetRows .= '<row r="' . $rowNum . '" ht="' . ($isTotal ? 22 : 16) . '" customHeight="1">';

            foreach ($row as $ci => $val) {
                $col  = self::colLetter($ci);
                $cell = $col . $rowNum;
                $v    = ($ci === 0 && $isTotal) ? '' : (string) $val; // strip marker

                if ($isEmpty) {
                    // Empty separator row — just write blank text cells with no-border style
                    $si = $getSi('');
                    $sheetRows .= '<c r="' . $cell . '" t="s" s="0"><v>' . $si . '</v></c>';
                    continue;
                }

                $isNumeric = ($v !== '' && is_numeric($v) && !preg_match('/^0\d/', $v));

                if ($isTotal) {
                    // Total row styles: 8=total-text, 9=total-currency
                    if ($isNumeric && $ci >= 11) {
                        $style = 9; // total currency (bold green bg, #,##0)
                    } else {
                        $style = 8; // total text (bold green bg)
                    }

                    if ($isNumeric) {
                        $sheetRows .= '<c r="' . $cell . '" s="' . $style . '"><v>' . floatval($v) . '</v></c>';
                    } else {
                        $si = $getSi($v);
                        $sheetRows .= '<c r="' . $cell . '" t="s" s="' . $style . '"><v>' . $si . '</v></c>';
                    }
                } elseif ($isNumeric) {
                    $style = ($ci >= 11) ? ($isOdd ? 6 : 7) : ($isOdd ? 2 : 4);
                    $sheetRows .= '<c r="' . $cell . '" s="' . $style . '"><v>' . floatval($v) . '</v></c>';
                } else {
                    $si    = $getSi($v);
                    $style = $isOdd ? 3 : 5;
                    $sheetRows .= '<c r="' . $cell . '" t="s" s="' . $style . '"><v>' . $si . '</v></c>';
                }
            }
            $sheetRows .= '</row>';
        }

        // Col widths
        $colDefs = '';
        foreach ($headers as $ci => $h) {
            $w = $widths[$ci] ?? 20;
            $n = $ci + 1;
            $colDefs .= '<col min="' . $n . '" max="' . $n . '" width="' . $w . '" customWidth="1"/>';
        }

        $lastCol  = self::colLetter(count($headers) - 1);
        $lastRow  = count($rows) + 1;
        $sheetXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"'
            . ' xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<dimension ref="A1:' . $lastCol . $lastRow . '"/>'
            . '<sheetViews><sheetView workbookViewId="0" showGridLines="1"><selection activeCell="A2" sqref="A2"/></sheetView></sheetViews>'
            . '<sheetFormatPr defaultRowHeight="15"/>'
            . '<cols>' . $colDefs . '</cols>'
            . '<sheetData>' . $sheetRows . '</sheetData>'
            . '<autoFilter ref="A1:' . $lastCol . '1"/>'
            . '</worksheet>';

        // ── 2. Shared strings XML ─────────────────────────────────────────────
        $ssItems = '';
        foreach ($sharedStrings as $s) {
            $ssItems .= '<si><t xml:space="preserve">' . htmlspecialchars($s, ENT_XML1 | ENT_QUOTES) . '</t></si>';
        }
        $ssCount = $sharedStringRefs;
        $ssUniqueCount = count($sharedStrings);
        $ssXml   = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<sst xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"'
            . ' count="' . $ssCount . '" uniqueCount="' . $ssUniqueCount . '">'
            . $ssItems . '</sst>';

        // ── 3. Styles XML ─────────────────────────────────────────────────────
        // numFmtId=3 is built-in Excel format: #,##0
        $stylesXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            // fonts: 0=normal, 1=bold-white (header), 2=bold-dark (total)
            . '<fonts count="3">'
            . '<font><sz val="10"/><name val="Calibri"/></font>'
            . '<font><sz val="10"/><b/><name val="Calibri"/><color rgb="FFFFFFFF"/></font>'
            . '<font><sz val="10"/><b/><name val="Calibri"/><color rgb="FF1B5E20"/></font>'
            . '</fonts>'
            // fills: 0=none, 1=gray125 (required by spec), 2=blue (header), 3=zebra light-blue, 4=green (total)
            . '<fills count="5">'
            . '<fill><patternFill patternType="none"/></fill>'
            . '<fill><patternFill patternType="gray125"/></fill>'
            . '<fill><patternFill patternType="solid"><fgColor rgb="FF1565C0"/></patternFill></fill>'
            . '<fill><patternFill patternType="solid"><fgColor rgb="FFF0F4FA"/></patternFill></fill>'
            . '<fill><patternFill patternType="solid"><fgColor rgb="FFE8F5E9"/></patternFill></fill>'
            . '</fills>'
            // borders: 0=none, 1=thin-gray
            . '<borders count="2">'
            . '<border><left/><right/><top/><bottom/><diagonal/></border>'
            . '<border>'
            . '<left style="thin"><color rgb="FFCFD8E3"/></left>'
            . '<right style="thin"><color rgb="FFCFD8E3"/></right>'
            . '<top style="thin"><color rgb="FFCFD8E3"/></top>'
            . '<bottom style="thin"><color rgb="FFCFD8E3"/></bottom>'
            . '<diagonal/>'
            . '</border>'
            . '</borders>'
            . '<cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs>'
            // cellXfs — 8 styles
            . '<cellXfs>'
            // 0: default
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/>'
            // 1: header — bold white on blue, center, border
            . '<xf numFmtId="0" fontId="1" fillId="2" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="center" vertical="center"/></xf>'
            // 2: number, white bg, right-aligned
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0" applyBorder="1" applyAlignment="1"><alignment horizontal="right" vertical="center"/></xf>'
            // 3: text, white bg
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0" applyBorder="1" applyAlignment="1"><alignment vertical="center"/></xf>'
            // 4: number, zebra bg, right-aligned
            . '<xf numFmtId="0" fontId="0" fillId="3" borderId="1" xfId="0" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="right" vertical="center"/></xf>'
            // 5: text, zebra bg
            . '<xf numFmtId="0" fontId="0" fillId="3" borderId="1" xfId="0" applyFill="1" applyBorder="1" applyAlignment="1"><alignment vertical="center"/></xf>'
            // 6: currency (#,##0), white bg
            . '<xf numFmtId="3" fontId="0" fillId="0" borderId="1" xfId="0" applyNumberFormat="1" applyBorder="1" applyAlignment="1"><alignment horizontal="right" vertical="center"/></xf>'
            // 7: currency (#,##0), zebra bg
            . '<xf numFmtId="3" fontId="0" fillId="3" borderId="1" xfId="0" applyNumberFormat="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="right" vertical="center"/></xf>'
            // 8: total text — bold dark-green font, green bg, border
            . '<xf numFmtId="0" fontId="2" fillId="4" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment vertical="center"/></xf>'
            // 9: total currency — bold dark-green font, green bg, #,##0, right-aligned
            . '<xf numFmtId="3" fontId="2" fillId="4" borderId="1" xfId="0" applyNumberFormat="1" applyFont="1" applyFill="1" applyBorder="1" applyAlignment="1"><alignment horizontal="right" vertical="center"/></xf>'
            . '</cellXfs>'
            . '<cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles>'
            . '</styleSheet>';

        // ── 4. Pack ke ZIP (XLSX = ZIP) ───────────────────────────────────────
        $files = [
            '[Content_Types].xml'        => self::contentTypes(),
            '_rels/.rels'                => self::rootRels(),
            'xl/workbook.xml'            => self::workbook(),
            'xl/_rels/workbook.xml.rels' => self::workbookRels(),
            'xl/worksheets/sheet1.xml'   => $sheetXml,
            'xl/sharedStrings.xml'       => $ssXml,
            'xl/styles.xml'              => $stylesXml,
        ];

        return self::buildZip($files);
    }

    // ── Helper: column letter (0→A, 25→Z, 26→AA ...) ─────────────────────────
    private static function colLetter(int $n): string
    {
        $letter = '';
        $n++;
        while ($n > 0) {
            $n--;
            $letter = chr(65 + ($n % 26)) . $letter;
            $n      = (int) ($n / 26);
        }
        return $letter;
    }

    // ── Static XML strings ────────────────────────────────────────────────────
    private static function contentTypes(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            . '<Default Extension="xml"  ContentType="application/xml"/>'
            . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            . '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
            . '<Override PartName="/xl/sharedStrings.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sharedStrings+xml"/>'
            . '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'
            . '</Types>';
    }

    private static function rootRels(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
            . '</Relationships>';
    }

    private static function workbook(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"'
            . ' xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<sheets><sheet name="Data" sheetId="1" r:id="rId1"/></sheets>'
            . '</workbook>';
    }

    private static function workbookRels(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
            . '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/sharedStrings" Target="sharedStrings.xml"/>'
            . '<Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'
            . '</Relationships>';
    }

    // ── Minimal ZIP builder (tanpa ext-zip) ───────────────────────────────────
    private static function buildZip(array $files): string
    {
        $centralDir  = '';
        $localFiles  = '';
        $offset      = 0;
        $entries     = 0;

        foreach ($files as $name => $content) {
            $nameBytes  = $name;
            $nameLen    = strlen($nameBytes);
            $data       = $content;
            $dataLen    = strlen($data);
            $crc        = crc32($data);
            $dosTime    = self::dosTime();

            // Local file header
            $local  = "\x50\x4b\x03\x04"; // signature
            $local .= "\x14\x00";          // version needed
            $local .= "\x00\x00";          // flags
            $local .= "\x00\x00";          // compression (stored)
            $local .= $dosTime;
            $local .= pack('V', $crc);
            $local .= pack('V', $dataLen);
            $local .= pack('V', $dataLen);
            $local .= pack('v', $nameLen);
            $local .= "\x00\x00";          // extra len
            $local .= $nameBytes;
            $local .= $data;

            // Central dir entry
            $central  = "\x50\x4b\x01\x02"; // signature
            $central .= "\x14\x00";          // version made by
            $central .= "\x14\x00";          // version needed
            $central .= "\x00\x00";          // flags
            $central .= "\x00\x00";          // compression
            $central .= $dosTime;
            $central .= pack('V', $crc);
            $central .= pack('V', $dataLen);
            $central .= pack('V', $dataLen);
            $central .= pack('v', $nameLen);
            $central .= "\x00\x00";          // extra len
            $central .= "\x00\x00";          // comment len
            $central .= "\x00\x00";          // disk start
            $central .= "\x00\x00";          // internal attr
            $central .= "\x00\x00\x00\x00"; // external attr
            $central .= pack('V', $offset);
            $central .= $nameBytes;

            $localFiles .= $local;
            $centralDir .= $central;
            $offset += strlen($local);
            $entries++;
        }

        $cdLen    = strlen($centralDir);
        $cdOffset = $offset;

        $eocd  = "\x50\x4b\x05\x06"; // end of central dir signature
        $eocd .= "\x00\x00";          // disk number
        $eocd .= "\x00\x00";          // disk with central dir
        $eocd .= pack('v', $entries);
        $eocd .= pack('v', $entries);
        $eocd .= pack('V', $cdLen);
        $eocd .= pack('V', $cdOffset);
        $eocd .= "\x00\x00";          // comment length

        return $localFiles . $centralDir . $eocd;
    }

    private static function dosTime(): string
    {
        $t = getdate();
        $dosDate = (($t['year'] - 1980) << 9) | ($t['mon'] << 5) | $t['mday'];
        $dosTime = ($t['hours'] << 11) | ($t['minutes'] << 5) | (int)($t['seconds'] / 2);
        return pack('v', $dosTime) . pack('v', $dosDate);
    }
}
