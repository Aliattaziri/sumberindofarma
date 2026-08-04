@extends('layouts.frontend')

@section('title', 'Tentang Kami - Sumberindo Farma Tama')

@section('styles')
<style>
    main.page-offset {
        padding-top: 0 !important;
    }

    .about-simple {
        padding: 0 0 5rem;
        background: linear-gradient(180deg, #fffaf9 0%, #fff 100%);
    }

    .about-hero {
        background: linear-gradient(135deg, #7F1D1D 0%, #991B1B 50%, #B91C1C 100%);
        border-radius: 28px;
        padding: 1.5rem 2.5rem 2.5rem;
        color: #fff;
        box-shadow: 0 20px 50px rgba(185, 28, 28, 0.18);
        margin-top: 0;
    }

    .about-hero h1 {
        font-size: clamp(2rem, 3.4vw, 2.8rem);
        font-weight: 800;
        margin-bottom: 1rem;
        line-height: 1.15;
    }

    .about-hero p {
        color: rgba(255,255,255,0.9);
        max-width: 720px;
        font-size: 1rem;
        line-height: 1.8;
        margin-bottom: 0;
    }

    .about-grid {
        display: grid;
        grid-template-columns: 1.1fr 0.9fr;
        gap: 1.25rem;
        margin-top: 1.5rem;
    }

    .about-card {
        background: #fff;
        border: 1px solid #f3d7d7;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    .about-card h2 {
        font-size: 1.2rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: .75rem;
    }

    .about-card p,
    .about-card li {
        color: #4b5563;
        line-height: 1.75;
        font-size: 0.95rem;
    }

    .about-list {
        padding-left: 1rem;
        margin: 0;
    }

    .about-list li {
        margin-bottom: .4rem;
    }

    .gallery-section {
        margin-top: 1.5rem;
    }

    .gallery-section h2,
    .branches-section h2 {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 1rem;
    }

    .branches-section {
        margin-top: 1.5rem;
    }

    .branch-list {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .branch-card {
        background: #fff;
        border: 1px solid #f3d7d7;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    }

    .branch-card h3 {
        margin: 0 0 0.65rem;
        font-size: 1.05rem;
        font-weight: 700;
        color: #1f2937;
    }

    .branch-card p {
        margin: 0.35rem 0;
        color: #4b5563;
        line-height: 1.65;
        font-size: 0.95rem;
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }

    .gallery-item {
        border-radius: 18px;
        overflow: hidden;
        border: 1px solid #f3d7d7;
        background: #fff;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05);
    }

    .gallery-item img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        display: block;
    }

    .gallery-caption {
        padding: .8rem 1rem;
        font-size: .9rem;
        font-weight: 600;
        color: #991B1B;
    }

    .btn-row {
        display: flex;
        flex-wrap: wrap;
        gap: .75rem;
        margin-top: 1.5rem;
    }

    .btn-row a {
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .8rem 1rem;
        border-radius: 999px;
        font-weight: 700;
        font-size: .92rem;
    }

    .btn-primary {
        background: #ef4444;
        color: #fff;
    }

    .btn-secondary {
        background: #fef2f2;
        color: #991B1B;
    }

    @media (max-width: 768px) {
        .about-simple { padding: 2.5rem 0 3rem; }
        .about-hero { padding: 1.5rem; }
        .about-grid { grid-template-columns: 1fr; }
        .gallery-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<section class="about-simple">
    <div class="container">
        <div class="about-hero">
            <h1>Tentang Sumberindo Farma Tama</h1>
            <p>Kami adalah distributor farmasi dan apotik online yang fokus membantu masyarakat serta mitra kesehatan mendapatkan produk terpercaya, cepat, dan mudah diakses.</p>
            <div class="btn-row">
                <a href="{{ route('products.apotek') }}" class="btn-primary"><i class="fa-solid fa-cart-shopping"></i> Lihat Produk</a>
                <a href="{{ route('contact') }}" class="btn-secondary"><i class="fa-solid fa-phone"></i> Hubungi Kami</a>
            </div>
        </div>

        <div class="about-grid">
            <div class="about-card">
                <h2>Siapa Kami</h2>
                <p>Sumberindo Farma Tama hadir untuk mendukung kebutuhan obat, suplemen, dan perlengkapan kesehatan dengan layanan yang praktis dan profesional.</p>
                <ul class="about-list">
                    <li>Produk asli dan tersertifikasi</li>
                    <li>Tim yang siap membantu pelanggan</li>
                    <li>Pengiriman ke berbagai wilayah Indonesia</li>
                </ul>
            </div>
            <div class="about-card">
                <h2>Kenapa Memilih Kami</h2>
                <ul class="about-list">
                    <li>Harga kompetitif langsung dari distributor</li>
                    <li>Layanan cepat dan komunikatif</li>
                    <li>Komitmen menjaga kualitas dan kepercayaan</li>
                </ul>
            </div>
        </div>

    </div>
</section>
@endsection
