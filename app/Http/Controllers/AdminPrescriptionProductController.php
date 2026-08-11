<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\ProductCategory;
use App\Constants\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ImageHelper;

class AdminPrescriptionProductController extends Controller
{
    private function getCategories(): array
    {
        return ProductCategory::getList();
    }

    // List produk resep
    public function index(Request $request)
    {
        $user            = Auth::user();
        $outlet          = $user?->outlet_name;
        $search          = $request->input('search');
        $kategori        = $request->input('kategori');
        $kategori_produk = $request->input('kategori_produk');
        $brand           = $request->input('brand');

        $query = Medicine::where('is_resep', true)->latest();

        if ($outlet) {
            $query->where('kategori', $outlet);
            $kategori = $outlet;
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_obat', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($kategori && !$outlet) {
            $query->where('brand', $kategori);
        }

        if ($kategori_produk) {
            $query->where('kategori_produk', $kategori_produk);
        }

        if ($brand) {
            $query->where('brand', 'like', "%{$brand}%");
        }

        $medicines       = $query->paginate(10)->withQueryString();
        $categories      = Medicine::where('is_resep', true)
                            ->select('brand')
                            ->whereNotNull('brand')
                            ->where('brand', '!=', '')
                            ->distinct()
                            ->orderBy('brand')
                            ->pluck('brand');
        $kategoriOptions = ProductCategory::getList();

        return view('admin.prescriptions.products.index', compact('medicines', 'search', 'kategori', 'brand', 'categories', 'kategori_produk', 'kategoriOptions'));
    }

    // Form tambah produk resep
    public function create()
    {
        return view('admin.prescriptions.products.create', ['categories' => $this->getCategories()]);
    }

