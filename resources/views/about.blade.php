@extends('layouts.frontend')

@section('title', 'Tentang Kami - PT. Sumberindo Farma Tama')

@section('styles')
<style>
    main.page-offset { padding-top: 0 !important; }

    /* HERO */
    .about-hero {
        position: relative; background: linear-gradient(135deg, #7F1D1D 0%, #991B1B 50%, #B91C1C 100%);
        border-radius: 28px; padding: 2.5rem 2.5rem 3rem; color: #fff;
        overflow: hidden; box-shadow: 0 24px 60px rgba(127,29,29,0.22); margin-bottom: 2rem;
    }
    .about-hero::before {
        content: ''; position: absolute; inset: 0; pointer-events: none;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
    .about-hero-badge {
        display: inline-flex; align-items: center; gap: 0.4rem;
        background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25);
        border-radius: 999px; padding: 0.35rem 1rem;
        font-size: 0.78rem; font-weight: 700; letter-spacing: 0.06em;
        text-transform: uppercase; color: #fca5a5; margin-bottom: 1rem;
    }
    .about-hero h1 { font-size: clamp(1.8rem, 3.5vw, 2.8rem); font-weight: 900; margin-bottom: 0.75rem; line-height: 1.15; color: #fff; }
    .about-hero p.lead { color: rgba(255,255,255,0.88); max-width: 680px; font-size: 1.02rem; line-height: 1.8; margin-bottom: 1.5rem; }
    .hero-stats { display: flex; flex-wrap: wrap; gap: 1.25rem; margin-top: 0.5rem; }
    .hero-stat { background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); border-radius: 16px; padding: 0.9rem 1.4rem; text-align: center; min-width: 110px; }
    .hero-stat-num { font-size: 1.7rem; font-weight: 900; line-height: 1; display: block; color: #fff; }
    .hero-stat-label { font-size: 0.72rem; font-weight: 600; color: rgba(255,255,255,0.75); text-transform: uppercase; letter-spacing: 0.05em; margin-top: 0.25rem; display: block; }
    .hero-btn-row { display: flex; flex-wrap: wrap; gap: 0.75rem; margin-top: 1.75rem; }
    .hero-btn-row a { text-decoration: none; display: inline-flex; align-items: center; gap: 0.45rem; padding: 0.75rem 1.25rem; border-radius: 999px; font-weight: 700; font-size: 0.9rem; transition: all 0.2s; }
    .btn-hero-primary { background: #fff; color: #991B1B; }
    .btn-hero-primary:hover { background: #fef2f2; color: #7F1D1D; }
    .btn-hero-outline { background: rgba(255,255,255,0.12); color: #fff; border: 1px solid rgba(255,255,255,0.3); }
    .btn-hero-outline:hover { background: rgba(255,255,255,0.2); color: #fff; }

    /* SECTION TITLES */
    .about-section-label { font-size: 0.72rem; font-weight: 800; letter-spacing: 0.1em; text-transform: uppercase; color: #B91C1C; margin-bottom: 0.4rem; display: block; }
    .about-section-title { font-size: clamp(1.35rem, 2.5vw, 1.8rem); font-weight: 800; color: #1f2937; margin-bottom: 0.5rem; line-height: 1.25; }
    .about-section-sub { font-size: 0.95rem; color: #6b7280; line-height: 1.75; max-width: 640px; }

    /* PROFIL CARDS */
    .abt-info-grid { display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 1.25rem; margin-bottom: 1.5rem; }
    .abt-card { background: #fff; border: 1px solid #f3d7d7; border-radius: 20px; padding: 1.75rem; box-shadow: 0 8px 28px rgba(0,0,0,0.05); }
    .abt-card h2 { font-size: 1.1rem; font-weight: 800; color: #1f2937; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem; }
    .abt-card h2 i { color: #B91C1C; font-size: 1rem; }
    .abt-card p, .abt-card li { color: #4b5563; line-height: 1.8; font-size: 0.93rem; }
    .abt-list { padding-left: 1.1rem; margin: 0; }
    .abt-list li { margin-bottom: 0.4rem; }

    /* VISI MISI */
    .abt-visimisi-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.5rem; }
    .abt-vm-card { border-radius: 20px; padding: 1.75rem; position: relative; overflow: hidden; }
    .abt-vm-card.visi { background: linear-gradient(135deg, #7F1D1D, #B91C1C); color: #fff; }
    .abt-vm-card.misi { background: #fff; border: 1px solid #f3d7d7; box-shadow: 0 8px 28px rgba(0,0,0,0.05); }
    .abt-vm-card h3 { font-size: 1.1rem; font-weight: 800; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem; }
    .abt-vm-card.visi h3 { color: #fca5a5; }
    .abt-vm-card.misi h3 { color: #1f2937; }
    .abt-vm-card.misi h3 i { color: #B91C1C; }
    .abt-vm-card.visi p { color: rgba(255,255,255,0.9); font-size: 0.95rem; line-height: 1.8; }
    .abt-misi-list { list-style: none; padding: 0; margin: 0; }
    .abt-misi-list li { display: flex; align-items: flex-start; gap: 0.6rem; font-size: 0.9rem; color: #374151; margin-bottom: 0.6rem; line-height: 1.65; }
    .abt-misi-list li i { color: #B91C1C; margin-top: 0.15rem; flex-shrink: 0; }

    /* NILAI */
    .abt-nilai-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem; }
    .abt-nilai-card { background: #fff; border: 1px solid #f3d7d7; border-radius: 18px; padding: 1.4rem 1rem; text-align: center; box-shadow: 0 6px 20px rgba(0,0,0,0.04); transition: transform 0.2s, box-shadow 0.2s; }
    .abt-nilai-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(185,28,28,0.1); }
    .abt-nilai-icon { width: 52px; height: 52px; border-radius: 14px; background: linear-gradient(135deg, #fef2f2, #fecaca); display: flex; align-items: center; justify-content: center; margin: 0 auto 0.85rem; font-size: 1.3rem; color: #B91C1C; }
    .abt-nilai-card h4 { font-size: 0.88rem; font-weight: 800; color: #1f2937; margin-bottom: 0.35rem; }
    .abt-nilai-card p { font-size: 0.78rem; color: #6b7280; line-height: 1.6; margin: 0; }

    /* STRUKTUR */
    .abt-struktur-wrap { background: #fff; border: 1px solid #f3d7d7; border-radius: 24px; padding: 2rem; box-shadow: 0 8px 28px rgba(0,0,0,0.05); margin-bottom: 1.5rem; }
    .abt-struktur-img { border-radius: 16px; overflow: hidden; border: 2px solid #fecaca; margin-top: 1.25rem; box-shadow: 0 8px 28px rgba(185,28,28,0.1); }
    .abt-struktur-img img { width: 100%; display: block; object-fit: contain; max-height: 520px; background: #fff; }
    .abt-struktur-note { display: flex; align-items: center; gap: 0.5rem; margin-top: 0.85rem; font-size: 0.82rem; color: #6b7280; }
    .abt-struktur-note i { color: #B91C1C; }

    /* GALERI */
    .abt-gallery-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 1.5rem; }
    .abt-gallery-item { border-radius: 18px; overflow: hidden; border: 1px solid #f3d7d7; background: #fff; box-shadow: 0 8px 24px rgba(0,0,0,0.05); transition: transform 0.2s, box-shadow 0.2s; }
    .abt-gallery-item:hover { transform: translateY(-4px); box-shadow: 0 16px 40px rgba(0,0,0,0.1); }
    .abt-gallery-item img { width: 100%; height: 200px; object-fit: cover; display: block; }
    .abt-gallery-caption { padding: 0.75rem 1rem; font-size: 0.82rem; font-weight: 600; color: #991B1B; background: #fff; }

    /* CABANG */
    .abt-branch-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem; }
    .abt-branch-card { background: #fff; border: 1px solid #f3d7d7; border-radius: 20px; padding: 1.5rem; box-shadow: 0 6px 20px rgba(0,0,0,0.04); }
    .abt-branch-head { display: flex; align-items: center; gap: 0.65rem; margin-bottom: 0.85rem; }
    .abt-branch-icon { width: 40px; height: 40px; border-radius: 11px; background: linear-gradient(135deg, #fef2f2, #fecaca); display: flex; align-items: center; justify-content: center; font-size: 1rem; color: #B91C1C; flex-shrink: 0; }
    .abt-branch-card h3 { font-size: 0.95rem; font-weight: 800; color: #1f2937; margin: 0; }
    .abt-branch-card .abt-branch-sub { font-size: 0.82rem; color: #9ca3af; margin: 0.15rem 0 0; }
    .abt-branch-card p { font-size: 0.85rem; color: #6b7280; margin: 0; line-height: 1.6; }

    /* CTA */
    .abt-cta-strip { background: linear-gradient(135deg, #7F1D1D, #B91C1C); border-radius: 24px; padding: 2rem 2.5rem; display: flex; align-items: center; justify-content: space-between; gap: 1.5rem; flex-wrap: wrap; margin-top: 2rem; box-shadow: 0 16px 40px rgba(127,29,29,0.2); }
    .abt-cta-strip h3 { font-size: 1.25rem; font-weight: 800; color: #fff; margin: 0 0 0.35rem; }
    .abt-cta-strip p { color: rgba(255,255,255,0.8); font-size: 0.9rem; margin: 0; }
    .abt-cta-btns { display: flex; flex-wrap: wrap; gap: 0.75rem; }
    .abt-cta-btns a { text-decoration: none; display: inline-flex; align-items: center; gap: 0.45rem; padding: 0.75rem 1.25rem; border-radius: 999px; font-weight: 700; font-size: 0.88rem; transition: all 0.2s; }
    .abt-cta-wa { background: #fff; color: #991B1B; }
    .abt-cta-wa:hover { background: #fef2f2; color: #7F1D1D; }
    .abt-cta-produk { background: rgba(255,255,255,0.15); color: #fff; border: 1px solid rgba(255,255,255,0.3); }
    .abt-cta-produk:hover { background: rgba(255,255,255,0.22); color: #fff; }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .about-hero { padding: 1.5rem 1.25rem 2rem; border-radius: 20px; }
        .hero-stats { gap: 0.75rem; }
        .hero-stat { min-width: 90px; padding: 0.75rem 1rem; }
        .hero-stat-num { font-size: 1.4rem; }
        .abt-info-grid { grid-template-columns: 1fr; }
        .abt-visimisi-grid { grid-template-columns: 1fr; }
        .abt-nilai-grid { grid-template-columns: repeat(2, 1fr); }
        .abt-gallery-grid { grid-template-columns: 1fr 1fr; }
        .abt-branch-grid { grid-template-columns: 1fr; }
        .abt-cta-strip { flex-direction: column; align-items: flex-start; padding: 1.5rem; border-radius: 20px; }
        .abt-struktur-img img { max-height: 260px; }
    }
    @media (max-width: 480px) {
        .abt-gallery-grid { grid-template-columns: 1fr; }
        .abt-nilai-grid { grid-template-columns: repeat(2, 1fr); }
        .hero-stats { gap: 0.5rem; }
        .hero-stat { min-width: 80px; }
    }
</style>
@endsection

@section('content')
<section style="padding: 0 0 5rem; background: linear-gradient(180deg, #fffaf9 0%, #fff 100%);">
<div class="container">

    {{-- HERO --}}
    <div class="about-hero">
        <span class="about-hero-badge"><i class="fa-solid fa-building-shield"></i> Pedagang Besar Farmasi (PBF)</span>
        <h1>PT. Sumberindo Farma Tama</h1>
        <p class="lead">Distributor farmasi terpercaya di Kalimantan Barat, berdiri sejak 2016. Menyediakan obat, alat kesehatan, dan produk farmasi berkualitas untuk apotek, klinik, dan fasilitas kesehatan.</p>
        <div class="hero-stats">
            <div class="hero-stat">
                <span class="hero-stat-num">2016</span>
                <span class="hero-stat-label">Berdiri</span>
            </div>
            <div class="hero-stat">
                <span class="hero-stat-num">8+</span>
                <span class="hero-stat-label">Mitra Apotek</span>
            </div>
            <div class="hero-stat">
                <span class="hero-stat-num">PBF</span>
                <span class="hero-stat-label">Tersertifikasi</span>
            </div>
            <div class="hero-stat">
                <span class="hero-stat-num">CDOB</span>
                <span class="hero-stat-label">Bersertifikat</span>
            </div>
        </div>
        <div class="hero-btn-row">
            <a href="{{ route('products.apotek') }}" class="btn-hero-primary"><i class="fa-solid fa-cart-shopping"></i> Lihat Produk</a>
            <a href="{{ route('contact') }}" class="btn-hero-outline"><i class="fa-solid fa-phone"></i> Hubungi Kami</a>
        </div>
    </div>

    {{-- PROFIL --}}
    <div style="margin-bottom:1.5rem;">
        <span class="about-section-label"><i class="fa-solid fa-circle-info"></i> Profil Perusahaan</span>
        <h2 class="about-section-title">Siapa Kami</h2>
        <p class="about-section-sub">Mengenal lebih dalam tentang PT. Sumberindo Farma Tama — perusahaan distribusi farmasi yang berkomitmen pada kualitas dan kepercayaan.</p>
    </div>
    <div class="abt-info-grid">
        <div class="abt-card">
            <h2><i class="fa-solid fa-briefcase-medical"></i> Tentang Perusahaan</h2>
            <p style="margin-bottom:0.85rem;">
                PT. Sumberindo Farma Tama adalah <strong>Pedagang Besar Farmasi (PBF)</strong> yang beroperasi di wilayah Kalimantan Barat. Didirikan pada tahun <strong>2016</strong>, perusahaan ini bergerak dalam bidang distribusi obat-obatan, alat kesehatan, suplemen, serta produk farmasi lainnya kepada fasilitas pelayanan kesehatan.
            </p>
            <p style="margin-bottom:0.85rem;">
                Berkantor pusat di <strong>Komp. Pergudangan Ocean 88 C2-3, Jl. Adisucipto, Arang Limbung, Kec. Sungai Raya, Kab. Kubu Raya, Kalimantan Barat</strong>, perusahaan ini mengelola gudang distribusi modern yang memenuhi standar <strong>CDOB (Cara Distribusi Obat yang Baik)</strong> dari BPOM.
            </p>
            <ul class="abt-list">
                <li>Distribusi obat ethical, OTC, dan alat kesehatan</li>
                <li>Mitra apotek retail dan apotek group di Kalimantan Barat</li>
                <li>Sistem penyimpanan berstandar farmasi nasional</li>
                <li>Armada distribusi untuk pengiriman ke seluruh wilayah</li>
            </ul>
        </div>
        <div class="abt-card">
            <h2><i class="fa-solid fa-certificate"></i> Legalitas &amp; Sertifikasi</h2>
            <ul class="abt-list">
                <li><strong>Izin PBF</strong> — terdaftar resmi sebagai Pedagang Besar Farmasi</li>
                <li><strong>Sertifikat CDOB</strong> — Cara Distribusi Obat yang Baik dari BPOM</li>
                <li><strong>NPWP &amp; NIB</strong> — legalitas usaha lengkap</li>
                <li><strong>Apoteker Penanggung Jawab</strong> tersertifikasi</li>
                <li><strong>Asisten Apoteker</strong> berlisensi</li>
            </ul>
            <div style="margin-top:1rem;padding:0.85rem 1rem;background:#fef2f2;border-radius:12px;border-left:3px solid #B91C1C;">
                <p style="margin:0;font-size:0.82rem;color:#991B1B;font-weight:600;">
                    <i class="fa-solid fa-shield-halved"></i>&nbsp;
                    Seluruh produk yang kami distribusikan memiliki izin edar resmi BPOM dan dijamin keasliannya dari prinsipal.
                </p>
            </div>
        </div>
    </div>

    {{-- VISI MISI --}}
    <div style="margin-bottom:1.5rem;margin-top:2rem;">
        <span class="about-section-label"><i class="fa-solid fa-bullseye"></i> Arah Perusahaan</span>
        <h2 class="about-section-title">Visi &amp; Misi</h2>
    </div>
    <div class="abt-visimisi-grid">
        <div class="abt-vm-card visi">
            <h3><i class="fa-solid fa-eye"></i> Visi</h3>
            <p>Menjadi distributor farmasi pilihan utama di Kalimantan Barat yang terpercaya, profesional, dan berkontribusi nyata dalam meningkatkan akses masyarakat terhadap produk kesehatan berkualitas.</p>
        </div>
        <div class="abt-vm-card misi">
            <h3><i class="fa-solid fa-list-check"></i> Misi</h3>
            <ul class="abt-misi-list">
                <li><i class="fa-solid fa-check-circle"></i> Mendistribusikan produk farmasi original dan tersertifikasi BPOM</li>
                <li><i class="fa-solid fa-check-circle"></i> Menerapkan standar CDOB dalam seluruh proses distribusi</li>
                <li><i class="fa-solid fa-check-circle"></i> Memberikan layanan cepat, responsif, dan profesional kepada mitra</li>
                <li><i class="fa-solid fa-check-circle"></i> Membangun kemitraan jangka panjang yang saling menguntungkan</li>
                <li><i class="fa-solid fa-check-circle"></i> Terus berinovasi dalam sistem distribusi dan pelayanan digital</li>
            </ul>
        </div>
    </div>

    {{-- NILAI PERUSAHAAN --}}
    <div style="margin-bottom:1.5rem;margin-top:2rem;">
        <span class="about-section-label"><i class="fa-solid fa-star"></i> Nilai Kami</span>
        <h2 class="about-section-title">Nilai-Nilai Perusahaan</h2>
    </div>
    <div class="abt-nilai-grid">
        <div class="abt-nilai-card">
            <div class="abt-nilai-icon"><i class="fa-solid fa-shield-halved"></i></div>
            <h4>Integritas</h4>
            <p>Jujur dan bertanggung jawab dalam setiap proses distribusi</p>
        </div>
        <div class="abt-nilai-card">
            <div class="abt-nilai-icon"><i class="fa-solid fa-star-of-life"></i></div>
            <h4>Kualitas</h4>
            <p>Produk asli bersumber langsung dari prinsipal resmi</p>
        </div>
        <div class="abt-nilai-card">
            <div class="abt-nilai-icon"><i class="fa-solid fa-handshake"></i></div>
            <h4>Kepercayaan</h4>
            <p>Mitra kesehatan yang dapat diandalkan sejak 2016</p>
        </div>
        <div class="abt-nilai-card">
            <div class="abt-nilai-icon"><i class="fa-solid fa-bolt"></i></div>
            <h4>Kecepatan</h4>
            <p>Pengiriman tepat waktu ke seluruh wilayah distribusi</p>
        </div>
    </div>

    {{-- STRUKTUR ORGANISASI --}}
    <div class="abt-struktur-wrap">
        <span class="about-section-label"><i class="fa-solid fa-sitemap"></i> Sumber Daya Manusia</span>
        <h2 class="about-section-title">Struktur Organisasi</h2>
        <p class="about-section-sub" style="margin-bottom:0;">
            PT. Sumberindo Farma Tama dikelola oleh tim profesional berpengalaman di bidang farmasi dan distribusi, mulai dari Apoteker Penanggung Jawab, Asisten Apoteker, hingga tim operasional lapangan.
        </p>
        <div class="abt-struktur-img">
            <img src="{{ asset('STRUKTUR PT SFT.png') }}" alt="Struktur Organisasi PT. Sumberindo Farma Tama" loading="lazy">
        </div>
        <div class="abt-struktur-note">
            <i class="fa-solid fa-circle-info"></i>
            Struktur organisasi PT. Sumberindo Farma Tama mencerminkan tata kelola farmasi yang profesional sesuai ketentuan BPOM.
        </div>
    </div>

    {{-- GALERI FASILITAS --}}
    <div style="margin-bottom:1.5rem;margin-top:2rem;">
        <span class="about-section-label"><i class="fa-solid fa-image"></i> Dokumentasi</span>
        <h2 class="about-section-title">Fasilitas &amp; Operasional</h2>
    </div>
    <div class="abt-gallery-grid">
        <div class="abt-gallery-item">
            <img src="{{ asset('foto kantor utama SFT.jpg') }}" alt="Kantor Utama PT SFT" loading="lazy">
            <div class="abt-gallery-caption"><i class="fa-solid fa-building"></i> Kantor Utama</div>
        </div>
        <div class="abt-gallery-item">
            <img src="{{ asset('foto kantor utama SFT (2).jpg') }}" alt="Kantor Utama SFT Tampak Samping" loading="lazy">
            <div class="abt-gallery-caption"><i class="fa-solid fa-building"></i> Kantor Utama — Tampak Samping</div>
        </div>
        <div class="abt-gallery-item">
            <img src="{{ asset('foto gudang distribusi SFT.jpeg') }}" alt="Gudang Distribusi SFT" loading="lazy">
            <div class="abt-gallery-caption"><i class="fa-solid fa-warehouse"></i> Gudang Distribusi</div>
        </div>
        <div class="abt-gallery-item">
            <img src="{{ asset('foto gudang distribusi SFT (2).jpeg') }}" alt="Area Penyimpanan Gudang SFT" loading="lazy">
            <div class="abt-gallery-caption"><i class="fa-solid fa-warehouse"></i> Gudang — Area Penyimpanan</div>
        </div>
        <div class="abt-gallery-item">
            <img src="{{ asset('foto gudang distribusi SFT (3).jpeg') }}" alt="Area Loading Gudang SFT" loading="lazy">
            <div class="abt-gallery-caption"><i class="fa-solid fa-truck-loading"></i> Gudang — Area Loading</div>
        </div>
        <div class="abt-gallery-item">
            <img src="{{ asset('AKTIVITAS KARYAWAN SFT.jpg') }}" alt="Aktivitas Karyawan SFT" loading="lazy">
            <div class="abt-gallery-caption"><i class="fa-solid fa-users"></i> Aktivitas Karyawan</div>
        </div>
    </div>

    {{-- MITRA --}}
    <div style="margin-bottom:1.5rem;margin-top:2rem;">
        <span class="about-section-label"><i class="fa-solid fa-map-location-dot"></i> Jaringan</span>
        <h2 class="about-section-title">Mitra Apotek &amp; Distribusi</h2>
        <p class="about-section-sub">Kami melayani berbagai apotek dan fasilitas kesehatan di Kalimantan Barat dengan pengiriman langsung dari gudang distribusi kami.</p>
    </div>
    <div class="abt-branch-grid">
        <!-- Apotek Alfa Group & Apotek Medistra Farma cards removed — only PBF remains -->
        <div class="abt-branch-card">
            <div class="abt-branch-head">
                <div class="abt-branch-icon"><i class="fa-solid fa-truck"></i></div>
                <div>
                    <h3>Distribusi PBF Langsung</h3>
                    <p class="abt-branch-sub">Layanan B2B ke apotek &amp; klinik</p>
                </div>
            </div>
            <p>Menyediakan layanan distribusi PBF langsung untuk apotek, klinik, puskesmas, dan fasilitas kesehatan lainnya di Kalimantan Barat.</p>
        </div>
        <div class="abt-branch-card">
            <div class="abt-branch-head">
                <div class="abt-branch-icon"><i class="fa-solid fa-mobile-screen"></i></div>
                <div>
                    <h3>Platform Digital B2B</h3>
                    <p class="abt-branch-sub">Pemesanan via aplikasi</p>
                </div>
            </div>
            <p>Mitra farmasi dapat memesan produk melalui platform digital B2B TokoPro untuk kemudahan transaksi kapan saja dan di mana saja.</p>
        </div>
    </div>



</div>
</section>
@endsection
