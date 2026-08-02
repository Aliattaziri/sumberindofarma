<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Constants\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Halaman Produk Kami (frontend)
     */
    public function index(Request $request)
    {
        $search          = $request->get('search', '');
        $kategori_produk = $request->get('kategori_produk', '');
        $perusahaan      = $request->get('perusahaan', '');
        $sort            = $request->get('sort', 'terbaru');

        $query = Medicine::nonPbf();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_obat', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($kategori_produk) {
            $query->where('kategori_produk', $kategori_produk);
        }

        if ($perusahaan) {
            $query->where('kategori', $perusahaan);
        }

        match ($sort) {
            'harga_asc'  => $query->orderBy('harga', 'asc'),
            'harga_desc' => $query->orderBy('harga', 'desc'),
            'nama'       => $query->orderBy('nama_obat', 'asc'),
            default      => $query->latest(),
        };

        $medicines       = $query->paginate(12)->withQueryString();
        $total           = Medicine::nonPbf()->count();
        $kategoriOptions = Companies::LIST;
        // Ambil daftar perusahaan unik dari data yang ada di DB
        $perusahaanList  = Medicine::nonPbf()
                            ->select('kategori')
                            ->whereNotNull('kategori')
                            ->where('kategori', '!=', '')
                            ->distinct()
                            ->orderBy('kategori')
                            ->pluck('kategori');

        return view('products', compact(
            'medicines', 'search', 'kategori_produk', 'perusahaan',
            'sort', 'total', 'kategoriOptions', 'perusahaanList'
        ));
    }

    public function update(Request $request, $id)
    {
        $medicine = Medicine::findOrFail($id);
        if ($request->hasFile('gambar')) {
            \App\Helpers\ImageHelper::deleteProductImage($medicine->gambar);
            $path = \App\Helpers\ImageHelper::storeProductImage($request->file('gambar'));
            $medicine->update(['gambar' => $path]);
        }
        return back()->with('success', 'Foto berhasil diperbarui!');
    }

    /**
     * Halaman show detail produk (public)
     */
    public function show($id)
    {
        $medicine = Medicine::findOrFail($id);
        $relatedMedicines = Medicine::where('kategori', $medicine->kategori)
                                    ->where('id', '!=', $medicine->id)
                                    ->limit(4)
                                    ->get();
        return view('medicines.detail', compact('medicine', 'relatedMedicines'));
    }

    /**
     * Kode akses PBF — 10 kode akses (PBF1000 sampai PBF1010)
     */
    const PBF_ACCESS_CODES = [
        'PBF1000',
        'PBF1001',
        'PBF1002',
        'PBF1003',
        'PBF1004',
        'PBF1005',
        'PBF1006',
        'PBF1007',
        'PBF1008',
        'PBF1009',
        'PBF1010',
    ];

    /**
     * Gate Produk PBF - form akses kode PBF
     */
    public function pbfGate(Request $request)
    {
        return view('products_pbf_gate');
    }

    /**
     * Halaman Produk PBF (frontend) — dilindungi kode akses
     */
    public function pbf(Request $request)
    {
        $hasPbfAccess = $request->session()->get('pbf_access', false);

        if (! $hasPbfAccess && ! (Auth::check() && Auth::user()->isSuperAdmin())) {
            return redirect()->route('products.pbf.gate')
                ->with('error', 'Silakan masukkan kode akses PBF terlebih dahulu untuk membuka katalog.');
        }

        $search          = $request->get('search', '');
        $kategori_produk = $request->get('kategori_produk', '');
        $perusahaan      = $request->get('perusahaan', '');
        $sort            = $request->get('sort', 'terbaru');

        $query = Medicine::where('kelompok', 'PBF');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_obat', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($kategori_produk) {
            $query->where('kategori_produk', $kategori_produk);
        }

        if ($perusahaan) {
            $query->where('kategori', $perusahaan);
        }

        match ($sort) {
            'harga_asc'  => $query->orderBy('harga', 'asc'),
            'harga_desc' => $query->orderBy('harga', 'desc'),
            'nama'       => $query->orderBy('nama_obat', 'asc'),
            default      => $query->latest(),
        };

        $medicines       = $query->paginate(12)->withQueryString();
        $total           = Medicine::where('kelompok', 'PBF')->count();
        $kategoriOptions = Companies::LIST;
        $perusahaanList  = Medicine::where('kelompok', 'PBF')
                            ->select('kategori')
                            ->whereNotNull('kategori')
                            ->where('kategori', '!=', '')
                            ->distinct()
                            ->orderBy('kategori')
                            ->pluck('kategori');

        return view('products_pbf', compact(
            'medicines', 'search', 'kategori_produk', 'perusahaan',
            'sort', 'total', 'kategoriOptions', 'perusahaanList'
        ));
    }

    /**
     * Verifikasi kode akses PBF
     */
    public function pbfVerify(Request $request)
    {
        $kode = strtoupper(trim($request->input('kode', '')));

        if (empty($kode)) {
            return redirect()->route('products.pbf')
                ->withErrors(['kode' => '⚠️ Kode akses tidak boleh kosong. Silakan masukkan kode Anda.'])
                ->withInput();
        }

        // Kode akses valid: sumberindo111 sampai sumberindo999
        if (preg_match('/^SUMBERINDO(?:111|[1-9][0-9]{2})$/', $kode)) {
            $request->session()->put('pbf_access', true);
            return redirect()->route('products.pbf')
                ->with('pbf_success', '✅ Akses berhasil! Selamat datang di Katalog PBF.');
        }

        return redirect()->route('products.pbf')
            ->withErrors(['kode' => '❌ Kode akses salah atau tidak valid. Periksa kembali atau hubungi admin via WhatsApp.'])
            ->withInput();
    }

    /**
     * Logout dari sesi akses PBF
     */
    public function pbfLogout(Request $request)
    {
        $request->session()->forget('pbf_access');
        return redirect()->route('products.pbf')
            ->with('pbf_info', 'Sesi akses PBF telah diakhiri.');
    }

    /**
     * Halaman Produk Apotek (frontend)
     */
    public function apotek(Request $request, ?string $slug = null)
    {
        $search          = $request->get('search', '');
        $kategori_produk = $request->get('kategori_produk', '');
        $perusahaan      = $request->get('perusahaan', '');
        $sort            = $request->get('sort', 'terbaru');

        if ($slug) {
            $perusahaan = str_replace(['-'], ' ', $slug);
            $perusahaan = preg_replace('/\s+/', ' ', trim($perusahaan));
            $perusahaan = ucwords($perusahaan);
        }

        if (!$perusahaan && Auth::check() && Auth::user()->outlet_name) {
            $perusahaan = Auth::user()->outlet_name;
        }

        $outletMeta = [
            'Alfa Sintang' => [
                'wa' => '6285705935715',
                'address' => 'Jl. MT. Haryono, Kapuas Kanan Hulu, Kec. Sintang, Kabupaten Sintang, Kalimantan Barat 78613',
            ],
            'Alfa Air Upas' => [
                'wa' => '6281549233935',
                'address' => 'MRMF+FM9, Air Upas, Kec. Air Upas, Kabupaten Ketapang, Kalimantan Barat 78863',
            ],
            'Alfa Kendawangan' => [
                'wa' => '6282254239530',
                'address' => 'F6F8+44V, Jl. Pangeran Adi, Kendawangan Kiri, Kec. Kendawangan, Kabupaten Ketapang, Kalimantan Barat 78862',
            ],
            'Alfa Balai Berkuak' => [
                'wa' => '6282114422090',
                'address' => 'Jl. Istana Jaya, Desa Balai Pinang (Dusun Balai Berkuak), Kecamatan Simpang Hulu, Kabupaten Ketapang, Kalimantan Barat, Kode Pos 78854.',
            ],
            'Alfa Nanga Tayap' => [
                'wa' => '6285849263704',
                'address' => 'FHG8+859, Nanga Tayap, Kec. Nanga Tayap, Kabupaten Ketapang, Kalimantan Barat 78873',
            ],
            'Alfa Tumbang Titi' => [
                'wa' => '6285821960187',
                'address' => 'Kawasan Tumbang Titi (area pusat kecamatan), Kecamatan Tumbang Titi, Kabupaten Ketapang, Kalimantan Barat, Kode Pos 78874',
            ],
            'Alfa Sosok' => [
                'wa' => '6285796032370',
                'address' => 'Sosok, Kec. Tayan Hulu, Kabupaten Sanggau, Kalimantan Barat 78562',
            ],
            'Alfa Bodok' => [
                'wa' => '6283191511444',
                'address' => '6C5M+89Q, Palem Jaya, Kec. Parindu, Kabupaten Sanggau, Kalimantan Barat 78561',
            ],
            'Alfa Kembayan' => [
                'wa' => '6285796032366',
                'address' => 'APOTEK ALFA, Tj. Merpati, Kec. Kembayan, Kabupaten Sanggau, Kalimantan Barat 78516',
            ],
            'Alfa Ambawang' => [
                'wa' => '6285119413105',
                'address' => 'Jl. Trans Kalimantan, Desa Jawa Tengah, Kec Sui Ambawang, Kabupaten Kubu Raya, Kalimantan Barat 78319',
            ],
            'Alfa Jungkat' => [
                'wa' => '6285754979060',
                'address' => 'Jl. Raya Jungkat, Sei Nipah, Kec. Jongkat, Kab. Mempawah, Kalimantan Barat 78351',
            ],
            'Alfa Mempawah' => [
                'wa' => '6285820712029',
                'address' => 'Jl. Sujarwo, Terusan, Kec. Mempawah Hilir, Kab. Mempawah, Kalimantan Barat 78912',
            ],
            'Apotek Medistra Farma' => [
                'wa' => '6281345559456',
                'phone' => '081345559456',
                'address' => 'Jl. R. Suprapto No.48A, Tengah, Kec. Delta Pawan, Kabupaten Ketapang, Kalimantan Barat 78821',
            ],
        ];

        $selectedOutlet = $perusahaan && isset($outletMeta[$perusahaan]) ? $perusahaan : 'Alfa Sintang';
        $selectedOutletMeta = $outletMeta[$selectedOutlet] ?? $outletMeta['Alfa Sintang'];
        $displayPerusahaan = str_starts_with($selectedOutlet, 'Alfa ') ? 'Apotek ' . $selectedOutlet : $selectedOutlet;

        if (! $perusahaan) {
            $perusahaan = $selectedOutlet;
        }

        $query = Medicine::where('kelompok', 'APOTEK');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_obat', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($kategori_produk) {
            $query->where('kategori_produk', $kategori_produk);
        }

        if ($perusahaan) {
            $query->where('kategori', $perusahaan);
        }

        match ($sort) {
            'harga_asc'  => $query->orderBy('harga', 'asc'),
            'harga_desc' => $query->orderBy('harga', 'desc'),
            'nama'       => $query->orderBy('nama_obat', 'asc'),
            default      => $query->latest(),
        };

        $medicines       = $query->paginate(12)->withQueryString();
        $total           = Medicine::where('kelompok', 'APOTEK')->count();
        $kategoriOptions = Companies::LIST;
        $perusahaanList  = Medicine::where('kelompok', 'APOTEK')
                            ->select('kategori')
                            ->whereNotNull('kategori')
                            ->where('kategori', '!=', '')
                            ->distinct()
                            ->orderBy('kategori')
                            ->pluck('kategori');

        return view('products_apotek', compact(
            'medicines', 'search', 'kategori_produk', 'perusahaan',
            'sort', 'total', 'kategoriOptions', 'perusahaanList',
            'selectedOutlet', 'selectedOutletMeta', 'outletMeta', 'displayPerusahaan'
        ));
    }

}

