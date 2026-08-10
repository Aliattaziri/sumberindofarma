<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'product_categories';

    protected $fillable = ['name', 'icon', 'sort_order'];

    /**
     * Ambil semua nama kategori, diurutkan by sort_order.
     * Fallback ke default jika tabel belum ada / kosong.
     */
    public static function getList(): array
    {
        try {
            $list = static::orderBy('sort_order')->orderBy('name')->pluck('name')->toArray();
            return $list ?: ['OBAT', 'SKINCARE & KOSMETIK', 'ALAT KESEHATAN'];
        } catch (\Throwable) {
            return ['OBAT', 'SKINCARE & KOSMETIK', 'ALAT KESEHATAN'];
        }
    }

    /**
     * Ambil semua kategori dengan icon.
     * Returns: [['name' => '...', 'icon' => '...'], ...]
     */
    public static function getListWithIcons(): array
    {
        try {
            $items = static::orderBy('sort_order')->orderBy('name')->get(['name', 'icon'])->toArray();
            return $items ?: [
                ['name' => 'OBAT',               'icon' => '💊'],
                ['name' => 'SKINCARE & KOSMETIK', 'icon' => '✨'],
                ['name' => 'ALAT KESEHATAN',      'icon' => '🩺'],
            ];
        } catch (\Throwable) {
            return [
                ['name' => 'OBAT',               'icon' => '💊'],
                ['name' => 'SKINCARE & KOSMETIK', 'icon' => '✨'],
                ['name' => 'ALAT KESEHATAN',      'icon' => '🩺'],
            ];
        }
    }

    /**
     * Kembalikan icon untuk nama kategori tertentu.
     */
    public static function iconFor(string $name): string
    {
        // Cek DB dulu
        try {
            $cat = static::where('name', $name)->first();
            if ($cat && $cat->icon) {
                return $cat->icon;
            }
        } catch (\Throwable) {}

        // Fallback berdasarkan keyword
        $upper = strtoupper($name);
        if (str_contains($upper, 'ALAT') || str_contains($upper, 'ALKES')) return '🩺';
        if (str_contains($upper, 'SKINCARE') || str_contains($upper, 'KOSMETIK') || str_contains($upper, 'KECANTIKAN')) return '✨';
        return '💊';
    }

    /**
     * Normalisasi nilai kategori dari import ke nama resmi di DB,
     * atau kembalikan nilai asli (akan dibuat sebagai kategori baru).
     *
     * Alias yang didukung:
     *  ALKES, ALAT KESEHATAN, MEDICAL DEVICE  → ALAT KESEHATAN
     *  SKINCARE, KOSMETIK, KECANTIKAN          → SKINCARE & KOSMETIK
     *  OBAT, MEDICINE, APOTEK, APOTIK          → OBAT
     */
    public static function normalizeImport(string $raw): string
    {
        $upper = strtoupper(trim($raw));

        // Alias ke ALAT KESEHATAN
        if (in_array($upper, ['ALKES', 'ALAT KESEHATAN', 'MEDICAL DEVICE', 'KESEHATAN'])) {
            return 'ALAT KESEHATAN';
        }

        // Alias ke SKINCARE & KOSMETIK
        if (in_array($upper, ['SKINCARE', 'KOSMETIK', 'KECANTIKAN', 'SKINCARE & KOSMETIK', 'BEAUTY'])) {
            return 'SKINCARE & KOSMETIK';
        }

        // Alias ke OBAT
        if (in_array($upper, ['OBAT', 'MEDICINE', 'APOTEK', 'APOTIK', 'FARMASI', 'PHARMACEUTICAL'])) {
            return 'OBAT';
        }

        // Nilai tidak dikenal: kembalikan uppercase (akan dibuat jika belum ada)
        return $upper ?: 'OBAT';
    }

    /**
     * Pastikan kategori ada di DB; buat jika belum.
     */
    public static function ensureExists(string $name): string
    {
        if (empty(trim($name))) return 'OBAT';

        $normalized = static::normalizeImport($name);

        try {
            static::firstOrCreate(
                ['name' => $normalized],
                ['icon' => static::guessIcon($normalized), 'sort_order' => 99]
            );
        } catch (\Throwable) {}

        return $normalized;
    }

    private static function guessIcon(string $name): string
    {
        $upper = strtoupper($name);
        if (str_contains($upper, 'ALAT') || str_contains($upper, 'ALKES')) return '🩺';
        if (str_contains($upper, 'SKINCARE') || str_contains($upper, 'KOSMETIK') || str_contains($upper, 'KECANTIKAN')) return '✨';
        return '💊';
    }
}
