<?php

namespace Tests\Feature;

use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicNewsDetailTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_news_detail_page_displays_media_and_content(): void
    {
        $news = News::create([
            'judul' => 'Peluncuran Produk Baru',
            'deskripsi' => 'Informasi terbaru tentang produk baru kami.',
            'konten' => 'Isi berita lengkap tentang produk baru yang hadir di Apotek Medistra Farma.',
            'tipe' => 'artikel',
            'ratio' => '9:16',
            'file' => 'news/sample-photo.jpg',
            'thumbnail' => null,
            'views' => 12,
            'is_published' => true,
        ]);

        $homeResponse = $this->get(route('home'));
        $detailResponse = $this->get(route('news.show', $news));

        $homeResponse->assertOk();
        $homeResponse->assertSee('storage/news/sample-photo.jpg');

        $detailResponse->assertOk();
        $detailResponse->assertSee('Peluncuran Produk Baru');
        $detailResponse->assertSee('Informasi terbaru tentang produk baru kami.');
        $detailResponse->assertSee('Isi berita lengkap');
        $detailResponse->assertSee('storage/news/sample-photo.jpg');
        $this->assertDatabaseHas('news', ['id' => $news->id, 'ratio' => '9:16']);
    }

    public function test_news_gallery_images_render_as_carousel(): void
    {
        $news = News::create([
            'judul' => 'Kampanye Produk Baru',
            'deskripsi' => 'Album foto produk dengan beberapa gambar.',
            'konten' => 'Konten panjang dari album foto ini.',
            'tipe' => 'galeri',
            'ratio' => '3:4',
            'file' => 'news/cover-photo.jpg',
            'gallery' => ['news/slide-1.jpg', 'news/slide-2.jpg', 'news/slide-3.jpg'],
            'thumbnail' => null,
            'views' => 5,
            'is_published' => true,
        ]);

        $response = $this->get(route('news.show', $news));

        $response->assertOk();
        $response->assertSee('news/slide-1.jpg');
        $response->assertSee('news/slide-2.jpg');
        $response->assertSee('news/slide-3.jpg');
        $this->assertDatabaseHas('news', ['id' => $news->id, 'tipe' => 'galeri']);
    }

    public function test_home_news_cards_point_to_news_list_with_selected_item(): void
    {
        $news = News::create([
            'judul' => 'Update Stok Produk',
            'deskripsi' => 'Stok produk terbaru sudah tersedia.',
            'konten' => 'Informasi lengkap mengenai ketersediaan stok produk pilihan.',
            'tipe' => 'artikel',
            'ratio' => '9:16',
            'file' => 'news/update-stok.jpg',
            'thumbnail' => null,
            'views' => 7,
            'is_published' => true,
        ]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee(route('news.index', ['news_id' => $news->id]));
    }

    public function test_home_displays_all_published_news_without_a_limit(): void
    {
        foreach (range(1, 7) as $newsIndex) {
            News::create([
                'judul' => "Berita Homepage {$newsIndex}",
                'deskripsi' => "Deskripsi berita homepage {$newsIndex}.",
                'konten' => "Konten berita homepage {$newsIndex}.",
                'tipe' => 'artikel',
                'ratio' => '9:16',
                'file' => null,
                'thumbnail' => null,
                'views' => 0,
                'is_published' => true,
            ]);
        }

        $response = $this->get(route('home'));

        $response->assertOk();
        foreach (range(1, 7) as $newsIndex) {
            $response->assertSee("Berita Homepage {$newsIndex}");
        }
    }
}
