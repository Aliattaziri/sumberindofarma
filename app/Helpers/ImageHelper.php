<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;

class ImageHelper
{
    /**
     * Simpan gambar produk ke storage/medicines/
     *
     * Struktur folder hasil:
     *   public_html/storage/medicines/namafile.jpg   ← berjejer dengan app/, framework/, logs/
     *
     * URL akses: https://domain.com/storage/medicines/namafile.jpg
     * Nilai di DB: "medicines/namafile.jpg"
     */
    public static function storeProductImage(UploadedFile $file): string
    {
        $ext       = strtolower($file->getClientOriginalExtension());
        $imageName = time() . '_' . uniqid() . '.' . $ext;
        $targetDir = storage_path('medicines');

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $file->move($targetDir, $imageName);

        return 'medicines/' . $imageName;
    }

    /**
     * Hapus gambar produk dari storage/medicines/
     * $path dari DB: "medicines/namafile.jpg"
     */
    public static function deleteProductImage(?string $path): void
    {
        if (!$path) return;

        $fullPath = storage_path($path);
        if (file_exists($fullPath)) {
            @unlink($fullPath);
        }
    }

    /**
     * Simpan gambar banner ke storage/banners/
     *
     * Struktur folder hasil:
     *   public_html/storage/banners/namafile.jpg   ← berjejer dengan app/, framework/, logs/
     *
     * URL akses: https://domain.com/storage/banners/namafile.jpg
     * Nilai di DB: "banners/namafile.jpg"
     */
    public static function storeBannerMedia(UploadedFile $file): string
    {
        $ext       = strtolower($file->getClientOriginalExtension());
        $mediaName = time() . '_' . uniqid() . '.' . $ext;
        $targetDir = storage_path('banners');

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $file->move($targetDir, $mediaName);

        return 'banners/' . $mediaName;
    }

    public static function storeBannerImage(UploadedFile $file): string
    {
        return self::storeBannerMedia($file);
    }

    /**
     * Simpan gambar banner dari base64 encoded image (data URL)
     * Mengembalikan path DB seperti 'banners/namafile.png'
     */
    public static function storeBase64BannerImage(string $dataUrl): string
    {
        if (!preg_match('/^data:([\w\/\-\.]+);base64,(.*)$/', $dataUrl, $matches)) {
            throw new \InvalidArgumentException('Invalid base64 image data');
        }

        $mime = $matches[1];
        $data = base64_decode($matches[2]);
        $ext = 'png';
        if ($mime === 'image/jpeg' || $mime === 'image/jpg') $ext = 'jpg';
        if ($mime === 'image/webp') $ext = 'webp';

        $fileName = time() . '_' . uniqid() . '.' . $ext;
        $targetDir = storage_path('banners');

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $fullPath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
        file_put_contents($fullPath, $data);

        return 'banners/' . $fileName;
    }

    /**
     * Hapus media banner dari storage/banners/
     * $path dari DB: "banners/namafile.jpg"
     */
    public static function deleteBannerImage(?string $path): void
    {
        if (!$path) return;

        $fullPath = storage_path($path);
        if (file_exists($fullPath)) {
            @unlink($fullPath);
        }
    }

    /**
     * Simpan gambar promo produk ke storage/promos/
     * Nilai di DB: "promos/namafile.jpg"
     */
    public static function storePromoImage(UploadedFile $file): string
    {
        $ext       = strtolower($file->getClientOriginalExtension());
        $imageName = time() . '_' . uniqid() . '.' . $ext;
        $targetDir = storage_path('promos');

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $file->move($targetDir, $imageName);

        return 'promos/' . $imageName;
    }

    /**
     * Simpan gambar principle logo ke storage/principellogos/
     * Nilai di DB: "principellogos/namafile.jpg"
     */
    public static function storePrincipleImage(UploadedFile $file): string
    {
        $ext       = strtolower($file->getClientOriginalExtension());
        $imageName = time() . '_' . uniqid() . '.' . $ext;
        $targetDir = storage_path('principellogos');

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $file->move($targetDir, $imageName);

        return 'principellogos/' . $imageName;
    }

    /**     * Simpan gambar principle logo dari base64 encoded image (data URL)
     * Mengembalikan path DB seperti 'principellogos/namafile.png'
     */
    public static function storeBase64PrincipleImage(string $dataUrl): string
    {
        if (!preg_match('/^data:([\w\/\-\.]+);base64,(.*)$/', $dataUrl, $matches)) {
            throw new \InvalidArgumentException('Invalid base64 image data');
        }

        $mime = $matches[1];
        $data = base64_decode($matches[2]);
        $ext = 'png';
        if ($mime === 'image/jpeg' || $mime === 'image/jpg') $ext = 'jpg';
        if ($mime === 'image/webp') $ext = 'webp';

        $fileName = time() . '_' . uniqid() . '.' . $ext;
        $targetDir = storage_path('principellogos');

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $fullPath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
        file_put_contents($fullPath, $data);

        return 'principellogos/' . $fileName;
    }

    /**     * Hapus gambar principle logo dari storage/principellogos/
     * $path dari DB: "principellogos/namafile.jpg"
     */
    public static function deletePrincipleImage(?string $path): void
    {
        if (!$path) return;

        $fullPath = storage_path($path);
        if (file_exists($fullPath)) {
            @unlink($fullPath);
        }
    }

    /**
     * Simpan media berita (foto/video) ke storage/news/
     * Mengembalikan path DB seperti 'news/1234567_abc123.jpg' atau 'news/1234567_abc123.mp4'
     */
    public static function storeNewsMedia(UploadedFile $file): string
    {
        $ext       = strtolower($file->getClientOriginalExtension());
        $mediaName = time() . '_' . uniqid() . '.' . $ext;
        $targetDir = storage_path('news');

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $file->move($targetDir, $mediaName);

        return 'news/' . $mediaName;
    }

    /**
     * Simpan thumbnail berita ke storage/news/
     * Mengembalikan path DB seperti 'news/thumb_1234567_abc123.jpg'
     */
    public static function storeNewsThumbnail(UploadedFile $file): string
    {
        $ext       = strtolower($file->getClientOriginalExtension());
        $thumbName = 'thumb_' . time() . '_' . uniqid() . '.' . $ext;
        $targetDir = storage_path('news');

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $file->move($targetDir, $thumbName);

        return 'news/' . $thumbName;
    }

    /**
     * Hapus media berita dari storage/news/
     * $path dari DB: "news/namafile.jpg" atau "news/namafile.mp4"
     */
    public static function deleteNewsMedia(?string $path): void
    {
        if (!$path) return;

        $fullPath = storage_path($path);
        if (file_exists($fullPath)) {
            @unlink($fullPath);
        }
    }

    /**
     * Hapus thumbnail berita dari storage/news/
     * $path dari DB: "news/thumb_namafile.jpg"
     */
    public static function deleteNewsThumbnail(?string $path): void
    {
        if (!$path) return;

        $fullPath = storage_path($path);
        if (file_exists($fullPath)) {
            @unlink($fullPath);
        }
    }
}