    // Simpan produk resep baru
    public function store(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'nama_obat' => ['required', 'string', 'max:255'],
            'kategori'  => ['required', 'string'],
            'harga'     => ['required', 'numeric', 'min:0'],
            'stok'      => ['required', 'integer', 'min:0'],
            'sediaan'   => ['nullable', 'string', 'max:255'],
            'komposisi' => ['required', 'string', 'max:255'],
            'indikasi'  => ['required', 'string', 'max:255'],
            'golongan'  => ['required', 'in:BEBAS,KERAS'],
            'gambar'    => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif'],
        ]);

        // Tentukan is_resep berdasarkan golongan
        $validated['is_resep'] = ($validated['golongan'] === 'KERAS');
        
        // Gabung komposisi dan indikasi untuk deskripsi
        $validated['deskripsi'] = $validated['komposisi'] . ' | ' . $validated['indikasi'];
        
        // Hapus field yang tidak perlu di database
        unset($validated['komposisi']);
        unset($validated['indikasi']);
        unset($validated['golongan']);

        // Handle upload gambar
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = ImageHelper::storeProductImage($request->file('gambar'));
        }

        if ($user?->outlet_name) {
            $validated['kategori'] = $user->outlet_name;
        }

        Medicine::create($validated);

        return redirect()->route('admin.prescriptions.products.index')
                       ->with('success', 'Produk resep berhasil ditambahkan!');
    }

    // Form edit produk resep
    public function edit(Medicine $product)
    {
        if (!$product->is_resep) {
            abort(404);
        }
        $this->authorizeOutletProduct($product);

        return view('admin.prescriptions.products.edit', [
            'medicine'   => $product,
            'categories' => $this->getCategories(),
        ]);
    }

    // Update produk resep
    public function update(Request $request, Medicine $product)
    {
        if (!$product->is_resep) {
            abort(404);
        }
        $this->authorizeOutletProduct($product);
        $user = Auth::user();

        $validated = $request->validate([
            'nama_obat' => ['required', 'string', 'max:255'],
            'kategori'  => ['required', 'string'],
            'harga'     => ['required', 'numeric', 'min:0'],
            'stok'      => ['required', 'integer', 'min:0'],
            'sediaan'   => ['nullable', 'string', 'max:255'],
            'komposisi' => ['required', 'string', 'max:255'],
            'indikasi'  => ['required', 'string', 'max:255'],
            'golongan'  => ['required', 'in:BEBAS,KERAS'],
            'gambar'    => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif'],
            'delete_gambar' => ['nullable', 'boolean'],
        ]);

        // Tentukan is_resep berdasarkan golongan
        $validated['is_resep'] = ($validated['golongan'] === 'KERAS');
        
        // Gabung komposisi dan indikasi untuk deskripsi
        $validated['deskripsi'] = $validated['komposisi'] . ' | ' . $validated['indikasi'];
        
        // Hapus field yang tidak perlu di database
        unset($validated['komposisi']);
        unset($validated['indikasi']);
        unset($validated['golongan']);
        unset($validated['delete_gambar']);

        // Handle upload gambar baru
        if ($request->hasFile('gambar')) {
            ImageHelper::deleteProductImage($product->gambar);
            $validated['gambar'] = ImageHelper::storeProductImage($request->file('gambar'));
        } elseif ($request->input('delete_gambar') == '1' && $product->gambar) {
            ImageHelper::deleteProductImage($product->gambar);
            $validated['gambar'] = null;
        }

        if ($user?->outlet_name) {
            $validated['kategori'] = $user->outlet_name;
        }

        $product->update($validated);

        $queryParams = $this->buildIndexQueryParams($request);

        return redirect()->route('admin.prescriptions.products.index', $queryParams)
                       ->with('success', 'Produk resep berhasil diupdate!');
    }

    // Hapus produk resep
    public function destroy(Request $request, Medicine $product)
    {
        if (!$product->is_resep) {
            abort(404);
        }
        $this->authorizeOutletProduct($product);

        ImageHelper::deleteProductImage($product->gambar);
        $product->delete();

        $queryParams = $this->buildIndexQueryParams($request);

        return redirect()->route('admin.prescriptions.products.index', $queryParams)
                       ->with('success', 'Produk resep berhasil dihapus!');
    }

    private function buildIndexQueryParams(Request $request): array
    {
        $params = [];

        foreach (['search', 'kategori', 'page'] as $field) {
            $value = $request->query($field, $request->input($field));
            if ($value !== null && $value !== '') {
                $params[$field] = $value;
            }
        }

        return $params;
    }

    // Update stok produk resep
    public function updateStock(Request $request, Medicine $product)
    {
        if (!$product->is_resep) {
            abort(404);
        }
        $this->authorizeOutletProduct($product);

        $validated = $request->validate([
            'stok' => ['required', 'integer', 'min:0'],
        ]);

        $product->update(['stok' => $validated['stok']]);

        if ($request->wantsJson() || $request->header('Accept') === 'application/json') {
            return response()->json([
                'message' => 'Stok produk resep berhasil diupdate!',
                'stok' => $product->stok,
            ]);
        }

        return back()->with('success', 'Stok produk resep berhasil diupdate!');
    }

    public function updatePrice(Request $request, Medicine $product)
    {
        if (!$product->is_resep) {
            abort(404);
        }
        $this->authorizeOutletProduct($product);

        $validated = $request->validate([
            'harga' => ['required', 'numeric', 'min:0'],
        ]);

        $product->update(['harga' => $validated['harga']]);

        if ($request->wantsJson() || $request->header('Accept') === 'application/json') {
            return response()->json([
                'message' => 'Harga produk resep berhasil diupdate!',
                'harga' => 'Rp ' . number_format($product->harga, 0, ',', '.'),
            ]);
        }

        return back()->with('success', 'Harga produk resep berhasil diupdate!');
    }

    private function authorizeOutletProduct(Medicine $product): void
    {
        $outlet = Auth::user()?->outlet_name;
        if ($outlet && $product->kategori !== $outlet) {
            abort(403);
        }
    }
}
