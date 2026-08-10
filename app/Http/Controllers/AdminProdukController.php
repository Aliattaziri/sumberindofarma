<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\ProductCategory;
use App\Constants\Companies;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminProdukController extends Controller
{
    private function getKategoriProduk(): array
    {
        return ProductCategory::getList();
    }
    private array $outletOptions = [
        'Alfa Sintang',
        'Alfa Air Upas',
        'Alfa Kendawangan',
        'Alfa Balai Berkuak',
        'Alfa Nanga Tayap',
        'Alfa Tumbang Titi',
        'Alfa Sosok',
        'Alfa Bodok',
        'Alfa Kembayan',
        'Alfa Ambawang',
        'Alfa Jungkat',
        'Alfa Mempawah',
        'PBF',
        'Apotek Medistra Farma',
    ];

    public function index(Request $request)
    {
        if ($redirect = $this->blockSuperAdminProductControl()) {
            return $redirect;
        }

        $search          = $request->get('search', '');
        $kategori_produk = $request->get('kategori_produk', '');
        $brand           = $request->get('brand', '');

        $baseQuery = Medicine::query();
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        $outlet = $user?->outlet_name;
        if ($outlet) {
            $baseQuery->where('kategori', $outlet);
        }

        if ($search) {
            $baseQuery->where(function ($q) use ($search) {
                $q->where('nama_obat', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($brand) {
            $baseQuery->where('brand', 'like', "%{$brand}%");
        }

        $query = (clone $baseQuery)->latest();
        if ($kategori_produk) {
            $query->where('kategori_produk', $kategori_produk);
        }

        $medicines       = $query->paginate(15)->withQueryString();
        $total           = (clone $query)->count();
        $kategoriOptions = $this->getKategoriProduk();
        $kategoriCounts  = [];
        foreach ($kategoriOptions as $kat) {
            $kategoriCounts[$kat] = (clone $baseQuery)->where('kategori_produk', $kat)->count();
        }
        // Tambahkan kategori yang ada di DB tapi belum di list (misal dari import)
        $extraKats = (clone $baseQuery)
            ->whereNotNull('kategori_produk')
            ->whereNotIn('kategori_produk', $kategoriOptions)
            ->distinct()
            ->pluck('kategori_produk');
        foreach ($extraKats as $ek) {
            $kategoriOptions[] = $ek;
            $kategoriCounts[$ek] = (clone $baseQuery)->where('kategori_produk', $ek)->count();
        }
        $totalAll = array_sum($kategoriCounts);

        return view('admin.produk.index', compact(
            'medicines', 'search', 'kategori_produk', 'brand', 'total', 'kategoriOptions', 'kategoriCounts', 'totalAll'
        ));
    }

    public function create()
    {
        if ($redirect = $this->blockSuperAdminProductControl()) {
            return $redirect;
        }

        return view('admin.produk.create', [
            'kategoriOptions' => $this->getKategoriProduk(),
            'outletOptions'  => $this->outletOptions,
        ]);
    }

    public function store(Request $request)
    {
        if ($redirect = $this->blockSuperAdminProductControl()) {
            return $redirect;
        }

        $rules = [
            'nama_obat'       => ['required', 'string', 'max:255'],
            'kategori_produk' => ['required', 'string', 'max:100'],
            'kategori'        => ['required', 'string', 'max:255'],
            'sku'             => ['nullable', 'string', 'max:255'],
            'brand'           => ['nullable', 'string', 'max:255'],
            'terjual'         => ['nullable', 'integer', 'min:0'],
            'harga'           => ['required', 'numeric', 'min:0'],
            'stok'            => ['required', 'integer', 'min:0'],
            'sediaan'         => ['nullable', 'string', 'max:255'],
            'deskripsi'       => ['nullable', 'string'],
            'komposisi'       => ['nullable', 'string'],
            'indikasi'        => ['nullable', 'string'],
        ];
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if ($user?->isSuperAdmin()) {
            $rules['kategori'] = ['required', 'in:' . implode(',', $this->outletOptions)];
        }

        $validated = $request->validate($rules);

        // Normalisasi kategori_produk dan pastikan ada di DB
        $validated['kategori_produk'] = \App\Models\ProductCategory::ensureExists($validated['kategori_produk']);

        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            $validated['gambar'] = ImageHelper::storeProductImage($request->file('gambar'));
        }

        if ($outlet = $user?->outlet_name) {
            $validated['kategori'] = $outlet;
        }

        if (!empty(trim($validated['deskripsi'] ?? ''))) {
            $validated['deskripsi'] = trim($validated['deskripsi']);
        } else {
            $validated['deskripsi'] = trim(($validated['komposisi'] ?? '') . ' | ' . ($validated['indikasi'] ?? ''));
        }

        Medicine::create($validated);

        return redirect()->route('admin.produk.index')
                         ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Medicine $produk)
    {
        if ($redirect = $this->blockSuperAdminProductControl()) {
            return $redirect;
        }

        $this->authorizeOutletProduct($produk);

        return view('admin.produk.edit', [
            'medicine'        => $produk,
            'kategoriOptions' => $this->getKategoriProduk(),
            'outletOptions'   => $this->outletOptions,
        ]);
    }

    public function update(Request $request, Medicine $produk)
    {
        if ($redirect = $this->blockSuperAdminProductControl()) {
            return $redirect;
        }

        $rules = [
            'nama_obat'       => ['required', 'string', 'max:255'],
            'kategori_produk' => ['required', 'string', 'max:100'],
            'kategori'        => ['required', 'string', 'max:255'],
            'sku'             => ['nullable', 'string', 'max:255'],
            'brand'           => ['nullable', 'string', 'max:255'],
            'terjual'         => ['nullable', 'integer', 'min:0'],
            'harga'           => ['required', 'numeric', 'min:0'],
            'stok'            => ['required', 'integer', 'min:0'],
            'sediaan'         => ['nullable', 'string', 'max:255'],
            'deskripsi'       => ['nullable', 'string'],
            'komposisi'       => ['nullable', 'string'],
            'indikasi'        => ['nullable', 'string'],
            'delete_gambar'   => ['nullable'],
        ];
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if ($user?->isSuperAdmin()) {
            $rules['kategori'] = ['required', 'in:' . implode(',', $this->outletOptions)];
        }

        $validated = $request->validate($rules);

        unset($validated['delete_gambar']);

        // Normalisasi kategori_produk dan pastikan ada di DB
        $validated['kategori_produk'] = \App\Models\ProductCategory::ensureExists($validated['kategori_produk']);

        $this->authorizeOutletProduct($produk);

        if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            ImageHelper::deleteProductImage($produk->gambar);
            $validated['gambar'] = ImageHelper::storeProductImage($request->file('gambar'));
        } elseif ($request->input('delete_gambar') == '1' && $produk->gambar) {
            ImageHelper::deleteProductImage($produk->gambar);
            $validated['gambar'] = null;
        }

        if (!empty(trim($validated['deskripsi'] ?? ''))) {
            $validated['deskripsi'] = trim($validated['deskripsi']);
        } else {
            $validated['deskripsi'] = trim(($validated['komposisi'] ?? '') . ' | ' . ($validated['indikasi'] ?? ''));
        }

        $produk->update($validated);

        $queryParams = $this->buildIndexQueryParams($request);

        return redirect()->route('admin.produk.index', $queryParams)
                         ->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy(Request $request, Medicine $produk)
    {
        if ($redirect = $this->blockSuperAdminProductControl()) {
            return $redirect;
        }

        $this->authorizeOutletProduct($produk);
        ImageHelper::deleteProductImage($produk->gambar);
        $produk->delete();

        $queryParams = $this->buildIndexQueryParams($request);

        return redirect()->route('admin.produk.index', $queryParams)
                         ->with('success', 'Produk berhasil dihapus!');
    }

    public function destroyMany(Request $request)
    {
        if ($redirect = $this->blockSuperAdminProductControl()) {
            return $redirect;
        }

        $selectedIds = $request->input('produk_ids', []);

        if (empty($selectedIds) || !is_array($selectedIds)) {
            return redirect()->route('admin.produk.index', $this->buildIndexQueryParams($request))
                             ->with('error', 'Pilih minimal satu produk untuk dihapus.');
        }

        $selectedIds = array_filter(array_map('intval', $selectedIds));

        if (empty($selectedIds)) {
            return redirect()->route('admin.produk.index', $this->buildIndexQueryParams($request))
                             ->with('error', 'Pilih minimal satu produk untuk dihapus.');
        }

        $products = Medicine::whereIn('id', $selectedIds)
            ->when(Auth::user()?->outlet_name, fn($q, $outlet) => $q->where('kategori', $outlet))
            ->get();

        if (count($products) !== count($selectedIds)) {
            abort(403);
        }

        foreach ($products as $produk) {
            ImageHelper::deleteProductImage($produk->gambar);
            $produk->delete();
        }

        $queryParams = $this->buildIndexQueryParams($request);

        return redirect()->route('admin.produk.index', $queryParams)
                         ->with('success', 'Sebanyak ' . count($products) . ' produk berhasil dihapus!');
    }

    private function authorizeOutletProduct(Medicine $produk): void
    {
        $outlet = Auth::user()?->outlet_name;
        if ($outlet && $produk->kategori !== $outlet) {
            abort(403);
        }
    }

    private function buildIndexQueryParams(Request $request): array
    {
        $params = [];

        foreach (['search', 'kategori_produk', 'pabrik', 'page'] as $field) {
            $value = $request->query($field, $request->input($field));
            if ($value !== null && $value !== '') {
                $params[$field] = $value;
            }
        }

        return $params;
    }

    public function updateStock(Request $request, Medicine $produk)
    {
        if ($redirect = $this->blockSuperAdminProductControl()) {
            return $redirect;
        }

        $validated = $request->validate(['stok' => ['required', 'integer', 'min:0']]);
        $produk->update(['stok' => $validated['stok']]);

        if ($request->wantsJson() || $request->header('Accept') === 'application/json') {
            return response()->json([
                'message' => 'Stok berhasil diupdate!',
                'stok' => $produk->stok,
            ]);
        }

        return back()->with('success', 'Stok berhasil diupdate!');
    }

    public function updatePrice(Request $request, Medicine $produk)
    {
        if ($redirect = $this->blockSuperAdminProductControl()) {
            return $redirect;
        }

        $validated = $request->validate(['harga' => ['required', 'numeric', 'min:0']]);
        $produk->update(['harga' => $validated['harga']]);

        if ($request->wantsJson() || $request->header('Accept') === 'application/json') {
            return response()->json([
                'message' => 'Harga berhasil diupdate!',
                'harga' => 'Rp ' . number_format($produk->harga, 0, ',', '.'),
            ]);
        }

        return back()->with('success', 'Harga berhasil diupdate!');
    }

    public function show(Medicine $produk)
    {
        if ($redirect = $this->blockSuperAdminProductControl()) {
            return $redirect;
        }

        return redirect()->route('admin.produk.index');
    }

    private function blockSuperAdminProductControl()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if ($user && $user->isSuperAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Akun admin utama tidak memiliki akses kontrol produk.');
        }

        return null;
    }
}
