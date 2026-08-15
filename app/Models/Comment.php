<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'news_id',
        'user_id',
        'nama',
        'komentar',
    ];

    public function news()
    {
        return $this->belongsTo(News::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
