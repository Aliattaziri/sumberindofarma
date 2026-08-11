<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\ProductCategory;
use App\Constants\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ImageHelper;

class AdminMedicineController extends Controller
{
    // List obat
    public function index(Request $request)
    {
        $search          = $request->input('search');
        $kategori        = $request->input('kategori');
        $kategori_produk = $request->input('kategori_produk');
        $brand           = $request->input('brand');
        $tipe            = $request->input('tipe'); // 'biasa' atau 'resep'

        $query = Medicine::where('is_grosir', false)->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_obat', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($kategori) {
            $query->where('brand', $kategori);
        }

        if ($kategori_produk) {
            $query->where('kategori_produk', $kategori_produk);
        }

        if ($brand) {
            $query->where('brand', 'like', "%{$brand}%");
        }

        if ($tipe === 'resep') {
            $query->where('is_resep', true);
        } elseif ($tipe === 'biasa') {
            $query->where('is_resep', false);
        }

        $medicines       = $query->paginate(10)->withQueryString();
        $categories      = Medicine::where('is_grosir', false)
                            ->select('brand')
                            ->whereNotNull('brand')
                            ->where('brand', '!=', '')
                            ->distinct()
                            ->orderBy('brand')
                            ->pluck('brand');
        $kategoriOptions = ProductCategory::getList();

        return view('admin.medicines.index', compact('medicines', 'search', 'kategori', 'brand', 'tipe', 'categories', 'kategori_produk', 'kategoriOptions'));
    }

    // Form tambah obat
    public function create()
    {
        return view('admin.medicines.create', ['categories' => ProductCategory::getList()]);
    }

    // Simpan obat baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_obat' => ['required', 'string', 'max:255'],
            'kelompok'  => ['nullable', 'in:PBF,APOTEK'],
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
        // Produk retail tidak pernah grosir
        $validated['is_grosir'] = false;
        
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

        Medicine::create($validated);

        return redirect()->route('admin.medicines.index')
                       ->with('success', 'Obat berhasil ditambahkan!');
    }

    // Form edit obat
    public function edit(Medicine $medicine)
    {
        return view('admin.medicines.edit', [
            'medicine'   => $medicine,
            'categories' => ProductCategory::getList(),
        ]);
    }

    // Update obat
    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'nama_obat' => ['required', 'string', 'max:255'],
            'kelompok'  => ['nullable', 'in:PBF,APOTEK'],
            'kategori'  => ['required', 'string'],
            'harga'     => ['required', 'numeric', 'min:0'],
            'stok'      => ['required', 'integer', 'min:0'],
            'sediaan'   => ['nullable', 'string', 'max:255'],
            // 'grade' removed to avoid exposing grade in product flows
            'komposisi' => ['required', 'string', 'max:255'],
            'indikasi'  => ['required', 'string', 'max:255'],
            'golongan'  => ['required', 'in:BEBAS,KERAS'],
            'gambar'    => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif'],
            'delete_gambar' => ['nullable', 'boolean'],
        ]);

        // Tentukan is_resep berdasarkan golongan
        $validated['is_resep'] = ($validated['golongan'] === 'KERAS');
        // grade removed — do not store or modify grade here
        // Produk retail tidak pernah grosir
        $validated['is_grosir'] = false;
        
        // Gabung komposisi dan indikasi untuk deskripsi
        $validated['deskripsi'] = $validated['komposisi'] . ' | ' . $validated['indikasi'];
        
        // Hapus field yang tidak perlu di database
        unset($validated['komposisi']);
        unset($validated['indikasi']);
        unset($validated['golongan']);
        unset($validated['delete_gambar']);

        // Handle upload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            ImageHelper::deleteProductImage($medicine->gambar);
            // Upload gambar baru
            $validated['gambar'] = ImageHelper::storeProductImage($request->file('gambar'));
        } elseif ($request->input('delete_gambar') == '1' && $medicine->gambar) {
            ImageHelper::deleteProductImage($medicine->gambar);
            $validated['gambar'] = null;
        }

        $medicine->update($validated);

        $queryParams = $this->buildIndexQueryParams($request);

        return redirect()->route('admin.medicines.index', $queryParams)
                       ->with('success', 'Obat berhasil diupdate!');
    }

    // Hapus obat
    public function destroy(Request $request, Medicine $medicine)
    {
        ImageHelper::deleteProductImage($medicine->gambar);
        $medicine->delete();

        $queryParams = $this->buildIndexQueryParams($request);

        return redirect()->route('admin.medicines.index', $queryParams)
                       ->with('success', 'Obat berhasil dihapus!');
    }

    // Update stok
    private function buildIndexQueryParams(Request $request): array
    {
        $params = [];

        foreach (['search', 'kategori', 'tipe', 'page'] as $field) {
            $value = $request->query($field, $request->input($field));
            if ($value !== null && $value !== '') {
                $params[$field] = $value;
            }
        }

        return $params;
    }

    public function updateStock(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'stok' => ['required', 'integer', 'min:0'],
        ]);

        $medicine->update(['stok' => $validated['stok']]);

        if ($request->wantsJson() || $request->header('Accept') === 'application/json') {
            return response()->json([
                'message' => 'Stok berhasil diupdate!',
                'stok' => $medicine->stok,
            ]);
        }

        return back()->with('success', 'Stok berhasil diupdate!');
    }

    public function updatePrice(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'harga' => ['required', 'numeric', 'min:0'],
        ]);

        $medicine->update(['harga' => $validated['harga']]);

        if ($request->wantsJson() || $request->header('Accept') === 'application/json') {
            return response()->json([
                'message' => 'Harga berhasil diupdate!',
                'harga' => $medicine->getFormattedPrice(),
            ]);
        }

        return back()->with('success', 'Harga berhasil diupdate!');
    }
}
