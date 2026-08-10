@php
    $storeName = $storeName ?? 'Toko';
    $storeDescription = $storeDescription ?? 'Katalog produk khusus toko ini.';
    $badgeText = $badgeText ?? 'Outlet';
    $accentColor = $accentColor ?? '#991b1b';
    $accentSoft = $accentSoft ?? '#fef2f2';
    $routeName = $routeName ?? 'products.apotek';
    $routeSlug = $routeSlug ?? Str::slug($storeName);
    $storeAddress = $storeAddress ?? 'Kalimantan Barat';
    $storePhone = $storePhone ?? '';
    $storeWa = $storeWa ?? '6285248965590';
@endphp

@extends('layouts.frontend')

@section('title', $storeName . ' - Produk')

@section('styles')
<style>
    .store-shell {
        padding: 0 0 3rem;
        background: linear-gradient(135deg, #f8fafc 0%, #fdf2f8 100%);
        min-height: 100vh;
    }
    .page-offset {
        padding-top: 0 !important;
    }
    .store-hero {
        background: linear-gradient(135deg, {{ $accentColor }} 0%, {{ $accentColor }}cc 100%);
        color: white;
        border-radius: 24px;
        padding: 2rem;
        box-shadow: 0 20px 50px rgba(0,0,0,0.12);
        margin-bottom: 1.25rem;
    }
    .store-badge {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .45rem .8rem;
        border-radius: 999px;
        background: rgba(255,255,255,.16);
        font-size: .78rem;
        font-weight: 700;
        margin-bottom: .8rem;
    }
    .store-hero h1 { font-size: clamp(1.6rem, 2.4vw, 2.3rem); font-weight: 800; margin-bottom: .45rem; }
    .store-hero p { margin: 0; max-width: 760px; color: rgba(255,255,255,.92); line-height: 1.7; }
    .store-meta { margin-top: 1rem; display: flex; flex-wrap: wrap; gap: .7rem; }
    .store-meta .chip { background: rgba(255,255,255,.16); padding: .45rem .7rem; border-radius: 999px; font-size: .8rem; }
    .filter-card, .product-card, .empty-state { border: 1px solid #e5e7eb; background: white; border-radius: 16px; box-shadow: 0 10px 24px rgba(15,23,42,.05); }
    .filter-card { padding: 1rem; margin-bottom: 1rem; }
    .filter-row { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: .75rem; align-items: end; }
    .filter-group label { display: block; font-size: .76rem; font-weight: 700; color: #374151; margin-bottom: .38rem; }
    .filter-group input, .filter-group select { width: 100%; border: 1px solid #e5e7eb; border-radius: 10px; padding: .7rem .8rem; background: #fff; }
    .btn-filter, .btn-reset { border: none; border-radius: 10px; padding: .72rem 1rem; font-weight: 700; cursor: pointer; text-decoration: none; display: inline-flex; justify-content: center; align-items: center; gap: .35rem; }
    .btn-filter { background: {{ $accentColor }}; color: white; }
    .btn-reset { background: {{ $accentSoft }}; color: {{ $accentColor }}; }
    .result-info { color: #64748b; font-size: .9rem; margin-bottom: .85rem; }
    .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px,1fr)); gap: 1rem; }
    .product-card { overflow: hidden; display: flex; flex-direction: column; }
    .product-card img { width: 100%; height: 160px; object-fit: cover; background: #f8fafc; }
    .product-body { padding: 1rem; display: flex; flex-direction: column; gap: .5rem; }
    .product-tag { display: inline-flex; width: fit-content; padding: .25rem .6rem; border-radius: 999px; background: {{ $accentSoft }}; color: {{ $accentColor }}; font-size: .72rem; font-weight: 700; }
    .product-name { font-size: .95rem; font-weight: 700; color: #111827; line-height: 1.35; }
    .product-price { font-size: 1rem; font-weight: 800; color: {{ $accentColor }}; }
    .stock-badge { display: inline-flex; width: fit-content; padding: .25rem .6rem; border-radius: 999px; font-size: .75rem; font-weight: 700; }
    .stock-ok { background: #ecfdf5; color: #065f46; }
    .stock-low { background: #fffbeb; color: #b45309; }
    .stock-out { background: #fef2f2; color: #991b1b; }
    .product-btn, .btn-cart { display: inline-flex; justify-content: center; align-items: center; gap: .35rem; padding: .7rem .9rem; border-radius: 10px; text-decoration: none; font-weight: 700; font-size: .88rem; margin-top: auto; }
    .product-btn { background: {{ $accentColor }}; color: white; }
    .btn-cart { background: white; border: 1px solid {{ $accentColor }}; color: {{ $accentColor }}; }
    .empty-state { padding: 2rem; text-align: center; color: #6b7280; }
    @media (max-width: 768px) { .filter-row { grid-template-columns: 1fr; } .product-grid { grid-template-columns: repeat(2,1fr); } }
    @media (max-width: 480px) { .product-grid { grid-template-columns: 1fr; } .store-hero { padding: 1.4rem; } }
</style>
@endsection

@section('content')
<section class="store-shell">
    <div class="container">
        <div class="store-hero">
            <div class="store-badge"><i class="fa-solid fa-store"></i> {{ $badgeText }}</div>
            <h1>{{ $storeName }}</h1>
            <p>{{ $storeDescription }}</p>
            <div class="store-meta">
                <span class="chip"><i class="fa-solid fa-box-open"></i> {{ $total ?? 0 }} Produk</span>
                <span class="chip"><i class="fa-solid fa-location-dot"></i> {{ $storeAddress }}</span>
            </div>
        </div>

        <div class="filter-card">
            <form method="GET" action="{{ route($routeName, ['slug' => $routeSlug]) }}" class="filter-row">
                <div class="filter-group">
                    <label><i class="fa-solid fa-magnifying-glass"></i> Cari Produk</label>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Nama produk atau deskripsi">
                </div>
                <div class="filter-group">
                    <label><i class="fa-solid fa-tag"></i> Kategori</label>
                    <select name="kategori_produk">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoriOptions ?? [] as $k)
                            <option value="{{ $k }}" @selected(($kategori_produk ?? '') === $k)>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label><i class="fa-solid fa-building"></i> Perusahaan</label>
                    <select name="perusahaan">
                        <option value="">Semua Perusahaan</option>
                        @foreach($perusahaanList ?? [] as $p)
                            <option value="{{ $p }}" @selected(($perusahaan ?? '') === $p)>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label><i class="fa-solid fa-arrow-up-wide-short"></i> Urutkan</label>
                    <select name="sort">
                        <option value="terbaru" @selected(($sort ?? 'terbaru') === 'terbaru')>Terbaru</option>
                        <option value="harga_asc" @selected(($sort ?? 'terbaru') === 'harga_asc')>Harga Terendah</option>
                        <option value="harga_desc" @selected(($sort ?? 'terbaru') === 'harga_desc')>Harga Tertinggi</option>
                        <option value="nama" @selected(($sort ?? 'terbaru') === 'nama')>Nama A-Z</option>
                    </select>
                </div>
                <div class="filter-group">
                    <button type="submit" class="btn-filter"><i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                </div>
            </form>
        </div>

        <div class="result-info">
            Menampilkan {{ $medicines->firstItem() ?? 0 }}-{{ $medicines->lastItem() ?? 0 }} dari {{ $medicines->total() }} produk.
        </div>

        @if(($medicines ?? collect())->count() > 0)
            <div class="product-grid">
                @foreach($medicines as $medicine)
                    <div class="product-card">
                        @if($medicine->gambar)
                            <img src="{{ url('storage/' . $medicine->gambar) }}" alt="{{ $medicine->nama_obat }}">
                        @else
                            <img src="{{ asset('page1.jpeg') }}" alt="{{ $medicine->nama_obat }}">
                        @endif
                        <div class="product-body">
                            <span class="product-tag">{{ $medicine->kategori_produk ?: 'OBAT' }}</span>
                            <h3 class="product-name">{{ $medicine->nama_obat }}</h3>
                            <div class="product-price">{{ $medicine->getFormattedPrice() }}</div>
                            @if($medicine->stok > 10)
                                <span class="stock-badge stock-ok"><i class="fa-solid fa-circle-check"></i> Stok tersedia</span>
                            @elseif($medicine->stok > 0)
                                <span class="stock-badge stock-low"><i class="fa-solid fa-triangle-exclamation"></i> Stok terbatas</span>
                            @else
                                <span class="stock-badge stock-out"><i class="fa-solid fa-circle-xmark"></i> Stok habis</span>
                            @endif
                            <a href="{{ route('medicines.show', $medicine->id) }}" class="product-btn"><i class="fa-solid fa-eye"></i> Lihat Detail</a>
                            @if($medicine->stok > 0)
                                <button type="button" class="btn-cart" onclick="addToCart({{ $medicine->id }}, '{{ addslashes($medicine->nama_obat) }}', {{ $medicine->harga }}, '{{ $medicine->gambar ? url('storage/'.$medicine->gambar) : '' }}', '{{ addslashes($medicine->brand ?: $medicine->kategori) }}', this)"><i class="fa-solid fa-cart-plus"></i> Tambah</button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fa-solid fa-box-open" style="font-size:2rem; margin-bottom:.7rem;"></i>
                <h3 style="margin:0 0 .3rem; color:#111827;">Belum ada produk yang cocok</h3>
                <p>Coba ubah kata kunci atau filter pencarian.</p>
            </div>
        @endif
    </div>
</section>
@endsection

@section('scripts')
<script>
@php
    $cartScope = 'store_' . preg_replace('/[^a-z0-9]+/', '_', strtolower($routeSlug ?? ($storeName ?? 'default')));
@endphp
window.cartSettings = Object.assign({}, window.cartSettings || {}, {
    storageKey: @json(auth()->check()
        ? 'sumberindofarmatama_cart_user_' . auth()->user()->id . '_' . $cartScope
        : 'sumberindofarmatama_cart_' . $cartScope),
    receiptStoreName: '{{ addslashes($storeName) }}',
    receiptStoreAddress: '{{ addslashes($storeAddress) }}',
    receiptStorePhone: '{{ $storePhone }}',
    wa: '{{ $storeWa }}'
});
</script>
@include('partials.cart_store')
@endsection
