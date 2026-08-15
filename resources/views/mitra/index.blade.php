@extends('layouts.frontend')

@section('title', 'Mitra Kami')

@section('styles')
<style>
    .mitra-hero { padding: calc(1rem + var(--navbar-height, 65px)) 0 2rem; }
    .mitra-list-wrap { background: #fff; border-radius: 14px; padding: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.04); }
    .mitra-grid { display:grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap:1.5rem; align-items:center; justify-items:center; }
    .mitra-card { background:transparent;border-radius:8px;padding:0.6rem;display:flex;align-items:center;justify-content:center;min-height:100px; transition:transform 0.18s ease, box-shadow 0.18s ease; }
    .mitra-card img { max-width:100%; max-height:68px; object-fit:contain; display:block; }
    .mitra-card:hover { transform: translateY(-6px); }
    @media (min-width:1200px) {
        .mitra-grid { gap:2rem; }
    }
</style>
@endsection

@section('content')
<div class="mitra-hero">
    <div class="container">
        <div style="background:linear-gradient(135deg,#991B1B,#B91C1C);color:white;padding:2rem;border-radius:18px;">
            <div style="display:flex;gap:1rem;align-items:center;">
                <img src="{{ asset('logo pt sumber indo farma tama.png') }}" alt="Sumberindo" style="height:84px;border-radius:12px;background:white;padding:0.5rem;" />
                <div>
                    <h1 style="margin:0;font-size:2rem;font-weight:800;">Mitra Kami</h1>
                    <p style="margin:0.4rem 0 0;color:rgba(255,255,255,0.9);">Daftar mitra, distributor, dan principal yang bekerja sama bersama Sumberindo Farma Tama.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container" style="padding:1.5rem 0 4rem;">
    @php
        use App\Models\Medicine;
        use Illuminate\Support\Str;

        // Files from public/principals
        $principalsDir = public_path('principals');
        $principalFiles = [];
        if (is_dir($principalsDir)) {
            foreach (scandir($principalsDir) as $it) {
                if (in_array($it, ['.', '..'])) continue;
                $principalFiles[] = ['type' => 'public', 'path' => 'principals/' . $it, 'label' => pathinfo($it, PATHINFO_FILENAME)];
            }
        }

        // Also include Medicine entries that are used as principal logos
        $dbLogos = Medicine::whereNotNull('gambar')
                    ->where('harga', 0)
                    ->where('stok', 0)
                    ->where('terjual', 0)
                    ->get();
        foreach ($dbLogos as $m) {
            $principalFiles[] = [
                'type' => 'db',
                'path' => $m->gambar,
                'label' => $m->nama_obat ?? 'logo',
                'link' => $m->brand ?? null,
            ];
        }
    @endphp

    @if(count($principalFiles) > 0)
        <div class="mitra-list-wrap">
            <div class="mitra-grid">
            @foreach($principalFiles as $pf)
                <div class="mitra-card">
                    @if($pf['type'] === 'public')
                        <img src="{{ asset($pf['path']) }}" alt="{{ $pf['label'] }}">
                    @else
                        @php
                            // DB-stored image path may be like 'banners/xxx.png' or 'principals/xxx.png'
                            $parts = explode('/', $pf['path'], 2);
                            $folder = $parts[0] ?? null;
                            $filename = $parts[1] ?? $parts[0] ?? '';
                            $url = $folder ? url('/storage/' . $folder . '/' . $filename) : asset($pf['path']);
                            $link = isset($pf['link']) && $pf['link'] ? $pf['link'] : null;
                        @endphp
                        @if($link)
                            <a href="{{ $link }}" target="_blank" rel="noopener noreferrer">
                                <img src="{{ $url }}" alt="{{ $pf['label'] }}">
                            </a>
                        @else
                            <img src="{{ $url }}" alt="{{ $pf['label'] }}">
                        @endif
                    @endif
                </div>
            @endforeach
            </div>
        </div>
    @else
        <div class="empty-state" style="text-align:center;padding:3rem;border-radius:12px;border:1px solid #e6e6e6;background:#fff;">
            <i class="fa-solid fa-handshake" style="font-size:2.2rem;color:#d1d5db;"></i>
            <h3 style="margin-top:0.75rem;color:#1f2937;">Belum ada mitra terdaftar</h3>
            <p style="color:#6b7280;">Silakan unggah logo mitra melalui admin → Principal Logos atau Admin → Principle Logo.</p>
        </div>
    @endif
</div>
@endsection
