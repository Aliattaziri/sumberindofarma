<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';

    protected $fillable = [
        'judul',
        'deskripsi',
        'konten',
        'tipe',
        'tags',
        'ratio',
        'file',
        'gallery',
        'thumbnail',
        'views',
        'like_count',
        'comment_count',
        'share_count',
        'is_published',
        'created_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'views' => 'integer',
        'like_count' => 'integer',
        'comment_count' => 'integer',
        'share_count' => 'integer',
        'gallery' => 'array',
        'tags' => 'array',
    ];

    // Scope untuk berita published
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    // Scope untuk urutan terbaru
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Get tipe badge
    public function getTipeBadge()
    {
        return match($this->tipe) {
            'diskon'        => '🏷️ Diskon',
            'flash_sale'    => '⚡ Flash Sale',
            'bundling'      => '📦 Bundling',
            'promo_spesial' => '🎁 Promo Spesial',
            default         => '🏷️ Promo'
        };
    }

    // Increment views
    public function incrementViews()
    {
        $this->increment('views');
    }

    // Increment likes
    public function incrementLikes()
    {
        $this->increment('like_count');
    }

    // Increment comments
    public function incrementComments()
    {
        $this->increment('comment_count');
    }

    // Increment shares
    public function incrementShares()
    {
        $this->increment('share_count');
    }

    // Relationship to comments
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }
}
