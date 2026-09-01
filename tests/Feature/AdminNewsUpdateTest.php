<?php

namespace Tests\Feature;

use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminNewsUpdateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAsAdmin();
    }

    private function actingAsAdmin()
    {
        $user = \App\Models\User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);
    }

    public function test_update_news_with_description_only()
    {
        $news = News::create([
            'judul' => 'Original Title',
            'deskripsi' => 'Original description text',
            'konten' => 'Original description text',
            'tipe' => 'artikel',
            'ratio' => '3:4',
            'tags' => [],
            'file' => null,
            'gallery' => [],
            'is_published' => false,
        ]);

        $response = $this->put(route('admin.news.update', $news->id), [
            'deskripsi' => 'Updated description text only',
            'is_published' => '1',
        ]);

        $response->assertRedirect(route('admin.news.index'));

        $updated = News::find($news->id);
        $this->assertNotNull($updated, 'News record should still exist after update');
        $this->assertEquals('Updated description text only', $updated->deskripsi);
        $this->assertTrue($updated->is_published);
    }

    public function test_update_news_preserves_gallery()
    {
        $news = News::create([
            'judul' => 'News with Gallery',
            'deskripsi' => 'Original description',
            'konten' => 'Original description',
            'tipe' => 'artikel',
            'ratio' => '3:4',
            'tags' => [],
            'file' => 'medicines/test.jpg',
            'gallery' => ['medicines/test1.jpg', 'medicines/test2.jpg'],
            'is_published' => true,
        ]);

        $response = $this->put(route('admin.news.update', $news->id), [
            'deskripsi' => 'Updated description only',
            'is_published' => '1',
        ]);

        $response->assertRedirect(route('admin.news.index'));

        $updated = News::find($news->id);
        $this->assertNotNull($updated, 'News record should still exist after update');
        $this->assertEquals('Updated description only', $updated->deskripsi);
        $this->assertEquals(['medicines/test1.jpg', 'medicines/test2.jpg'], $updated->gallery);
        $this->assertEquals('medicines/test.jpg', $updated->file);
    }

    public function test_store_news_allows_manual_created_at()
    {
        $response = $this->post(route('admin.news.store'), [
            'deskripsi' => 'Manual date news content',
            'created_at' => '2025-03-10',
            'is_published' => '1',
        ]);

        $response->assertRedirect(route('admin.news.index'));

        $news = News::latest('id')->first();
        $this->assertNotNull($news);
        $this->assertSame('2025-03-10 00:00:00', $news->created_at->format('Y-m-d H:i:s'));
    }

    public function test_update_news_allows_manual_created_at()
    {
        $news = News::create([
            'judul' => 'Original Title',
            'deskripsi' => 'Original description text',
            'konten' => 'Original description text',
            'tipe' => 'artikel',
            'ratio' => '3:4',
            'tags' => [],
            'file' => null,
            'gallery' => [],
            'is_published' => false,
        ]);

        $response = $this->put(route('admin.news.update', $news->id), [
            'deskripsi' => 'Updated description text only',
            'created_at' => '2024-07-20',
            'is_published' => '1',
        ]);

        $response->assertRedirect(route('admin.news.index'));

        $updated = News::find($news->id);
        $this->assertNotNull($updated);
        $this->assertSame('2024-07-20 00:00:00', $updated->created_at->format('Y-m-d H:i:s'));
    }
}
