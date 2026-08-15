<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_delete_own_comment(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $news = News::create([
            'judul' => 'Berita uji hapus komentar',
            'deskripsi' => 'Deskripsi untuk uji hapus komentar',
            'konten' => 'Isi berita untuk uji hapus komentar',
            'tipe' => 'artikel',
            'ratio' => '9:16',
            'file' => 'news/test.jpg',
            'is_published' => true,
            'views' => 0,
            'like_count' => 0,
            'comment_count' => 1,
            'share_count' => 0,
        ]);

        $comment = Comment::create([
            'news_id' => $news->id,
            'user_id' => $user->id,
            'nama' => $user->name,
            'komentar' => 'Komentar milik user',
        ]);

        $this->actingAs($user)
            ->delete(route('api.news.comment.delete', $comment))
            ->assertOk();

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    public function test_admin_can_delete_any_comment(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $news = News::create([
            'judul' => 'Berita admin delete',
            'deskripsi' => 'Deskripsi admin delete',
            'konten' => 'Isi berita admin delete',
            'tipe' => 'artikel',
            'ratio' => '9:16',
            'file' => 'news/admin-test.jpg',
            'is_published' => true,
            'views' => 0,
            'like_count' => 0,
            'comment_count' => 1,
            'share_count' => 0,
        ]);

        $comment = Comment::create([
            'news_id' => $news->id,
            'user_id' => null,
            'nama' => 'Pengunjung',
            'komentar' => 'Komentar milik publik',
        ]);

        $this->actingAs($admin)
            ->delete(route('api.news.comment.delete', $comment))
            ->assertOk();

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }
}
