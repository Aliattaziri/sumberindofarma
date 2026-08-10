<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\ProductCategory;
use App\Constants\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Halaman Produk Kami (frontend)
     */
    public function index(Request $request)
    {
        $search          = $request->get('search', '');
        $kategori_produk = $request->get('kategori_produk', '');
        $sort            = $request->get('sort', 'terbaru');

        $query = Medicine::nonPbf();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_obat', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($kategori_produk) {
            $query->where('kategori_produk', $kategori_produk);
        }

        match ($sort) {
            'harga_asc'  => $query->orderBy('harga', 'asc'),
            'harga_desc' => $query->orderBy('harga', 'desc'),
            'nama'       => $query->orderBy('nama_obat', 'asc'),
            default      => $query->latest(),
        };

        $medicines       = $query->paginate(12)->withQueryString();
        $total           = Medicine::nonPbf()->count();
        // Ambil dari DB kategori + tambahkan yang ada di produk tapi belum terdaftar
        $kategoriOptions = ProductCategory::getList();
        $extraKats = Medicine::nonPbf()
            ->whereNotNull('kategori_produk')
            ->whereNotIn('kategori_produk', $kategoriOptions)
            ->distinct()
            ->pluck('kategori_produk')
            ->toArray();
        $kategoriOptions = array_merge($kategoriOptions, $extraKats);
        $perusahaanList  = collect(); // tidak dipakai lagi

        return view('products', compact(
            'medicines', 'search', 'kategori_produk',
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
    public function show(Request $request, $id)
    {
        $medicine = Medicine::findOrFail($id);
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        $isPbf = (strtoupper(trim((string) ($medicine->kelompok ?? ''))) === 'PBF') || (strtoupper(trim((string) ($medicine->kategori ?? ''))) === 'PBF');

        if ($isPbf && !($request->session()->get('pbf_access', false) || ($user?->isSuperAdmin() ?? false))) {
            return redirect()->route('products.pbf')
                ->with('error', 'Silakan buka katalog PBF untuk melihat produk ini.');
        }

        // Tentukan URL kembali: dari referer atau default sesuai tipe produk
        $referer = $request->headers->get('referer', '');
        $appUrl  = config('app.url');
        if ($referer && str_starts_with($referer, $appUrl) && !str_contains($referer, '/medicines/') && !str_contains($referer, '/products/')) {
            $backUrl = $referer;
        } else {
            $backUrl = $isPbf ? route('products.pbf') : route('products.apotek');
        }

        if ($isPbf) {
            $relatedMedicines = Medicine::where('kategori', $medicine->kategori)
                                        ->where(function ($q) {
                                            $q->where('kelompok', 'PBF')
                                              ->orWhereRaw("UPPER(kategori) = 'PBF'");
                                        })
                                        ->where('id', '!=', $medicine->id)
                                        ->limit(4)
                                        ->get();
        } else {
            $relatedMedicines = Medicine::where('kategori', $medicine->kategori)
                                        ->where('id', '!=', $medicine->id)
                                        ->nonPbf()
                                        ->limit(4)
                                        ->get();
        }

        return view('medicines.detail', compact('medicine', 'relatedMedicines', 'backUrl'));
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

        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (! $hasPbfAccess && ! ($user?->isSuperAdmin() ?? false)) {
            return redirect()->route('products.pbf.gate')
                ->with('error', 'Silakan masukkan kode akses PBF terlebih dahulu untuk membuka katalog.');
        }

        $search          = $request->get('search', '');
        $kategori_produk = $request->get('kategori_produk', '');
        $perusahaan      = $request->get('perusahaan', '');
        $sort            = $request->get('sort', 'terbaru');

                $query = Medicine::where(function ($q) {
                        $q->where(function ($sub) {
                                $sub->where('kelompok', 'PBF')
                                    ->orWhereRaw('UPPER(kelompok) = ?', ['PBF'])
                                    ->orWhereRaw('LOWER(kelompok) LIKE ?', ['%pbf%'])
                                    ->orWhereRaw('UPPER(kategori) = ?', ['PBF'])
                                    ->orWhereRaw('LOWER(kategori) LIKE ?', ['%pbf%']);
                            })
                            ->orWhere(function ($sub) {
                                $sub->whereNotNull('kategori')
                                    ->whereRaw('LOWER(kategori) LIKE ?', ['%pbf%']);
                            });
                });

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
                $total           = Medicine::where(function ($q) {
                                                                $q->where(function ($sub) {
                                                                        $sub->where('kelompok', 'PBF')
                                                                            ->orWhereRaw('UPPER(kelompok) = ?', ['PBF'])
                                                                            ->orWhereRaw('LOWER(kelompok) LIKE ?', ['%pbf%'])
                                                                            ->orWhereRaw('UPPER(kategori) = ?', ['PBF'])
                                                                            ->orWhereRaw('LOWER(kategori) LIKE ?', ['%pbf%']);
                                                                    })
                                                                    ->orWhere(function ($sub) {
                                                                        $sub->whereNotNull('kategori')
                                                                            ->whereRaw('LOWER(kategori) LIKE ?', ['%pbf%']);
                                                                    });
                                                        })->count();
        $kategoriOptions = ProductCategory::getList();
                $perusahaanList  = Medicine::where(function ($q) {
                                                                $q->where(function ($sub) {
                                                                        $sub->where('kelompok', 'PBF')
                                                                            ->orWhereRaw('UPPER(kelompok) = ?', ['PBF'])
                                                                            ->orWhereRaw('LOWER(kelompok) LIKE ?', ['%pbf%'])
                                                                            ->orWhereRaw('UPPER(kategori) = ?', ['PBF'])
                                                                            ->orWhereRaw('LOWER(kategori) LIKE ?', ['%pbf%']);
                                                                    })
                                                                    ->orWhere(function ($sub) {
                                                                        $sub->whereNotNull('kategori')
                                                                            ->whereRaw('LOWER(kategori) LIKE ?', ['%pbf%']);
                                                                    });
                                                        })
                            ->select('kategori')
                            ->whereNotNull('kategori')
                            ->where('kategori', '!=', '')
                            ->distinct()
                            ->orderBy('kategori')
                            ->pluck('kategori');

        // Jika ada view khusus untuk perusahaan PBF, gunakan itu
        if ($perusahaan) {
            $viewName = 'products_pbf_' . Str::slug($perusahaan);
            if (view()->exists($viewName)) {
                return view($viewName, compact(
                    'medicines', 'search', 'kategori_produk', 'perusahaan',
                    'sort', 'total', 'kategoriOptions', 'perusahaanList'
                ));
            }
        }

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
            return redirect()->route('products.pbf.gate')
                ->withErrors(['kode' => '⚠️ Kode akses tidak boleh kosong. Silakan masukkan kode Anda.'])
                ->withInput();
        }

        // Kode akses PBF aktif dengan format SUMBERINDO111 sampai SUMBERINDO999.
        if (preg_match('/^SUMBERINDO(?:1[1-9][0-9]|[2-9][0-9]{2})$/', $kode)) {
            $request->session()->put('pbf_access', true);
            return redirect()->route('products.pbf')
                ->with('pbf_success', '✅ Akses berhasil! Selamat datang di Katalog PBF.');
        }

        return redirect()->route('products.pbf.gate')
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
     * Outlet ditentukan otomatis dari akun yang sedang login.
     */
    public function apotek(Request $request)
    {
        $search          = $request->get('search', '');
        $kategori_produk = $request->get('kategori_produk', '');
        $sort            = $request->get('sort', 'terbaru');

        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        // Outlet: prioritaskan query param (untuk link langsung seperti dari home),
        // lalu dari akun login, lalu default Alfa Sintang
        $outletParam = $request->get('outlet', '');
        // Query param dari URL selalu mengoverride outlet dari akun login
        $outletName  = $outletParam ?: ($user?->outlet_name ?: null);

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

        $outletNames        = array_keys($outletMeta);
        $selectedOutlet     = ($outletName && isset($outletMeta[$outletName])) ? $outletName : 'Alfa Sintang';
        $selectedOutletMeta = $outletMeta[$selectedOutlet];
        $displayPerusahaan  = str_starts_with($selectedOutlet, 'Alfa ') ? 'Apotek ' . $selectedOutlet : $selectedOutlet;

        // Query: produk milik outlet ini ATAU produk APOTEK global (tidak outlet-spesifik)
        $query = Medicine::query()->where(function ($q) use ($selectedOutlet, $outletNames) {
            $q->where('kategori', $selectedOutlet)
              ->orWhereRaw('LOWER(kategori) = ?', [strtolower($selectedOutlet)])
              ->orWhere(function ($global) use ($outletNames) {
                  $global->where('kelompok', 'APOTEK')
                         ->where(function ($notOutlet) use ($outletNames) {
                             $notOutlet->whereNull('kategori')->orWhere('kategori', '');
                             foreach ($outletNames as $outlet) {
                                 $notOutlet->where('kategori', '!=', $outlet);
                             }
                         });
              });
        })->nonPbf();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_obat', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($kategori_produk) {
            $query->where('kategori_produk', $kategori_produk);
        }

        match ($sort) {
            'harga_asc'  => $query->orderBy('harga', 'asc'),
            'harga_desc' => $query->orderBy('harga', 'desc'),
            'nama'       => $query->orderBy('nama_obat', 'asc'),
            default      => $query->latest(),
        };

        $medicines    = $query->paginate(12)->withQueryString();
        $total        = (clone $query->getQuery())->count();
        $total        = Medicine::query()->where(function ($q) use ($selectedOutlet, $outletNames) {
            $q->where('kategori', $selectedOutlet)
              ->orWhereRaw('LOWER(kategori) = ?', [strtolower($selectedOutlet)])
              ->orWhere(function ($global) use ($outletNames) {
                  $global->where('kelompok', 'APOTEK')
                         ->where(function ($notOutlet) use ($outletNames) {
                             $notOutlet->whereNull('kategori')->orWhere('kategori', '');
                             foreach ($outletNames as $outlet) {
                                 $notOutlet->where('kategori', '!=', $outlet);
                             }
                         });
              });
        })->nonPbf()->count();

        $kategoriOptions = ProductCategory::getList();
        $perusahaanList  = collect(); // tidak dipakai lagi

        // Jika ada view khusus untuk outlet ini, gunakan view tersebut
        $apotekView = 'products_apotek_' . Str::slug($selectedOutlet);
        if (view()->exists($apotekView)) {
            return view($apotekView, compact(
                'medicines', 'search', 'kategori_produk',
                'sort', 'total', 'kategoriOptions', 'perusahaanList',
                'selectedOutlet', 'selectedOutletMeta', 'outletMeta', 'displayPerusahaan'
            ));
        }

        return view('products_apotek', compact(
            'medicines', 'search', 'kategori_produk',
            'sort', 'total', 'kategoriOptions', 'perusahaanList',
            'selectedOutlet', 'selectedOutletMeta', 'outletMeta', 'displayPerusahaan'
        ));
    }

    /**
     * Halaman pemilihan outlet Apotek Alfa Group
     */
    public function apotekSelect()
    {
        $outlets = [
            ['slug' => 'alfa-sintang',       'name' => 'Alfa Sintang',       'address' => 'Jl. MT. Haryono, Kec. Sintang, Kab. Sintang'],
            ['slug' => 'alfa-air-upas',      'name' => 'Alfa Air Upas',      'address' => 'Kec. Air Upas, Kab. Ketapang'],
            ['slug' => 'alfa-kendawangan',   'name' => 'Alfa Kendawangan',   'address' => 'Jl. Pangeran Adi, Kendawangan, Kab. Ketapang'],
            ['slug' => 'alfa-balai-berkuak', 'name' => 'Alfa Balai Berkuak', 'address' => 'Desa Balai Pinang, Kec. Simpang Hulu, Kab. Ketapang'],
            ['slug' => 'alfa-nanga-tayap',   'name' => 'Alfa Nanga Tayap',   'address' => 'Kec. Nanga Tayap, Kab. Ketapang'],
            ['slug' => 'alfa-tumbang-titi',  'name' => 'Alfa Tumbang Titi',  'address' => 'Kec. Tumbang Titi, Kab. Ketapang'],
            ['slug' => 'alfa-sosok',         'name' => 'Alfa Sosok',         'address' => 'Sosok, Kec. Tayan Hulu, Kab. Sanggau'],
            ['slug' => 'alfa-bodok',         'name' => 'Alfa Bodok',         'address' => 'Palem Jaya, Kec. Parindu, Kab. Sanggau'],
            ['slug' => 'alfa-kembayan',      'name' => 'Alfa Kembayan',      'address' => 'Kec. Kembayan, Kab. Sanggau'],
            ['slug' => 'alfa-ambawang',      'name' => 'Alfa Ambawang',      'address' => 'Jl. Trans Kalimantan, Kec. Sui Ambawang, Kab. Kubu Raya'],
            ['slug' => 'alfa-jungkat',       'name' => 'Alfa Jungkat',       'address' => 'Jl. Raya Jungkat, Kec. Jongkat, Kab. Mempawah'],
            ['slug' => 'alfa-mempawah',      'name' => 'Alfa Mempawah',      'address' => 'Jl. Sujarwo, Kec. Mempawah Hilir, Kab. Mempawah'],
        ];

        return view('apotek_select', compact('outlets'));
    }

}

