@extends('layouts.frontend')

@section('title', 'Apotek Medistra - Produk')

@section('styles')
<style>
    .apotek-hero {
        background: linear-gradient(135deg, #7F1D1D 0%, #991B1B 50%, #B91C1C 100%);
        padding: calc(3rem + var(--navbar-height, 65px)) 0 3rem;
        margin-top: calc(-1 * var(--navbar-height, 65px));
        color: #fff;
        border-radius: 0 0 28px 28px;
    }

    .apotek-hero h1 {
        font-size: clamp(1.9rem, 3.3vw, 2.7rem);
        font-weight: 800;
        margin-bottom: .75rem;
    }

    .apotek-hero p {
        color: rgba(255,255,255,0.9);
        max-width: 760px;
        line-height: 1.8;
        margin-bottom: 0;
    }

    .apotek-badge {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        background: rgba(255,255,255,0.16);
        color: #fff;
        padding: .55rem .95rem;
        border-radius: 999px;
        font-weight: 700;
        font-size: .85rem;
        margin-bottom: 1rem;
    }

    .apotek-main {
        padding: 2rem 0 4rem;
        background: #fffaf9;
    }

    .apotek-panel {
        background: #fff;
        border: 1px solid #f2d8d8;
        border-radius: 20px;
        padding: 1.2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        margin-bottom: 1.25rem;
    }

    .filter-row {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr auto;
        gap: .75rem;
        align-items: end;
    }

    .filter-group label {
        display: block;
        font-size: .78rem;
        font-weight: 700;
        color: #374151;
        margin-bottom: .35rem;
    }

    .filter-group input,
    .filter-group select {
        width: 100%;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: .7rem .8rem;
        font-size: .9rem;
        background: #fff;
    }

    .btn-filter,
    .btn-reset {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .4rem;
        padding: .75rem 1rem;
        border-radius: 10px;
        font-weight: 700;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .btn-filter {
        background: #ef4444;
        color: #fff;
    }

    .btn-reset {
        background: #fef2f2;
        color: #991B1B;
    }

    .result-info {
        color: #6b7280;
        font-size: .9rem;
        margin-bottom: .9rem;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1rem;
    }

    .product-card {
        background: #fff;
        border: 1px solid #f2d8d8;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0,0,0,0.04);
        display: flex;
        flex-direction: column;
    }

    .product-card img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        background: #fef2f2;
    }

    .product-body {
        padding: 1rem;
        display: flex;
        flex-direction: column;
        gap: .5rem;
    }

    .product-tag {
        display: inline-block;
        width: fit-content;
        padding: .25rem .6rem;
        border-radius: 999px;
        background: #fef2f2;
        color: #991B1B;
        font-size: .72rem;
        font-weight: 700;
    }

    .product-name {
        font-size: .95rem;
        font-weight: 700;
        color: #1f2937;
        line-height: 1.35;
    }

    .product-price {
        font-size: 1rem;
        font-weight: 800;
        color: #B91C1C;
    }

    .stock-badge {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        width: fit-content;
        padding: .25rem .6rem;
        border-radius: 999px;
        font-size: .75rem;
        font-weight: 700;
    }

    .stock-ok { background: #fef2f2; color: #065f46; }
    .stock-low { background: #fff7ed; color: #b45309; }
    .stock-out { background: #fef2f2; color: #991B1B; }

    .outlet-info {
        background: #fff7ed;
        border: 1px solid #fde3c0;
        border-radius: 16px;
        padding: 1rem 1.2rem;
        margin-top: 1rem;
        color: #92400e;
        max-width: 720px;
    }

    .outlet-info p {
        margin: 0.35rem 0;
        font-size: 0.94rem;
        line-height: 1.5;
    }

    .outlet-info strong {
        color: #b45309;
    }

    .product-btn {
        margin-top: auto;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .4rem;
        padding: .7rem .9rem;
        background: #ef4444;
        color: #fff;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 700;
        font-size: .88rem;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
        background: #fff;
        border: 1px solid #f2d8d8;
        border-radius: 16px;
        color: #6b7280;
    }

    @media (max-width: 768px) {
        .filter-row { grid-template-columns: 1fr; }
        .product-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 480px) {
        .product-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<section class="apotek-hero">
    <div class="container">
        <div class="apotek-badge"><i class="fa-solid fa-store"></i> {{ $displayPerusahaan ?: 'Apotek Medistra' }}</div>
        <h1>Katalog Produk {{ $displayPerusahaan ?: 'Apotek Medistra' }}</h1>
        <p>Temukan berbagai produk obat, suplemen, dan kebutuhan kesehatan yang tersedia untuk kebutuhan apotek dan pelanggan Anda.</p>
    </div>
</section>

<section class="apotek-main">
    <div class="container">
        <div class="apotek-panel">
            <form method="GET" action="{{ route('products.apotek') }}" class="filter-row">
                <div class="filter-group">
                    <label><i class="fa-solid fa-magnifying-glass"></i> Cari produk</label>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Nama produk atau deskripsi">
                </div>
                <div class="filter-group">
                    <label><i class="fa-solid fa-tag"></i> Kategori</label>
                    <select name="kategori_produk">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoriOptions as $k)
                            <option value="{{ $k }}" @selected(($kategori_produk ?? '') === $k)>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label><i class="fa-solid fa-building"></i> Perusahaan</label>
                    <select name="perusahaan">
                        <option value="">Semua Perusahaan</option>
                        @foreach($perusahaanList as $p)
                            <option value="{{ $p }}" @selected($perusahaan === $p)>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label><i class="fa-solid fa-arrow-up-wide-short"></i> Urutkan</label>
                    <select name="sort">
                        <option value="terbaru" @selected($sort === 'terbaru')>Terbaru</option>
                        <option value="harga_asc" @selected($sort === 'harga_asc')>Harga Terendah</option>
                        <option value="harga_desc" @selected($sort === 'harga_desc')>Harga Tertinggi</option>
                        <option value="nama" @selected($sort === 'nama')>Nama A-Z</option>
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

        @if($medicines->count() > 0)
            <div class="product-grid">
                @foreach($medicines as $medicine)
                    <div class="product-card">
                        @if($medicine->gambar)
                            <img src="{{ url('storage/' . $medicine->gambar) }}" alt="{{ $medicine->nama_obat }}">
                        @else
                            <img src="{{ asset('page1.jpeg') }}" alt="{{ $medicine->nama_obat }}">
                        @endif
                        <div class="product-body">
                            <span class="product-tag">{{ $medicine->kategori_produk ?: $medicine->kategori }}</span>
                            @if($medicine->kategori)
                                <div class="product-origin" style="font-size:0.78rem;color:#475569;margin-bottom:0.45rem;">Toko: {{ $medicine->kategori }}</div>
                            @endif
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
                                <button type="button" class="btn-cart" onclick="addToCart({{ $medicine->id }}, '{{ addslashes($medicine->nama_obat) }}', {{ $medicine->harga }}, '{{ $medicine->gambar ? url('storage/'.$medicine->gambar) : '' }}', '{{ addslashes($medicine->brand ?: $medicine->kategori) }}', this)">
                                    <i class="fa-solid fa-cart-plus"></i> Tambah ke Keranjang
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fa-solid fa-box-open" style="font-size:2.2rem; margin-bottom:.8rem;"></i>
                <h3 style="margin:0 0 .4rem; color:#1f2937;">Belum ada produk yang cocok</h3>
                <p>Coba ubah kata kunci atau filter pencarian.</p>
            </div>
        @endif
    </div>
</section>
@endsection

@section('scripts')
<script>
    window.cartSettings = Object.assign({
        storageKey: 'sumberindofarmatama_cart_{{ \Illuminate\Support\Str::slug($selectedOutlet ?? 'default') }}',
        receiptStoreName: '{{ addslashes($selectedOutlet ?? 'Sumberindo Farma Tama') }}',
        receiptStoreAddress: '{{ addslashes($selectedOutletMeta['address'] ?? 'Kalimantan Barat') }}',
        receiptStorePhone: '{{ $selectedOutletMeta['phone'] ?? '' }}',
        wa: '{{ $selectedOutletMeta['wa'] ?? '6285248965590' }}'
    }, window.cartSettings || {});
</script>
@include('partials.cart')
@endsection
