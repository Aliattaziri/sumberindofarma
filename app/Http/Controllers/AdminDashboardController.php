<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Banner;
use App\Models\PurchaseHistory;
use App\Constants\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    protected function buildGlobalDashboardData(): array
    {
        $totalProdukGlobal = Medicine::count();

        $orders = Schema::hasTable('purchase_histories')
            ? PurchaseHistory::query()->latest()->get()
            : collect();

        $totalOmzetGlobal = (float) $orders->sum(fn ($order) => $order->effective_total);
        $totalTransaksiGlobal = $orders->count();

        $historyByOutlet = $orders
            ->groupBy(fn ($order) => $order->source_outlet ?: 'Tanpa Outlet')
            ->map(function ($group, $outlet) {
                $omzet = (float) $group->sum(fn ($o) => $o->effective_total);

                return [
                    'outlet' => $outlet,
                    'transaksi' => $group->count(),
                    'omzet' => $omzet,
                ];
            })
            ->sortByDesc('omzet')
            ->values();

        $historyByChannel = $orders
            ->groupBy(function ($order) {
                return match ($order->buyer_type) {
                    'apotik' => 'Apotek / Produk Apotek',
                    'toko_obat' => 'Toko Obat',
                    'pbf' => 'PBF',
                    default => 'Umum / Produk Publik',
                };
            })
            ->map(function ($group, $channel) {
                $omzet = (float) $group->sum(fn ($o) => $o->effective_total);

                return [
                    'channel' => $channel,
                    'transaksi' => $group->count(),
                    'omzet' => $omzet,
                ];
            })
            ->sortByDesc('omzet')
            ->values();

        $recentGlobalOrders = $orders->take(10)->values();

        return [
            'totalProdukGlobal' => $totalProdukGlobal,
            'totalOmzetGlobal' => $totalOmzetGlobal,
            'totalTransaksiGlobal' => $totalTransaksiGlobal,
            'historyByOutlet' => $historyByOutlet,
            'historyByChannel' => $historyByChannel,
            'recentGlobalOrders' => $recentGlobalOrders,
        ];
    }

    protected function applyOutletScopeToPurchaseHistory($query)
    {
        $user = Auth::user();

        if (! $user) {
            return $query->whereRaw('1 = 0');
        }

        if ($user->isSuperAdmin()) {
            return $query;
        }

        if ($user->isOutletAdmin()) {
            return $query->where('source_outlet', $user->outlet_name);
        }

        return $query->whereRaw('1 = 0');
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
        $kategoriList = Schema::hasColumn('medicines', 'kategori_produk') ? Companies::LIST : $query->whereNotNull('kategori')->distinct()->orderBy('kategori')->pluck('kategori');

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

        $historyQuery = Schema::hasTable('purchase_histories') ? PurchaseHistory::query() : null;
        $totalOmzet = 0;
        $recentOrders = collect();

        if ($historyQuery) {
            $historyQuery = $this->applyOutletScopeToPurchaseHistory($historyQuery);
            $totalOmzet = (float) $historyQuery->get()->sum(fn ($order) => $order->effective_total);
            $recentOrders = $historyQuery->latest()->limit(5)->get();
        }

        return view('admin.dashboard', compact(
            'totalProduk', 'totalStok', 'lowStok', 'latestProduk',
            'perKategori', 'latestBanners', 'totalBanners', 'activeBanners',
            'totalOmzet', 'recentOrders' 
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
            'totalOmzetGlobal' => (float) $data['totalOmzetGlobal'],
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
                    'omzet' => (float) $order->effective_total,
                ];
            })->values()->all(),
            'generatedAt' => now()->format('H:i:s'),
        ]);
    }

    public function purchaseHistory()
    {
        $query = Schema::hasTable('purchase_histories') ? PurchaseHistory::query() : null;

        if ($query) {
            $query = $this->applyOutletScopeToPurchaseHistory($query);
        }

        $orders = $query
            ? $query->latest()->paginate(20)
            : new \Illuminate\Pagination\LengthAwarePaginator([], 0, 20);

        $total_omzet = $query
            ? (float) $query->get()->sum(fn($order) => $order->effective_total)
            : 0;

        return view('admin.purchase-history', compact('orders', 'total_omzet'));
    }

    public function updateApprovalStatus(Request $request, PurchaseHistory $order)
    {
        if (!\Schema::hasTable('purchase_histories')) {
            return redirect()->route('admin.purchase-history.index')->with('error', 'Tabel purchase_histories tidak tersedia.');
        }

        $user = Auth::user();
        if (! $user || (! $user->isSuperAdmin() && $order->source_outlet !== $user->outlet_name)) {
            return redirect()->route('admin.purchase-history.index')->with('error', 'Anda tidak memiliki akses ke riwayat pembelian ini.');
        }

        $data = $request->validate([
            'approval_status' => ['required', 'string', 'in:pending,approved,rejected'],
        ]);

        if (!($order->original_total > 0) || !($order->discounted_total > 0)) {
            $items = is_string($order->items) ? json_decode($order->items, true) : ($order->items ?? []);
            $items = is_array($items) ? $items : [];
            $originalTotal = 0;
            $discountedTotal = 0;

            foreach ($items as $item) {
                $qty = (int) ($item['quantity'] ?? $item['qty'] ?? 0);
                $price = (int) ($item['harga'] ?? $item['price'] ?? 0);
                $discount = (int) ($item['potongan'] ?? 0);
                $subtotal = $qty * $price;
                $originalTotal += $subtotal;
                $discountedTotal += max(0, $subtotal - $discount);
            }

            $order->original_total = $order->original_total ?: $originalTotal;
            $order->discounted_total = $order->discounted_total ?: $discountedTotal;
        }

        $order->update($data);

        return redirect()->route('admin.purchase-history.index')->with('success', 'Status persetujuan berhasil diperbarui.');
    }

    /**
     * Delete a single purchase history entry
     */
    public function destroy(\App\Models\PurchaseHistory $order)
    {
        if (!\Schema::hasTable('purchase_histories')) {
            return redirect()->route('admin.purchase-history.index')->with('error', 'Tabel purchase_histories tidak tersedia.');
        }

        $user = Auth::user();
        if (! $user || (! $user->isSuperAdmin() && $order->source_outlet !== $user->outlet_name)) {
            return redirect()->route('admin.purchase-history.index')->with('error', 'Anda tidak dapat menghapus riwayat pembelian apotek lain.');
        }

        $order->delete();
        return redirect()->route('admin.purchase-history.index')->with('success', 'Riwayat pembelian berhasil dihapus.');
    }

    /**
     * Delete all purchase history entries
     */
    public function destroyAll()
    {
        if (!\Schema::hasTable('purchase_histories')) {
            return redirect()->route('admin.purchase-history.index')->with('error', 'Tabel purchase_histories tidak tersedia.');
        }

        $user = Auth::user();
        if (! $user || ! $user->isSuperAdmin()) {
            return redirect()->route('admin.purchase-history.index')->with('error', 'Hanya akun induk yang dapat menghapus semua riwayat pembelian.');
        }

        \App\Models\PurchaseHistory::query()->delete();
        return redirect()->route('admin.purchase-history.index')->with('success', 'Semua riwayat pembelian berhasil dihapus.');
    }

    /**
     * Export purchase history to XLSX
     */
    public function exportPurchaseHistory()
    {
        if (!\Schema::hasTable('purchase_histories')) {
            return redirect()->route('admin.purchase-history.index')->with('error', 'Tabel purchase_histories tidak tersedia.');
        }

        $query = $this->applyOutletScopeToPurchaseHistory(PurchaseHistory::query());
        $orders = $query->latest()->get();

        $headers = [
            'ID',
            'Tanggal',
            'Nama Pembeli',
            'Jenis',
            'Kontak',
            'Alamat',
            'Kecamatan',
            'Kota',
            'SIA',
            'SIPA',
            'Nama Produk',
            'Jumlah',
            'Harga Satuan (Rp)',
            'Subtotal (Rp)',
            'Status Persetujuan',
            'Total Pesanan (Rp)',
        ];

        $widths = [8, 18, 24, 10, 16, 30, 18, 18, 18, 18, 30, 8, 20, 20, 18, 20];

        $rows       = [];
        $grandTotal = 0;

        foreach ($orders as $order) {
            $itemsArray = is_string($order->items) ? json_decode($order->items, true) : ($order->items ?? []);
            $itemsArray = is_array($itemsArray) ? $itemsArray : [];

            if (count($itemsArray) > 0) {
                foreach ($itemsArray as $index => $item) {
                    $nama     = $item['nama_obat'] ?? $item['name'] ?? '';
                    $qty      = $item['quantity']  ?? $item['qty']  ?? 0;
                    $harga    = $item['harga']      ?? $item['price'] ?? 0;
                    $subtotal = $qty * $harga;

                    $rows[] = [
                        $index === 0 ? $order->id                                              : '',
                        $index === 0 ? $order->created_at->format('d/m/Y H:i')                : '',
                        $index === 0 ? ($order->buyer_name ?? '')                             : '',
                        $index === 0 ? (match ($order->buyer_type) {
                            'apotik' => 'Apotik',
                            'toko_obat' => 'Toko Obat',
                            'pbf' => 'PBF',
                            default => 'Umum',
                        }) : '',
                        $index === 0 ? ($order->phone ?? '')                                   : '',
                        $index === 0 ? ($order->address ?? '')                                 : '',
                        $index === 0 ? ($order->kecamatan ?? '')                               : '',
                        $index === 0 ? ($order->kota ?? '')                                    : '',
                        $index === 0 ? ($order->sia ?? '')                                     : '',
                        $index === 0 ? ($order->sipa ?? '')                                    : '',
                        $nama,
                        $qty,
                        $harga,
                        $subtotal,
                        $index === 0 ? $order->approval_label : '',
                        $index === 0 ? $order->effective_total : '',
                    ];
                }
            } else {
                $rows[] = [
                    $order->id,
                    $order->created_at->format('d/m/Y H:i'),
                    $order->buyer_name ?? '',
                    match ($order->buyer_type) {
                        'apotik' => 'Apotik',
                        'toko_obat' => 'Toko Obat',
                        'pbf' => 'PBF',
                        default => 'Umum',
                    },
                    $order->phone    ?? '',
                    $order->address  ?? '',
                    $order->kecamatan ?? '',
                    $order->kota     ?? '',
                    $order->sia      ?? '',
                    $order->sipa     ?? '',
                    '',
                    0,
                    0,
                    0,
                    $order->approval_label,
                    $order->effective_total,
                ];
            }

            $grandTotal += $order->effective_total;
        }

        // Baris kosong pemisah
        $blankRow = array_fill(0, count($headers), '');
        $rows[] = $blankRow;

        // Baris GRAND TOTAL — tandai dengan prefix khusus agar XlsxWriter tahu ini total row
        $totalRow = array_fill(0, count($headers), '');
        $totalRow[0] = '__TOTAL__';
        $totalRow[1] = 'Total ' . $orders->count() . ' Transaksi';
        $totalRow[count($headers) - 1] = $grandTotal;
        $rows[] = $totalRow;

        $filename = 'purchase_history_' . date('Y-m-d_His') . '.xlsx';

        return \App\Helpers\XlsxWriter::download($filename, $headers, $rows, $widths);
    }
}
