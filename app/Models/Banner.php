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
}
