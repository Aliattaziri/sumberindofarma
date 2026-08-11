<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Banner;
use App\Models\ProductCategory;
use App\Constants\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    protected function buildGlobalDashboardData(): array
    {
        return [
            'totalProdukGlobal' => Medicine::count(),
            'totalTransaksiGlobal' => 0,
            'historyByOutlet' => collect(),
            'historyByChannel' => collect(),
            'recentGlobalOrders' => collect(),
        ];
    }

    public function index()
    {
        $user = Auth::user();

        if ($user && $user->isSuperAdmin()) {
            return view('admin.dashboard-global', $this->buildGlobalDashboardData());
        }

        $query = Medicine::query();

        if ($user && ! $user->isSuperAdmin() && $user->isOutletAdmin()) {
            $query->where('kategori', $user->outlet_name);
        }

        $totalProduk    = $query->count();
        $totalStok      = $query->sum('stok');
        $lowStok        = (clone $query)->where('stok', '<', 5)->count();
        $latestProduk   = (clone $query)->latest()->limit(10)->get();

        // Per kategori produk
        $categoryColumn = Schema::hasColumn('medicines', 'kategori_produk') ? 'kategori_produk' : 'kategori';
        $kategoriList = Schema::hasColumn('medicines', 'kategori_produk') ? ProductCategory::getList() : $query->whereNotNull('kategori')->distinct()->orderBy('kategori')->pluck('kategori');

        $perKategori = [];
        foreach ($kategoriList as $kat) {
            $kategoriQuery = Medicine::where($categoryColumn, $kat);
            if ($user && ! $user->isSuperAdmin() && $user->isOutletAdmin()) {
                $kategoriQuery->where('kategori', $user->outlet_name);
            }
            $perKategori[$kat] = $kategoriQuery->count();
        }

        $latestBanners = Schema::hasTable('banners') ? Banner::orderBy('urutan')->orderBy('id')->limit(5)->get() : collect();
        $totalBanners  = Schema::hasTable('banners') ? Banner::count() : 0;
        $activeBanners = Schema::hasTable('banners') ? Banner::where('aktif', true)->count() : 0;

        return view('admin.dashboard', compact(
            'totalProduk', 'totalStok', 'lowStok', 'latestProduk',
            'perKategori', 'latestBanners', 'totalBanners', 'activeBanners'
        ));
    }

    public function stats()
    {
        $user = Auth::user();
        $query = Medicine::query();

        if ($user && ! $user->isSuperAdmin() && $user->isOutletAdmin()) {
            $query->where('kategori', $user->outlet_name);
        }

        $selectColumns = ['id', 'nama_obat', 'kategori', 'harga', 'stok', 'created_at'];
        if (Schema::hasColumn('medicines', 'kategori_produk')) {
            $selectColumns[] = 'kategori_produk';
        }

        $latestProduk = (clone $query)->latest()->limit(10)
            ->get($selectColumns)
            ->map(fn($m) => [
                'id'              => $m->id,
                'nama_obat'       => $m->nama_obat,
                'kategori'        => $m->kategori,
                'kategori_produk' => $m->kategori_produk ?? $m->kategori,
                'harga'           => $m->harga,
                'stok'            => $m->stok,
                'created_at'      => $m->created_at->format('d M Y H:i'),
            ]);

        return response()->json([
            'total'         => (clone $query)->count(),
            'lowStok'       => (clone $query)->where('stok', '<', 5)->count(),
            'latestProduk'  => $latestProduk,
        ]);
    }

    public function globalStats()
    {
        $user = Auth::user();
        if (! $user || ! $user->isSuperAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $this->buildGlobalDashboardData();

        return response()->json([
            'totalProdukGlobal' => $data['totalProdukGlobal'],
            'totalTransaksiGlobal' => $data['totalTransaksiGlobal'],
            'historyByOutlet' => $data['historyByOutlet']->values()->all(),
            'historyByChannel' => $data['historyByChannel']->values()->all(),
            'recentGlobalOrders' => $data['recentGlobalOrders']->map(function ($order) {
                return [
                    'waktu' => optional($order->created_at)->format('d M Y H:i'),
                    'outlet' => $order->source_outlet ?: '-',
                    'pembeli' => $order->buyer_name ?: '-',
                    'kanal' => match ($order->buyer_type) {
                        'apotik' => 'Apotek',
                        'toko_obat' => 'Toko Obat',
                        'pbf' => 'PBF',
                        default => 'Umum',
                    },
                    'omzet' => 0,
                ];
            })->values()->all(),
            'generatedAt' => now()->format('H:i:s'),
        ]);
    }
}

