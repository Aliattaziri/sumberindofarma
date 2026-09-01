<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Helpers\ImageHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AdminNewsController extends Controller
{
    private function gallerySignature($file): string
    {
        if (is_string($file)) {
            return $file;
        }

        return ($file->getClientOriginalName() ?? 'file') . '::' . ($file->getSize() ?? 0);
    }

    private function reorderGalleryFiles(array $galleryFiles, ?string $galleryOrder): array
    {
        if (empty($galleryFiles)) {
            return [];
        }

        $order = json_decode($galleryOrder ?? '[]', true);
        if (!is_array($order) || empty($order)) {
            return array_values($galleryFiles);
        }

        $mapped = [];
        foreach ($galleryFiles as $file) {
            $mapped[$this->gallerySignature($file)] = $file;
        }

        $ordered = [];
        foreach ($order as $signature) {
            if (isset($mapped[$signature])) {
                $ordered[] = $mapped[$signature];
                unset($mapped[$signature]);
            }
        }

        foreach ($mapped as $file) {
            $ordered[] = $file;
        }

        return array_values($ordered);
    }

    /**
     * Tampilkan daftar berita
     */
    public function index(Request $request)
    {
        if (!Schema::hasTable("news")) {
            return view("admin.news.index", ["news" => collect()])->with(
                "warning",
                "Tabel berita belum tersedia di database. Jalankan migrasi untuk mengaktifkan fitur berita.",
            );
        }

        $search = $request->input('search', '');
        $tipe   = $request->input('tipe', '');
        $status = $request->input('status', '');

        $query = News::query();

        if (!empty($search)) {
            $query->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
        }

        if (!empty($tipe)) {
            $query->where('tipe', $tipe);
        }

        if ($status === 'published') {
            $query->where('is_published', true);
        } elseif ($status === 'draft') {
            $query->where('is_published', false);
        }

        $news = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.news.index', compact('news', 'search', 'tipe', 'status'));
    }

    /**
     * Form tambah berita baru
     */
    public function create()
    {
        $newsTableReady = Schema::hasTable("news");
        return view("admin.news.create", compact("newsTableReady"));
    }

    /**
     * Simpan berita baru
     */
    public function store(Request $request)
    {
        if (!Schema::hasTable("news")) {
            return redirect()
                ->route("admin.news.index")
                ->with("warning", "Tabel berita belum tersedia di database. Berita tidak dapat disimpan sebelum migrasi dijalankan.");
        }

        $data = $request->validate([
            'deskripsi'     => 'required|string',
            'file'          => 'nullable|file|mimes:jpeg,jpg,png,gif,webp,mp4,webm,mov|max:512000',
            'gallery'       => 'nullable|array',
            'gallery.*'     => 'file|mimes:jpeg,jpg,png,gif,webp|max:512000',
            'gallery_order' => 'nullable|string',
            'created_at'    => 'nullable|date_format:Y-m-d',
            'is_published'  => 'nullable|boolean',
        ]);

        // Jangan pakai judul dummy atau hashtag default; simpan deskripsi sebagai konten utama.
        $data['judul'] = !empty(trim($data['deskripsi'])) ? Str::limit(strip_tags($data['deskripsi']), 60) : null;
        $data['konten'] = $data['deskripsi'];
        $data['tipe'] = 'artikel';
        $data['ratio'] = '3:4';
        $data['tags'] = [];

        $galleryPaths = [];
        if ($request->hasFile('gallery')) {
            $orderedGalleryFiles = $this->reorderGalleryFiles($request->file('gallery'), $request->input('gallery_order'));
            foreach ($orderedGalleryFiles as $galleryFile) {
                $galleryPaths[] = ImageHelper::storeNewsMedia($galleryFile);
            }
        }

        // Simpan file media utama (jika ada) atau pakai gambar pertama dari galeri sebagai cover
        if ($request->hasFile('file')) {
            $data['file'] = ImageHelper::storeNewsMedia($request->file('file'));
        } elseif (!empty($galleryPaths)) {
            $data['file'] = $galleryPaths[0];
        }

        $data['gallery'] = $galleryPaths;

        // Set published status
        $data['is_published'] = $request->boolean('is_published', false);
        $data['ratio'] = $data['ratio'] ?? '3:4';
        $data['views'] = 0;
        $data['created_at'] = $request->filled('created_at')
            ? Carbon::parse($request->input('created_at'))->format('Y-m-d 00:00:00')
            : now()->format('Y-m-d H:i:s');

        News::create($data);

        return redirect()->route('admin.news.index')->with('success', '✓ Berita berhasil ditambahkan!');
    }

    /**
     * Form edit berita
     */
    public function edit(News $news)
    {
        if (!Schema::hasTable("news")) {
            return redirect()->route("admin.news.index")->with("warning", "Tabel berita belum tersedia di database.");
        }

        return view("admin.news.edit", compact("news"));
    }

    /**
     * Update berita
     */
    public function update(Request $request, News $news)
    {
        if (!Schema::hasTable("news")) {
            return redirect()
                ->route("admin.news.index")
                ->with("warning", "Tabel berita belum tersedia di database. Berita tidak dapat diperbarui.");
        }

        $data = $request->validate([
            'deskripsi'      => 'required|string',
            'file'           => 'nullable|file|mimes:jpeg,jpg,png,gif,webp,mp4,webm,mov|max:512000',
            'gallery'        => 'nullable|array',
            'gallery.*'      => 'file|mimes:jpeg,jpg,png,gif,webp|max:512000',
            'delete_file'    => 'nullable|boolean',
            'created_at'     => 'nullable|date_format:Y-m-d',
            'is_published'   => 'nullable|boolean',
        ]);

        // Keep existing values for removed fields tanpa judul/hashtag placeholder
        $data['tags'] = $news->tags ?? [];
        $data['judul'] = !empty(trim($data['deskripsi'])) ? Str::limit(strip_tags($data['deskripsi']), 60) : null;
        $data['konten'] = $data['deskripsi'];
        $data['tipe'] = $news->tipe ?? 'artikel';
        $data['ratio'] = $news->ratio ?? '3:4';

        // Handle delete_file request
        if ($request->boolean('delete_file', false)) {
            if ($news->file) {
                ImageHelper::deleteNewsMedia($news->file);
                $data['file'] = null;
            }
        }

        $existingGallery = is_array($news->gallery) ? $news->gallery : [];
        $galleryExistingOrder = json_decode($request->input('gallery_existing_order', '[]'), true);
        if (is_array($galleryExistingOrder) && !empty($galleryExistingOrder)) {
            $ordered = [];
            foreach ($galleryExistingOrder as $path) {
                if (!empty($path) && in_array($path, $existingGallery, true)) {
                    $ordered[] = $path;
                }
            }
            foreach ($existingGallery as $path) {
                if (!in_array($path, $ordered, true)) {
                    $ordered[] = $path;
                }
            }
            $existingGallery = $ordered;
        }

        $galleryUpdated = false;
        if ($request->hasFile('gallery')) {
            foreach ($existingGallery as $oldGalleryImage) {
                ImageHelper::deleteNewsMedia($oldGalleryImage);
            }
            $galleryPaths = [];
            $orderedGalleryFiles = $this->reorderGalleryFiles($request->file('gallery'), $request->input('gallery_order'));
            foreach ($orderedGalleryFiles as $galleryFile) {
                $galleryPaths[] = ImageHelper::storeNewsMedia($galleryFile);
            }
            $data['gallery'] = $galleryPaths;
            $galleryUpdated = true;
        } else {
            $data['gallery'] = $existingGallery;
        }

        // Update file media utama jika ada yang baru
        if ($request->hasFile('file')) {
            if ($news->file) {
                ImageHelper::deleteNewsMedia($news->file);
            }
            $data['file'] = ImageHelper::storeNewsMedia($request->file('file'));
        } elseif ($galleryUpdated && !empty($data['gallery'])) {
            // Only update file from gallery if gallery was actually updated
            $data['file'] = $data['gallery'][0];
        }
        // If nothing changed, file stays the same

        // Set published status
        $data['is_published'] = $request->boolean('is_published', false);
        $data['ratio'] = $data['ratio'] ?? $news->ratio ?? '3:4';
        if ($request->filled('created_at')) {
            $data['created_at'] = Carbon::parse($request->input('created_at'))->format('Y-m-d 00:00:00');
        }

        $news->update($data);

        return redirect()->route('admin.news.index')->with('success', '✓ Berita berhasil diperbarui!');
    }

    /**
     * Hapus berita
     */
    public function destroy(News $news)
    {
        if (!Schema::hasTable("news")) {
            return redirect()
                ->route("admin.news.index")
                ->with("warning", "Tabel berita belum tersedia di database.");
        }

        // Hapus file media utama
        ImageHelper::deleteNewsMedia($news->file);

        // Hapus galeri berita jika ada
        foreach (is_array($news->gallery) ? $news->gallery : [] as $galleryImage) {
            ImageHelper::deleteNewsMedia($galleryImage);
        }

        // Hapus record
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', '✓ Berita berhasil dihapus!');
    }
}
