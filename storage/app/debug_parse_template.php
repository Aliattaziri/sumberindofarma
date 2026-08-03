<?php

$path = 'C:/Users/Ali Attaziri/Downloads/template_produk_20260803_124540.xls';
$content = file_get_contents($path);

function normalizeXmlContent(string $content): string
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
    $content = preg_replace('/[^\x09\x0A\x0D\x20-\x7E\x{80}-\x{10FFFF}]/u', '', $content) ?? $content;
    return $content;
}

$content = normalizeXmlContent($content);
$content = preg_replace('/<\?mso-application[^?]*\?>/i', '', $content);

libxml_use_internal_errors(true);
libxml_clear_errors();

$dom = new DOMDocument();
$ok = @$dom->loadXML($content, LIBXML_NONET | LIBXML_COMPACT | LIBXML_NOERROR | LIBXML_NOWARNING);

echo $ok ? "DOM_OK\n" : "DOM_FAIL\n";
if (!$ok) {
    $e = libxml_get_last_error();
    if ($e) {
        echo trim($e->message) . "\n";
    }
    exit(1);
}

$xpath = new DOMXPath($dom);
$rowNodes = $xpath->query('//*[local-name()="Worksheet"]//*[local-name()="Table"]//*[local-name()="Row"]');
echo 'ROW_COUNT=' . ($rowNodes ? $rowNodes->length : 0) . "\n";

if ($rowNodes && $rowNodes->length > 0) {
    $first = $rowNodes->item(0);
    $cells = $xpath->query('./*[local-name()="Cell"]', $first);
    echo 'HEADER_CELL_COUNT=' . ($cells ? $cells->length : 0) . "\n";
}
