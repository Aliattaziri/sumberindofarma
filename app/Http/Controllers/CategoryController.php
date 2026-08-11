<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Layer 2: Halaman kategori dengan sub-kategori dan produk
     */
    public function layer2(Request $request)
    {
        $mainCategory = $request->get('main', 'obat');
        $subCategory  = $request->get('sub', '');
        $search       = $request->get('search', '');

        // Validasi kategori
        $validCategories = $this->getValidCategories();
        if (!array_key_exists($mainCategory, $validCategories)) {
            abort(404, 'Kategori tidak ditemukan');
        }

        if ($mainCategory === 'pbf') {
            return redirect()->route('products.pbf');
        }

        // Query produk berdasarkan kategori, tanpa menyertakan produk PBF
        $query = Medicine::nonPbf();

        // Filter berdasarkan kategori dan sub-kategori
        $query = $this->filterByCategory($query, $mainCategory, $subCategory);

        // Filter berdasarkan search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_obat', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $medicines = $query->latest()->paginate(15)->withQueryString();

        return view('category-layer2', compact(
            'mainCategory',
            'subCategory',
            'medicines',
            'search'
        ));
    }

    /**
     * Mapping kategori utama (URL slug) ke keyword pencarian di DB.
     * Kategori kustom dari DB yang tidak masuk mapping akan ikut
     * ditampilkan melalui filterCustomCategories().
     */
    private function getValidCategories(): array
    {
        return [
            'alkes' => [
                'ortopedi'      => 'Alkes Ortopedi',
                'gigi'          => 'Alkes Gigi',
                'electrical'    => 'Alkes Electrical',
                'non-electrical'=> 'Alkes Non Electrical',
            ],
            'kecantikan' => [
                'skincare'  => 'Skincare',
                'kosmetik'  => 'Kosmetik',
                'material'  => 'Material Klinik',
            ],
            'apotik' => [
                'oral'     => 'Obat Oral',
                'injeksi'  => 'Obat Injeksi',
                'luar'     => 'Obat Luar',
                'otc'      => 'Obat OTC',
                'susu'     => 'Susu',
                'suplemen' => 'Suplemen',
                'herbal'   => 'Herbal',
            ],
            'pbf' => [],
        ];
    }

    /**
     * Filter query berdasarkan kategori utama dan sub-kategori.
     * Mencakup semua alias (alkes / alat kesehatan, dll.) dan
     * semua kategori kustom yang tersimpan di tabel product_categories.
     */
    private function filterByCategory($query, string $mainCategory, string $subCategory)
    {
        $categories = $this->getValidCategories();

        if (!isset($categories[$mainCategory])) {
            return $query;
        }

        $categoryMap = $categories[$mainCategory];

        if ($subCategory && isset($categoryMap[$subCategory])) {
            $categoryName = $categoryMap[$subCategory];
            $query->where(function ($q) use ($categoryName, $mainCategory) {
                $q->where('kategori', 'like', "%{$categoryName}%")
                  ->orWhere('kategori_produk', 'like', "%{$categoryName}%");
            });
        } else {
            // Filter berdasarkan kategori utama + semua alias yang relevan
            $query->where(function ($q) use ($mainCategory) {
                if ($mainCategory === 'kecantikan') {
                    $q->where('kategori_produk', 'like', '%SKINCARE%')
                      ->orWhere('kategori_produk', 'like', '%KOSMETIK%')
                      ->orWhere('kategori_produk', 'like', '%KECANTIKAN%');

                    // Tambahkan kategori kustom yang sesuai dari DB
                    $this->addCustomCategoryFilters($q, ['SKINCARE', 'KOSMETIK', 'KECANTIKAN', 'BEAUTY']);

                } elseif ($mainCategory === 'alkes') {
                    $q->where('kategori_produk', 'like', '%ALAT KESEHATAN%')
                      ->orWhere('kategori_produk', 'like', '%ALKES%')
                      ->orWhere('kategori_produk', 'like', '%MEDICAL%');

                    // Tambahkan kategori kustom yang sesuai dari DB
                    $this->addCustomCategoryFilters($q, ['ALAT KESEHATAN', 'ALKES', 'MEDICAL']);

                } elseif ($mainCategory === 'apotik') {
                    $q->where('kategori_produk', 'like', '%OBAT%')
                      ->orWhere('kategori_produk', 'like', '%APOTIK%')
                      ->orWhere('kategori_produk', 'like', '%APOTEK%')
                      ->orWhere('kategori_produk', 'like', '%FARMASI%')
                      ->orWhere('kategori', 'like', '%Apotik%');

                    // Tambahkan kategori kustom yang sesuai dari DB
                    $this->addCustomCategoryFilters($q, ['OBAT', 'APOTEK', 'APOTIK', 'FARMASI']);
                }
            });
        }

        return $query;
    }

    /**
     * Tambahkan OR filter untuk setiap kategori kustom di DB
     * yang mengandung salah satu keyword yang diberikan.
     */
    private function addCustomCategoryFilters($query, array $keywords): void
    {
        try {
            $customCategories = ProductCategory::orderBy('sort_order')->pluck('name');
            foreach ($customCategories as $cat) {
                $upper = strtoupper($cat);
                foreach ($keywords as $kw) {
                    if (str_contains($upper, $kw)) {
                        $query->orWhere('kategori_produk', $cat);
                        break;
                    }
                }
            }
        } catch (\Throwable) {
            // Tabel belum ada, skip
        }
    }
}
