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

        // For Principle Logo management we only accept a name, link (stored in `brand`) and an optional image
        $rules = [
            'nama_obat' => ['required', 'string', 'max:255'],
            'brand'     => ['nullable', 'string', 'max:1024'], // used to store partner link
            // 'gambar' may be a file upload OR we accept a base64 string in 'cropped_image'
            'gambar'    => ['nullable'],
              'cropped_image' => ['nullable', 'regex:/^data:image\/(gif|jpeg|png|webp);base64,([A-Za-z0-9+\\/=]+)$/'],
        ];
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if ($user?->isSuperAdmin()) {
            $rules['kategori'] = ['required', 'in:' . implode(',', $this->outletOptions)];
        }

        $validated = $request->validate($rules);

        // If frontend provided a cropped image (base64), prefer that over raw upload
        if ($request->filled('cropped_image')) {
            try {
                $validated['gambar'] = ImageHelper::storeBase64BannerImage($request->input('cropped_image'));
            } catch (\Exception $e) {
                // ignore and continue without gambar
            }
        } elseif ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            // validate uploaded file explicitly to produce proper messages
            $request->validate(['gambar' => ['file', 'image', 'max:10240']]);
            $validated['gambar'] = ImageHelper::storeBannerImage($request->file('gambar'));
        }

        if ($outlet = $user?->outlet_name) {
            $validated['kategori'] = $outlet;
        }

        // Only store fields relevant to principle logos
        $toCreate = array_intersect_key($validated, array_flip(['nama_obat', 'brand', 'gambar', 'kategori']));

        // Ensure non-nullable columns in medicines table have safe defaults
        if (!array_key_exists('harga', $toCreate)) {
            $toCreate['harga'] = 0;
        }
        if (!array_key_exists('stok', $toCreate)) {
            $toCreate['stok'] = 0;
        }
        if (!array_key_exists('terjual', $toCreate)) {
            $toCreate['terjual'] = 0;
        }
        // Some older migrations require `deskripsi` to be non-null — provide empty default
        if (!array_key_exists('deskripsi', $toCreate)) {
            $toCreate['deskripsi'] = '';
        }

        Medicine::create($toCreate);

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

        // Only allow name, partner link (brand) and image operations for principle logos
        $rules = [
            'nama_obat'     => ['required', 'string', 'max:255'],
            'brand'         => ['nullable', 'string', 'max:1024'],
            'gambar'        => ['nullable'],
            'cropped_image' => ['nullable', 'regex:/^data:image\/(gif|jpeg|png|webp);base64,([A-Za-z0-9+/=]+)$/'],
            'delete_gambar' => ['nullable'],
        ];
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if ($user?->isSuperAdmin()) {
            $rules['kategori'] = ['required', 'in:' . implode(',', $this->outletOptions)];
        }

        $validated = $request->validate($rules);

        unset($validated['delete_gambar']);

        $this->authorizeOutletProduct($produk);

        if ($request->filled('cropped_image')) {
            // New cropped image from client - prefer this
            ImageHelper::deleteBannerImage($produk->gambar);
            try {
                $validated['gambar'] = ImageHelper::storeBase64BannerImage($request->input('cropped_image'));
            } catch (\Exception $e) {
                // ignore
            }
        } elseif ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
            // validate uploaded file explicitly to produce proper messages
            $request->validate(['gambar' => ['file', 'image', 'max:10240']]);
            ImageHelper::deleteBannerImage($produk->gambar);
            $validated['gambar'] = ImageHelper::storeBannerImage($request->file('gambar'));
        } elseif ($request->input('delete_gambar') == '1' && $produk->gambar) {
            ImageHelper::deleteBannerImage($produk->gambar);
            $validated['gambar'] = null;
        }

        // Only keep fields we expect for principle logos
        $allowed = ['nama_obat', 'brand', 'gambar', 'kategori', 'kategori_produk'];
        $toUpdate = array_intersect_key($validated, array_flip($allowed));

        $produk->update($toUpdate);

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
        ImageHelper::deleteBannerImage($produk->gambar);
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
            ImageHelper::deleteBannerImage($produk->gambar);
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

        $validated = $request->validate(['stok' => ['nullable', 'integer', 'min:0']]);
        if ($request->has('stok')) {
            $produk->update(['stok' => $validated['stok']]);
        }

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

        $validated = $request->validate(['harga' => ['nullable', 'numeric', 'min:0']]);
        if ($request->has('harga')) {
            $produk->update(['harga' => $validated['harga']]);
        }

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
