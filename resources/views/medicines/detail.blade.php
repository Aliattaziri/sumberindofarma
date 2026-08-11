@extends('layouts.frontend')

@section('title', $medicine->nama_obat . ' - Sumberindo Farma Tama')

@section('styles')
<style>
    /* ===== DETAIL PAGE HEADER ===== */
    .detail-page-header {
        background: linear-gradient(135deg, #7F1D1D 0%, #991B1B 50%, #B91C1C 100%);
        padding: 3rem 0;
        position: relative;
        overflow: hidden;
    }
    .detail-page-header::before {
        content: '';
        position: absolute;
        top: -80px; right: -80px;
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(220,38,38,0.18) 0%, transparent 70%);
        border-radius: 50%;
    }
    .detail-page-header h1 {
        font-size: clamp(1.4rem, 3vw, 2rem);
        font-weight: 800; color: white;
        margin-bottom: 0.4rem; position: relative;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .detail-page-header p { color: rgba(255,255,255,0.8); font-size: 0.95rem; position: relative; }
    .breadcrumb-custom { display: flex; gap: 0.5rem; align-items: center; margin-bottom: 0.75rem; position: relative; flex-wrap: wrap; }
    .breadcrumb-custom a { color: rgba(255,255,255,0.7); text-decoration: none; font-size: 0.875rem; }
    .breadcrumb-custom a:hover { color: white; }
    .breadcrumb-custom span { color: rgba(255,255,255,0.5); font-size: 0.875rem; }
    .breadcrumb-custom .current { color: #a5d65a; font-size: 0.875rem; font-weight: 600; }

    /* ===== DETAIL WRAPPER ===== */
    .detail-wrapper {
        max-width: 1000px;
        margin: 2.5rem auto;
        padding: 0 1rem;
    }

    .detail-container {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 24px rgba(99,102,241,0.08), 0 1px 4px rgba(0,0,0,0.05);
        border: 1px solid rgba(99,102,241,0.13);
        margin-bottom: 2rem;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 0;
    }

    .detail-image-col {
        padding: 2rem;
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
    }

    .detail-image {
        width: 100%;
        aspect-ratio: 1;
        max-width: 340px;
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 5rem;
        overflow: hidden;
        position: static;
        margin-bottom: 0.85rem;
        border: 1px solid #e5e7eb;
    }

    .detail-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .detail-info {
        padding: 2rem;
        border-left: 1px solid #f3f4f6;
    }

    .detail-info h1 {
        font-size: clamp(1.3rem, 2.5vw, 1.75rem);
        margin-bottom: 0.75rem;
        color: #1f2937;
        font-weight: 800;
        line-height: 1.3;
    }

    .detail-category {
        display: inline-block;
        background: #fef2f2;
        color: #991B1B;
        padding: 0.3rem 0.85rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        margin-bottom: 1.25rem;
    }

    .price-section {
        margin: 1.25rem 0;
        padding: 1.25rem 1.5rem;
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        border-radius: 12px;
        border-left: 4px solid #B91C1C;
    }

        /* Deskripsi di bawah foto (detail) */
        .detail-desc {
            margin-top: 1rem;
            max-width: 340px;
            width: 100%;
            background: #ffffff;
            border: 1px solid #e6eefc;
            padding: 0.9rem;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(14,165,233,0.06);
            color: #374151;
        }
        .detail-desc h3 {
            font-size: 0.95rem;
            font-weight: 700;
            margin: 0 0 0.45rem;
            color: #0f172a;
            display:flex; align-items:center; gap:0.5rem;
        }
        .detail-desc .icon { color: #B91C1C; font-size:1.05rem; }
        .detail-desc p {
            line-height: 1.6;
            font-size: 0.95rem;
            color: #4b5563;
            margin: 0;
            white-space: pre-wrap;
        }
        @media (max-width: 768px) {
            .detail-desc { max-width: 320px; padding: 0.8rem; }
        }

    .price-label {
        font-size: 0.78rem;
        color: #991B1B;
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 0.05em;
        margin-bottom: 0.25rem;
    }

    .price {
        font-size: clamp(1.5rem, 3vw, 2rem);
        font-weight: 800;
        color: #991B1B;
        line-height: 1.2;
    }

    .stock-info {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1.25rem;
    }

    .stock-item {
        flex: 1;
        padding: 0.85rem;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        text-align: center;
    }

    .stock-item-label {
        font-size: 0.75rem;
        color: #6b7280;
        margin-bottom: 0.35rem;
        font-weight: 600;
    }

    .stock-item-value {
        font-size: 1.25rem;
        font-weight: 800;
        color: #1f2937;
    }

    .description-section {
        margin: 1.25rem 0;
    }

    .description-section h3 {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 0.6rem;
        color: #1f2937;
    }

    .description-section p {
        line-height: 1.7;
        color: #4b5563;
        font-size: 0.9rem;
    }

    /* Related Products */
    .related-section {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 24px rgba(99,102,241,0.08), 0 1px 4px rgba(0,0,0,0.05);
        border: 1px solid rgba(99,102,241,0.13);
    }

    .related-section h2 {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .related-section h2 i { color: #B91C1C; }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 1rem;
    }

    .related-card {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        transition: all 0.3s;
    }

    .related-card:hover {
        box-shadow: 0 8px 25px rgba(220,38,38,0.12);
        transform: translateY(-4px);
        border-color: #fecaca;
        color: inherit;
    }

    .related-image {
        width: 100%;
        height: 120px;
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        overflow: hidden;
    }

    .related-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }

    .related-card:hover .related-image img { transform: scale(1.05); }

    .related-body { padding: 0.85rem; }

    .related-name {
        font-size: 0.82rem;
        font-weight: 700;
        margin-bottom: 0.35rem;
        color: #1f2937;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.4;
    }

    .related-price {
        font-size: 0.9rem;
        font-weight: 800;
        color: #B91C1C;
    }

    @media (max-width: 768px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }

        .detail-image-col {
            padding: 1.25rem;
        }

        .detail-image {
            position: static;
            max-width: 220px;
            margin: 0 auto;
        }

        .detail-info {
            padding: 1.25rem;
            border-left: none;
            border-top: 1px solid #f3f4f6;
        }

        .stock-info { flex-direction: row; }

        .related-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }

        .related-section { padding: 1.25rem; }
    }

    @media (max-width: 480px) {
        .detail-wrapper { margin: 1rem auto; padding: 0 0.5rem; }
        .detail-image-col { padding: 1rem; }
        .detail-image { max-width: 180px; }
        .detail-info { padding: 1rem; }
        .price-section { padding: 1rem; }
        .price { font-size: clamp(1.3rem, 5vw, 1.75rem); }
        .stock-item { padding: 0.65rem 0.5rem; }
        .related-section { padding: 1rem; }
        .related-grid { grid-template-columns: repeat(2, 1fr); gap: 0.6rem; }
        .related-image { height: 100px; }
        .related-body { padding: 0.65rem; }
    }
</style>
@endsection
@section('content')

<div class="detail-page-header">
    <div class="container">
        <div class="breadcrumb-custom">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Home</a>
            <span>/</span>
            <a href="{{ $backUrl }}">Produk</a>
            <span>/</span>
            <span class="current">{{ Str::limit($medicine->nama_obat, 30) }}</span>
        </div>
        <h1>{{ $medicine->nama_obat }}</h1>
    </div>
</div>

<div class="detail-wrapper">
    <div class="detail-container">
        <div class="detail-grid">
            <!-- Image Column -->
            <div class="detail-image-col">
                <div class="detail-image">
                    @if($medicine->gambar)
                        <img src="{{ url('storage/' . $medicine->gambar) }}" alt="{{ $medicine->nama_obat }}">
                    @else
                        <i class="fa-solid fa-pills" style="color:#fecaca;font-size:4rem;"></i>
                    @endif
                </div>

                @if($medicine->deskripsi)
                <div class="detail-desc">
                    <h3><i class="fa-solid fa-circle-info icon"></i>Deskripsi Produk</h3>
                    <p>{!! nl2br(e($medicine->deskripsi)) !!}</p>
                </div>
                @endif
            </div>

            <!-- Info Column -->
            <div class="detail-info">
                <h1>{{ $medicine->nama_obat }}</h1>

                <div class="price-section">
                    <div class="price-label">Pabrik</div>
                    <div class="price" style="font-size:1rem;color:#374151;font-weight:700;">{{ $medicine->pabrik_label }}</div>
                </div>

                @if(!empty($medicine->sediaan))
                    <div style="margin-bottom:0.85rem;"><strong>Sediaan:</strong> <span style="color:#374151;">{{ $medicine->sediaan_label }}</span></div>
                @endif

                @if(!empty($medicine->komposisi))
                    <div style="margin-bottom:0.85rem;"><strong>Komposisi:</strong> <span style="color:#374151;">{!! nl2br(e($medicine->komposisi)) !!}</span></div>
                @endif
                @if(!empty($medicine->indikasi))
                    <div style="margin-bottom:0.85rem;"><strong>Indikasi:</strong> <span style="color:#374151;">{!! nl2br(e($medicine->indikasi)) !!}</span></div>
                @endif

                <a href="{{ $backUrl }}" style="display:flex;align-items:center;justify-content:center;gap:0.5rem;padding:0.65rem;border:1.5px solid #e5e7eb;border-radius:10px;color:#6b7280;text-decoration:none;font-weight:600;font-size:0.875rem;transition:all 0.2s;">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Katalog
                </a>
            </div>
        </div>
    </div>

    @if($relatedMedicines->count() > 0)
    <div class="related-section">
        <h2><i class="fa-solid fa-pills"></i> Produk Serupa</h2>
        <div class="related-grid">
            @foreach($relatedMedicines as $related)
                <a href="{{ route('medicines.show', $related->id) }}" class="related-card">
                    <div class="related-image">
                        @if($related->gambar)
                            <img src="{{ url('storage/' . $related->gambar) }}" alt="{{ $related->nama_obat }}">
                        @else
                            <i class="fa-solid fa-pills" style="color:#fecaca;font-size:1.75rem;"></i>
                        @endif
                    </div>
                    <div class="related-body">
                        <div class="related-name">{{ $related->nama_obat }}</div>
                        <div style="font-size:0.72rem;color:#6b7280;font-weight:600;line-height:1.4;">{{ $related->pabrik_label }}</div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @endif
</div>

@endsection

@section('scripts')
<script>
    const backLink = document.querySelector('.detail-info a[href]');
    if (backLink) {
        backLink.addEventListener('mouseover', function() {
            this.style.borderColor = '#B91C1C';
            this.style.color = '#B91C1C';
        });
        backLink.addEventListener('mouseout', function() {
            this.style.borderColor = '#e5e7eb';
            this.style.color = '#6b7280';
        });
    }
</script>
@endsection





