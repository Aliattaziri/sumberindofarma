<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Banner;
use App\Models\News;
use App\Models\Comment;
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

        $latestBanners = Schema::hasTable('banners') ? Banner::orderBy('urutan')->orderBy('id')->limit(5)->get() : collect();
        $totalBanners  = Schema::hasTable('banners') ? Banner::count() : 0;
        $activeBanners = Schema::hasTable('banners') ? Banner::where('aktif', true)->count() : 0;

        $latestNews = News::latest()->limit(5)->get();
        $totalNews = News::count();
        $publishedNews = News::where('is_published', true)->count();
        $totalComments = Comment::count();

        return view('admin.dashboard', compact(
            'latestBanners', 'totalBanners', 'activeBanners',
            'latestNews', 'totalNews', 'publishedNews', 'totalComments'
        ));
    }

    public function stats()
    {
        $totalNews = News::count();
        $publishedNews = News::where('is_published', true)->count();
        $totalBanners = Schema::hasTable('banners') ? Banner::count() : 0;
        $activeBanners = Schema::hasTable('banners') ? Banner::where('aktif', true)->count() : 0;
        $totalComments = Comment::count();

        return response()->json([
            'totalNews' => $totalNews,
            'publishedNews' => $publishedNews,
            'totalBanners' => $totalBanners,
            'activeBanners' => $activeBanners,
            'totalComments' => $totalComments,
            'generatedAt' => now()->format('H:i:s'),
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

