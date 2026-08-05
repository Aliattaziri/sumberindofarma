<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banners';

    protected $fillable = [
        'judul',
        'subjudul',
        'gambar',
        'url_tujuan',
        'label_tombol',
        'aktif',
        'urutan',
    ];

    protected $casts = [
        'aktif'  => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Scope: hanya banner aktif, urut by urutan
     */
    public function scopeAktif($query)
    {
        return $query->where('aktif', true)->orderBy('urutan')->orderBy('id');
    }

    /**
     * URL gambar lengkap
     */
    public function getImageUrlAttribute(): string
    {
        if (!$this->gambar) {
            return '';
        }

        $paths = [
            'storage/' . $this->gambar,
            $this->gambar,
            'public/storage/' . $this->gambar,
        ];

        foreach ($paths as $path) {
            if (file_exists(public_path($path))) {
                return url($path);
            }
        }

        return url('storage/' . $this->gambar);
    }

    public function getIsVideoAttribute(): bool
    {
        if (!$this->gambar) {
            return false;
        }

        $extension = strtolower(pathinfo($this->gambar, PATHINFO_EXTENSION));
        return in_array($extension, ['mp4', 'webm', 'mov']);
    }

    public function getUrlTujuanAttribute($value): ?string
    {
        if (!$value) {
            return null;
        }

        $url = trim((string) $value);
        if ($url === '') {
            return null;
        }

        // Keep internal and already-schemed links as-is.
        if (
            str_starts_with($url, '/') ||
            str_starts_with($url, '#') ||
            str_starts_with($url, '?') ||
            preg_match('/^[a-z][a-z0-9+.-]*:/i', $url)
        ) {
            return $url;
        }

        // Normalize host-only URLs like "www.youtube.com".
        return 'https://' . ltrim($url, '/');
    }
}
