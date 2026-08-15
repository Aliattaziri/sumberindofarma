@extends('layouts.admin')

@section('title', 'Dashboard - Admin Sumberindo Farma Tama')
@section('page-title', '📊 Dashboard')

@section('content')
<style>
    .dashboard-shell {
        --dash-red: #b91c1c;
        --dash-ink: #0f172a;
        --dash-muted: #64748b;
        --dash-border: #e2e8f0;
        --dash-panel: #ffffff;
        margin-top: 1rem;
    }

    .dashboard-hero {
        position: relative;
        overflow: hidden;
        background: radial-gradient(circle at top right, rgba(255,255,255,0.22), transparent 35%),
                    linear-gradient(135deg, #7f1d1d 0%, #991b1b 36%, #b91c1c 100%);
        border-radius: 18px;
        padding: 1.35rem 1.4rem;
        color: #fff;
        box-shadow: 0 16px 34px rgba(153, 27, 27, 0.22);
        margin-bottom: 1rem;
    }

    .dashboard-hero h2 {
        margin: 0.8rem 0 0.4rem;
        font-size: clamp(1.5rem, 2vw, 2.1rem);
        line-height: 1.2;
        font-weight: 800;
    }

    .dashboard-hero p {
        margin: 0;
        color: rgba(255,255,255,0.9);
        max-width: 720px;
    }

    .dash-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.35rem 0.8rem;
        border-radius: 999px;
        background: rgba(255,255,255,0.18);
        border: 1px solid rgba(255,255,255,0.28);
        font-size: 0.74rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        font-weight: 700;
    }

    .dash-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.8rem;
        margin-top: 1rem;
    }

    .dash-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        background: rgba(255,255,255,0.12);
        padding: 0.45rem 0.8rem;
        border-radius: 10px;
        font-size: 0.82rem;
    }

    .dashboard-kpis {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .dash-kpi {
        background: var(--dash-panel);
        border: 1px solid var(--dash-border);
        border-top: 5px solid var(--dash-red);
        border-radius: 16px;
        padding: 1rem 1rem 0.9rem;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
    }

    .dash-kpi .label {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
        font-size: 0.76rem;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: var(--dash-muted);
        font-weight: 700;
    }

    .dash-kpi .value {
        margin-top: 0.7rem;
        font-weight: 800;
        font-size: clamp(1.4rem, 2vw, 2rem);
        color: var(--dash-ink);
        line-height: 1.2;
    }

    .dash-kpi .sub {
        margin-top: 0.25rem;
        font-size: 0.78rem;
        color: var(--dash-muted);
    }

    .dash-row {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .dash-panel {
        background: var(--dash-panel);
        border: 1px solid var(--dash-border);
        border-radius: 16px;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
        overflow: hidden;
    }

    .dash-panel-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        padding: 1rem 1rem 0.85rem;
        border-bottom: 1px solid var(--dash-border);
    }

    .dash-panel-title {
        margin: 0;
        font-size: 1rem;
        font-weight: 800;
        color: var(--dash-ink);
    }

    .dash-panel-link {
        color: var(--dash-red);
        font-size: 0.8rem;
        text-decoration: none;
        font-weight: 700;
    }

    .dash-panel-body {
        padding: 1rem;
    }

    .dash-statusbar {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 0.9rem;
        border-radius: 12px;
        background: linear-gradient(135deg, #fff5f5, #fef2f2);
        border: 1px solid #fecaca;
        margin-bottom: 1rem;
        color: var(--dash-ink);
        font-size: 0.82rem;
    }

    .status-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #ef4444;
        box-shadow: 0 0 0 5px rgba(239, 68, 68, 0.12);
        animation: pulse 1.8s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.3); opacity: 0.7; }
    }

    .dash-list {
        display: grid;
        gap: 0.7rem;
    }

    .dash-list-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        padding: 0.72rem 0.8rem;
        background: linear-gradient(180deg, #ffffff, #fff7f7);
        border: 1px solid #fee2e2;
        border-radius: 12px;
    }

    .dash-list-item strong {
        display: block;
        font-size: 0.84rem;
        color: var(--dash-ink);
    }

    .dash-list-item span {
        font-size: 0.74rem;
        color: var(--dash-muted);
    }

    .dash-pill-tag {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.28rem 0.6rem;
        border-radius: 999px;
        font-size: 0.7rem;
        font-weight: 700;
        background: #fee2e2;
        color: #991b1b;
    }

    .dash-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.83rem;
    }

    .dash-table th,
    .dash-table td {
        padding: 0.72rem 0.8rem;
        border-bottom: 1px solid #f1f5f9;
        text-align: left;
        vertical-align: top;
    }

    .dash-table th {
        font-size: 0.72rem;
        color: var(--dash-muted);
        text-transform: uppercase;
        letter-spacing: 0.08em;
        background: #fff7f7;
    }

    .dash-table tr:last-child td {
        border-bottom: none;
    }

    .dash-table .name {
        font-weight: 800;
        color: var(--dash-ink);
    }

    .dash-table .muted {
        color: var(--dash-muted);
        font-size: 0.76rem;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .quick-action {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.55rem;
        min-height: 46px;
        padding: 0.7rem 0.9rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.83rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .quick-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 18px rgba(153, 27, 27, 0.12);
    }

    .quick-action.primary {
        background: linear-gradient(135deg, #b91c1c, #991b1b);
        color: #fff;
    }

    .quick-action.secondary {
        background: #fff;
        color: #7f1d1d;
        border: 1px solid #fecaca;
    }

    @media (max-width: 992px) {
        .dashboard-kpis {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .dash-row {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .dashboard-kpis {
            grid-template-columns: 1fr;
        }

        .quick-actions {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="dashboard-shell">
    <div class="dashboard-hero">
        <span class="dash-badge"><i class="fa-solid fa-wave-square"></i> Realtime</span>
        <h2>Panel operasional website</h2>
        <p>Monitor banner, berita, komentar, dan aktivitas konten utama yang relevan dengan fitur yang tersedia di sistem.</p>

        <div class="dash-meta">
            <span class="dash-pill"><i class="fa-solid fa-bullhorn"></i> {{ $totalBanners }} banner</span>
            <span class="dash-pill"><i class="fa-solid fa-newspaper"></i> {{ $totalNews }} berita</span>
            <span class="dash-pill"><i class="fa-solid fa-comments"></i> {{ $totalComments }} komentar</span>
        </div>
    </div>

    <div class="dashboard-kpis">
        <div class="dash-kpi">
            <div class="label"><span>Banner</span><i class="fa-solid fa-image"></i></div>
            <div class="value" id="stat-banners">{{ $totalBanners }}</div>
            <div class="sub">Total slide aktif dan nonaktif</div>
        </div>
        <div class="dash-kpi">
            <div class="label"><span>Banner Aktif</span><i class="fa-solid fa-check-circle"></i></div>
            <div class="value" id="stat-active-banners" style="color:#991b1b;">{{ $activeBanners }}</div>
            <div class="sub">Sedang tayang di homepage</div>
        </div>
        <div class="dash-kpi">
            <div class="label"><span>Berita</span><i class="fa-solid fa-newspaper"></i></div>
            <div class="value" id="stat-news">{{ $totalNews }}</div>
            <div class="sub">Semua konten berita</div>
        </div>
        <div class="dash-kpi">
            <div class="label"><span>Published</span><i class="fa-solid fa-eye"></i></div>
            <div class="value" id="stat-published" style="color:#b91c1c;">{{ $publishedNews }}</div>
            <div class="sub">Berita yang sudah tampil</div>
        </div>
    </div>

    <div class="dash-statusbar">
        <span class="status-dot"></span>
        <span id="realtime-status">Realtime aktif</span>
        <span style="margin-left:auto;color:#64748b;font-weight:700;" id="realtime-time">Update: {{ now()->format('H:i:s') }}</span>
    </div>

    <div class="dash-row">
        <div class="dash-panel">
            <div class="dash-panel-head">
                <h3 class="dash-panel-title">Banner live</h3>
                <a href="{{ route('admin.banners.index') }}" class="dash-panel-link">Kelola</a>
            </div>
            <div class="dash-panel-body">
                <div class="dash-list">
                    @forelse($latestBanners as $banner)
                        <div class="dash-list-item">
                            <div>
                                <strong>{{ $banner->judul }}</strong>
                                <span>{{ $banner->subjudul ?? 'Banner utama' }}</span>
                            </div>
                            <span class="dash-pill-tag">{{ $banner->aktif ? 'Aktif' : 'Nonaktif' }}</span>
                        </div>
                    @empty
                        <div class="dash-list-item">
                            <div>
                                <strong>Belum ada banner</strong>
                                <span>Mulai buat banner dari admin.</span>
                            </div>
                            <span class="dash-pill-tag">Kosong</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="dash-panel">
            <div class="dash-panel-head">
                <h3 class="dash-panel-title">Berita terbaru</h3>
                <a href="{{ route('admin.news.index') }}" class="dash-panel-link">Kelola</a>
            </div>
            <div class="dash-panel-body">
                <div class="dash-list">
                    @forelse($latestNews as $news)
                        <div class="dash-list-item">
                            <div>
                                <strong>{{ $news->judul }}</strong>
                                <span>{{ $news->tipe ?? 'Berita' }} • {{ $news->is_published ? 'Published' : 'Draft' }}</span>
                            </div>
                            <span class="dash-pill-tag">{{ $news->is_published ? 'Tampil' : 'Draft' }}</span>
                        </div>
                    @empty
                        <div class="dash-list-item">
                            <div>
                                <strong>Belum ada berita</strong>
                                <span>Mulai buat konten untuk homepage.</span>
                            </div>
                            <span class="dash-pill-tag">Kosong</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="dash-panel">
        <div class="dash-panel-head">
            <h3 class="dash-panel-title">Komentar terbaru</h3>
            <a href="{{ route('admin.news.index') }}" class="dash-panel-link">Lihat semua</a>
        </div>
        <div class="dash-panel-body" style="padding:0;">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Berita</th>
                        <th>Komentar</th>
                    </tr>
                </thead>
                <tbody>
                    @php $recentComments = \App\Models\Comment::with('news')->latest()->limit(5)->get(); @endphp
                    @forelse($recentComments as $comment)
                        <tr>
                            <td class="name">{{ $comment->nama }}</td>
                            <td class="muted">{{ $comment->news?->judul ?? 'Berita tidak tersedia' }}</td>
                            <td class="muted">{{ Str::limit($comment->komentar, 60) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="muted" style="padding:1rem; text-align:center;">Belum ada komentar masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="quick-actions">
        <a href="{{ route('admin.news.create') }}" class="quick-action primary"><i class="fa-solid fa-plus"></i> Tambah Berita</a>
        <a href="{{ route('admin.news.index') }}" class="quick-action secondary"><i class="fa-solid fa-newspaper"></i> Semua Berita</a>
        <a href="{{ route('admin.banners.index') }}" class="quick-action secondary"><i class="fa-solid fa-images"></i> Banner</a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    async function fetchStats() {
        try {
            const res = await fetch('{{ route("admin.dashboard.stats") }}');
            const data = await res.json();

            const bannerEl = document.getElementById('stat-banners');
            const activeBannerEl = document.getElementById('stat-active-banners');
            const newsEl = document.getElementById('stat-news');
            const publishedEl = document.getElementById('stat-published');

            if (bannerEl) bannerEl.textContent = data.totalBanners ?? 0;
            if (activeBannerEl) activeBannerEl.textContent = data.activeBanners ?? 0;
            if (newsEl) newsEl.textContent = data.totalNews ?? 0;
            if (publishedEl) publishedEl.textContent = data.publishedNews ?? 0;

            if (document.getElementById('realtime-status')) {
                document.getElementById('realtime-status').textContent = 'Realtime aktif';
            }
            if (document.getElementById('realtime-time')) {
                document.getElementById('realtime-time').textContent = 'Update: ' + (data.generatedAt ?? new Date().toLocaleTimeString('id-ID'));
            }
        } catch (error) {
            if (document.getElementById('realtime-status')) {
                document.getElementById('realtime-status').textContent = 'Gagal refresh data';
            }
        }
    }

    fetchStats();
    setInterval(fetchStats, 15000);
</script>
@endsection


