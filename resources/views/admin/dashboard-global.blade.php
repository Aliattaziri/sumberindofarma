@extends('layouts.admin')

@section('title', 'Dashboard Global - Admin Sumberindo Farma Tama')
@section('page-title', 'Dashboard Global')

@section('styles')
<style>
    .global-shell {
        --g-primary: #991b1b;
        --g-primary-soft: #fee2e2;
        --g-ink: #0f172a;
        --g-muted: #64748b;
        --g-border: #e2e8f0;
        --g-card: #ffffff;
        margin-top: 1rem;
        opacity: 0;
        transform: translateY(10px);
        transition: opacity 0.45s ease, transform 0.45s ease;
    }

    .global-shell.is-ready {
        opacity: 1;
        transform: translateY(0);
    }

    .global-hero {
        position: relative;
        overflow: hidden;
        border-radius: 18px;
        background: radial-gradient(circle at right top, rgba(255, 255, 255, 0.26), transparent 38%),
                    linear-gradient(135deg, #7f1d1d 0%, #b91c1c 45%, #ef4444 100%);
        color: #fff;
        padding: 1.5rem;
        box-shadow: 0 14px 40px rgba(153, 27, 27, 0.32);
        margin-bottom: 1rem;
        isolation: isolate;
        animation: liftIn 0.6s cubic-bezier(0.2, 0.7, 0.25, 1) both;
    }

    .global-hero::before,
    .global-hero::after {
        content: '';
        position: absolute;
        z-index: -1;
        border-radius: 999px;
        pointer-events: none;
    }

    .global-hero::before {
        width: 220px;
        height: 220px;
        right: -70px;
        top: -95px;
        background: radial-gradient(circle at center, rgba(255, 255, 255, 0.34), rgba(255, 255, 255, 0));
        animation: floatBlob 8s ease-in-out infinite;
    }

    .global-hero::after {
        width: 160px;
        height: 160px;
        left: -44px;
        bottom: -86px;
        background: radial-gradient(circle at center, rgba(254, 242, 242, 0.24), rgba(254, 242, 242, 0));
        animation: floatBlob 10s ease-in-out infinite reverse;
    }

    .global-hero h2 {
        font-size: 2rem;
        line-height: 1.2;
        margin-bottom: 0.5rem;
    }

    .global-hero p {
        max-width: 760px;
        color: rgba(255, 255, 255, 0.92);
    }

    .global-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.32rem 0.8rem;
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.35);
        border-radius: 999px;
        font-size: 0.78rem;
        letter-spacing: 0.08em;
        font-weight: 700;
    }

    .global-meta {
        display: flex;
        gap: 0.8rem;
        margin-top: 1rem;
        flex-wrap: wrap;
    }

    .global-pill {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.18);
        padding: 0.48rem 0.8rem;
        border-radius: 10px;
        font-size: 0.85rem;
        backdrop-filter: blur(2px);
        animation: liftIn 0.6s cubic-bezier(0.2, 0.7, 0.25, 1) both;
    }

    .global-pill:nth-child(1) {
        animation-delay: 0.07s;
    }

    .global-pill:nth-child(2) {
        animation-delay: 0.12s;
    }

    .global-pill:nth-child(3) {
        animation-delay: 0.17s;
    }

    .global-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .global-kpi {
        background: var(--g-card);
        border: 1px solid var(--g-border);
        border-radius: 16px;
        padding: 1rem 1.1rem;
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.07);
        position: relative;
        overflow: hidden;
        transform: translateY(12px);
        opacity: 0;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .global-shell.is-ready .global-kpi {
        animation: liftIn 0.55s cubic-bezier(0.2, 0.7, 0.25, 1) both;
    }

    .global-shell.is-ready .global-kpi:nth-child(2) {
        animation-delay: 0.06s;
    }

    .global-kpi:hover {
        transform: translateY(-3px);
        box-shadow: 0 16px 34px rgba(185, 28, 28, 0.16);
    }

    .global-kpi::before {
        content: '';
        position: absolute;
        inset: 0 auto 0 0;
        width: 6px;
        background: linear-gradient(180deg, #ef4444, #b91c1c);
    }

    .global-kpi .label {
        color: var(--g-muted);
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        font-weight: 700;
    }

    .global-kpi .value {
        color: var(--g-ink);
        font-size: 2rem;
        line-height: 1.2;
        font-weight: 800;
        margin-top: 0.35rem;
    }

    .global-kpi .value.flash {
        animation: metricPulse 0.6s ease;
    }

    .global-layout {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .global-panel {
        background: #fff;
        border: 1px solid var(--g-border);
        border-radius: 16px;
        padding: 1rem;
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.06);
        opacity: 0;
        transform: translateY(14px);
    }

    .global-shell.is-ready .global-panel {
        animation: liftIn 0.6s cubic-bezier(0.2, 0.7, 0.25, 1) both;
        animation-delay: 0.13s;
    }

    .global-shell.is-ready .global-layout .global-panel:nth-child(2) {
        animation-delay: 0.19s;
    }

    .global-panel h3 {
        margin: 0;
        font-size: 1.08rem;
        color: var(--g-ink);
        font-weight: 800;
    }

    .global-sub {
        margin-top: 0.25rem;
        font-size: 0.82rem;
        color: var(--g-muted);
    }

    .global-list {
        margin-top: 0.9rem;
        display: grid;
        gap: 0.55rem;
    }

    .global-item {
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        padding: 0.7rem 0.75rem;
        background: linear-gradient(180deg, #fff, #fefefe);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .global-item:hover {
        transform: translateX(3px);
        box-shadow: 0 10px 18px rgba(148, 163, 184, 0.18);
    }

    .global-item-head {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        gap: 0.6rem;
        margin-bottom: 0.45rem;
    }

    .global-item-name {
        font-size: 0.9rem;
        color: var(--g-ink);
        font-weight: 700;
    }

    .global-item-tx {
        font-size: 0.75rem;
        color: var(--g-muted);
        font-weight: 600;
    }

    .global-progress {
        background: #f1f5f9;
        border-radius: 999px;
        height: 8px;
        overflow: hidden;
    }

    .global-progress > span {
        display: block;
        height: 100%;
        width: 0;
        border-radius: 999px;
        background: linear-gradient(90deg, #ef4444, #b91c1c);
        transition: width 0.8s cubic-bezier(0.2, 0.7, 0.25, 1);
    }

    .global-omzet {
        margin-top: 0.45rem;
        font-size: 0.86rem;
        color: #7f1d1d;
        font-weight: 800;
    }

    .global-table-card {
        background: #fff;
        border: 1px solid var(--g-border);
        border-radius: 16px;
        padding: 1rem;
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.06);
        opacity: 0;
        transform: translateY(14px);
    }

    .global-shell.is-ready .global-table-card {
        animation: liftIn 0.62s cubic-bezier(0.2, 0.7, 0.25, 1) both;
        animation-delay: 0.24s;
    }

    .global-table-head {
        display: flex;
        justify-content: space-between;
        gap: 0.7rem;
        align-items: center;
        margin-bottom: 0.8rem;
    }

    .global-table-head h3 {
        margin: 0;
        font-size: 1.08rem;
        color: var(--g-ink);
        font-weight: 800;
    }

    .global-table-link {
        color: #b91c1c;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.84rem;
    }

    .global-table-link:hover {
        text-decoration: underline;
    }

    .global-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 640px;
    }

    .global-table th,
    .global-table td {
        border-bottom: 1px solid #f1f5f9;
        padding: 0.62rem;
        text-align: left;
        font-size: 0.86rem;
    }

    .global-table th {
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-size: 0.72rem;
        color: var(--g-muted);
        font-weight: 800;
    }

    .global-table td:last-child,
    .global-table th:last-child {
        text-align: right;
    }

    .global-table tbody tr {
        animation: rowFade 0.45s ease both;
    }

    .global-table tbody tr:nth-child(2) { animation-delay: 0.02s; }
    .global-table tbody tr:nth-child(3) { animation-delay: 0.04s; }
    .global-table tbody tr:nth-child(4) { animation-delay: 0.06s; }
    .global-table tbody tr:nth-child(5) { animation-delay: 0.08s; }
    .global-table tbody tr:nth-child(6) { animation-delay: 0.1s; }

    .global-realtime {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
        margin-top: 0.7rem;
        color: var(--g-muted);
        font-size: 0.8rem;
    }

    .global-dot {
        width: 8px;
        height: 8px;
        border-radius: 999px;
        background: #ef4444;
        box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.42);
        animation: pulseGlobal 2s infinite;
    }

    .global-shell.syncing .global-dot {
        background: #f59e0b;
    }

    .global-empty {
        border: 1px dashed #cbd5e1;
        border-radius: 12px;
        color: var(--g-muted);
        padding: 0.8rem;
        font-size: 0.86rem;
        text-align: center;
    }

    .global-list .global-item {
        animation: liftIn 0.45s ease both;
    }

    .global-list .global-item:nth-child(2) { animation-delay: 0.03s; }
    .global-list .global-item:nth-child(3) { animation-delay: 0.06s; }
    .global-list .global-item:nth-child(4) { animation-delay: 0.09s; }
    .global-list .global-item:nth-child(5) { animation-delay: 0.12s; }

    @keyframes pulseGlobal {
        0% {
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.42);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(239, 68, 68, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
        }
    }

    @keyframes liftIn {
        from {
            opacity: 0;
            transform: translateY(16px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes floatBlob {
        0%, 100% {
            transform: translate3d(0, 0, 0) scale(1);
        }
        50% {
            transform: translate3d(-8px, 7px, 0) scale(1.04);
        }
    }

    @keyframes rowFade {
        from {
            opacity: 0;
            transform: translateY(8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes metricPulse {
        0% {
            transform: scale(1);
            color: var(--g-ink);
        }
        40% {
            transform: scale(1.05);
            color: #991b1b;
        }
        100% {
            transform: scale(1);
            color: var(--g-ink);
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .global-shell,
        .global-hero,
        .global-pill,
        .global-kpi,
        .global-panel,
        .global-table-card,
        .global-dot,
        .global-list .global-item,
        .global-table tbody tr,
        .global-progress > span {
            animation: none !important;
            transition: none !important;
        }
    }

    @media (max-width: 1100px) {
        .global-layout {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .global-hero {
            border-radius: 14px;
            padding: 1rem;
            margin-top: 0.7rem;
        }

        .global-hero h2 {
            font-size: 1.45rem;
        }

        .global-grid {
            grid-template-columns: 1fr;
            gap: 0.7rem;
        }

        .global-kpi {
            border-radius: 12px;
        }

        .global-panel,
        .global-table-card {
            border-radius: 12px;
            padding: 0.8rem;
        }

        .global-table {
            min-width: 560px;
        }
    }
</style>
@endsection

@section('content')
<div class="global-shell" id="globalDashboard"
     data-global-stats-url="{{ route('admin.dashboard.global-stats') }}"
     data-initial-omzet="{{ (float) $totalOmzetGlobal }}">
    <section class="global-hero">
        <span class="global-badge"><i class="fa-solid fa-earth-asia"></i> AKSES GLOBAL</span>
        <h2>Ringkasan PT. Sumberindo Farma Tama</h2>
        <p>
            Dashboard akun utama menampilkan akumulasi seluruh produk, omzet gabungan, serta histori lintas outlet
            secara realtime tanpa perlu refresh manual halaman.
        </p>
        <div class="global-meta">
            <div class="global-pill"><i class="fa-solid fa-rotate"></i><span id="global-status">Realtime aktif</span></div>
            <div class="global-pill"><i class="fa-solid fa-clock"></i><span id="global-updated">Update: {{ now()->format('H:i:s') }}</span></div>
            <div class="global-pill"><i class="fa-solid fa-receipt"></i><span>Total transaksi: <strong id="global-total-transaksi">{{ number_format($totalTransaksiGlobal) }}</strong></span></div>
        </div>
    </section>

    <section class="global-grid">
        <article class="global-kpi">
            <div class="label">Total Produk (Semua Outlet)</div>
            <div class="value" id="global-total-produk">{{ number_format($totalProdukGlobal) }}</div>
        </article>
        <article class="global-kpi">
            <div class="label">Total Omzet Global</div>
            <div class="value" id="global-total-omzet">Rp {{ number_format($totalOmzetGlobal, 0, ',', '.') }}</div>
        </article>
    </section>

    <section class="global-layout">
        <article class="global-panel">
            <h3>Omzet per Outlet / Halaman Produk</h3>
            <p class="global-sub">Sumber data: purchase history seluruh outlet</p>
            <div class="global-list" id="global-list-outlet">
                @forelse($historyByOutlet as $row)
                    @php
                        $percent = $totalOmzetGlobal > 0 ? (($row['omzet'] / $totalOmzetGlobal) * 100) : 0;
                    @endphp
                    <div class="global-item">
                        <div class="global-item-head">
                            <div class="global-item-name">{{ $row['outlet'] }}</div>
                            <div class="global-item-tx">{{ number_format($row['transaksi']) }} transaksi</div>
                        </div>
                        <div class="global-progress"><span data-width="{{ min(100, round($percent, 2)) }}"></span></div>
                        <div class="global-omzet">Rp {{ number_format($row['omzet'], 0, ',', '.') }} • {{ number_format($percent, 1, ',', '.') }}%</div>
                    </div>
                @empty
                    <div class="global-empty">Belum ada riwayat pembelian.</div>
                @endforelse
            </div>
        </article>

        <article class="global-panel">
            <h3>Omzet per Kanal Produk</h3>
            <p class="global-sub">Perbandingan kanal Apotek vs Umum</p>
            <div class="global-list" id="global-list-channel">
                @forelse($historyByChannel as $row)
                    @php
                        $percent = $totalOmzetGlobal > 0 ? (($row['omzet'] / $totalOmzetGlobal) * 100) : 0;
                    @endphp
                    <div class="global-item">
                        <div class="global-item-head">
                            <div class="global-item-name">{{ $row['channel'] }}</div>
                            <div class="global-item-tx">{{ number_format($row['transaksi']) }} transaksi</div>
                        </div>
                        <div class="global-progress"><span data-width="{{ min(100, round($percent, 2)) }}"></span></div>
                        <div class="global-omzet">Rp {{ number_format($row['omzet'], 0, ',', '.') }} • {{ number_format($percent, 1, ',', '.') }}%</div>
                    </div>
                @empty
                    <div class="global-empty">Belum ada riwayat pembelian.</div>
                @endforelse
            </div>
        </article>
    </section>

    <section class="global-table-card">
        <div class="global-table-head">
            <h3>Riwayat Pembelian Terbaru (Global)</h3>
            <a href="{{ route('admin.purchase-history.index') }}" class="global-table-link">Lihat semua</a>
        </div>
        <div class="table-container">
            <table class="global-table">
                <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Outlet</th>
                    <th>Pembeli</th>
                    <th>Kanal</th>
                    <th>Omzet</th>
                </tr>
                </thead>
                <tbody id="global-recent-tbody">
                @forelse($recentGlobalOrders as $order)
                    <tr>
                        <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td>{{ $order->source_outlet ?: '-' }}</td>
                        <td>{{ $order->buyer_name ?: '-' }}</td>
                        <td>{{ $order->buyer_type === 'apotik' ? 'Apotek' : ($order->buyer_type === 'toko_obat' ? 'Toko Obat' : ($order->buyer_type === 'pbf' ? 'PBF' : 'Umum')) }}</td>
                        <td>Rp {{ number_format($order->effective_total, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center; color:#64748b;">Belum ada data riwayat pembelian.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="global-realtime">
            <span class="global-dot" id="global-dot"></span>
            <span id="global-foot-status">Auto-refresh setiap 15 detik</span>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script>
(function () {
    const root = document.getElementById('globalDashboard');
    if (!root) return;

    requestAnimationFrame(() => {
        root.classList.add('is-ready');
    });

    const statsUrl = root.getAttribute('data-global-stats-url');

    const elTotalProduk = document.getElementById('global-total-produk');
    const elTotalOmzet = document.getElementById('global-total-omzet');
    const elTotalTransaksi = document.getElementById('global-total-transaksi');
    const elStatus = document.getElementById('global-status');
    const elUpdated = document.getElementById('global-updated');
    const elFootStatus = document.getElementById('global-foot-status');
    const elDot = document.getElementById('global-dot');
    const elOutletList = document.getElementById('global-list-outlet');
    const elChannelList = document.getElementById('global-list-channel');
    const elRecentBody = document.getElementById('global-recent-tbody');

    function fmtNumber(value) {
        return new Intl.NumberFormat('id-ID').format(Number(value || 0));
    }

    function fmtRupiah(value) {
        return 'Rp ' + fmtNumber(value || 0);
    }

    function pulseMetric(el) {
        if (!el) return;
        el.classList.remove('flash');
        void el.offsetWidth;
        el.classList.add('flash');
    }

    function animateNumber(el, nextValue, formatter, duration) {
        if (!el) return;

        const to = Number(nextValue || 0);
        const from = Number(el.getAttribute('data-raw-value') || 0);
        if (from === to) {
            el.textContent = formatter(to);
            return;
        }

        const start = performance.now();

        function frame(now) {
            const progress = Math.min(1, (now - start) / duration);
            const eased = 1 - Math.pow(1 - progress, 3);
            const current = from + ((to - from) * eased);
            el.textContent = formatter(current);

            if (progress < 1) {
                requestAnimationFrame(frame);
            } else {
                el.setAttribute('data-raw-value', String(to));
                el.textContent = formatter(to);
            }
        }

        pulseMetric(el);
        requestAnimationFrame(frame);
    }

    function renderRankList(items, totalOmzet, nameKey) {
        if (!Array.isArray(items) || items.length === 0) {
            return '<div class="global-empty">Belum ada riwayat pembelian.</div>';
        }

        return items.map((row) => {
            const omzet = Number(row.omzet || 0);
            const transaksi = Number(row.transaksi || 0);
            const percent = totalOmzet > 0 ? (omzet / totalOmzet) * 100 : 0;
            const width = Math.min(100, Math.max(0, percent));
            const name = row[nameKey] || '-';

            return '' +
                '<div class="global-item">' +
                    '<div class="global-item-head">' +
                        '<div class="global-item-name">' + name + '</div>' +
                        '<div class="global-item-tx">' + fmtNumber(transaksi) + ' transaksi</div>' +
                    '</div>' +
                    '<div class="global-progress"><span style="width:' + width.toFixed(2) + '%"></span></div>' +
                    '<div class="global-omzet">' + fmtRupiah(omzet) + ' • ' + percent.toFixed(1).replace('.', ',') + '%</div>' +
                '</div>';
        }).join('');
    }

    function renderRecentRows(rows) {
        if (!Array.isArray(rows) || rows.length === 0) {
            return '<tr><td colspan="5" style="text-align:center; color:#64748b;">Belum ada data riwayat pembelian.</td></tr>';
        }

        return rows.map((row) => {
            return '' +
                '<tr>' +
                    '<td>' + (row.waktu || '-') + '</td>' +
                    '<td>' + (row.outlet || '-') + '</td>' +
                    '<td>' + (row.pembeli || '-') + '</td>' +
                    '<td>' + (row.kanal || '-') + '</td>' +
                    '<td>' + fmtRupiah(row.omzet || 0) + '</td>' +
                '</tr>';
        }).join('');
    }

    function applyInitialProgressWidth() {
        root.querySelectorAll('.global-progress > span[data-width]').forEach((bar) => {
            const width = Number(bar.getAttribute('data-width') || 0);
            bar.style.width = Math.min(100, Math.max(0, width)).toFixed(2) + '%';
        });
    }

    async function refreshGlobalStats() {
        try {
            root.classList.add('syncing');
            const response = await fetch(statsUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            });

            if (!response.ok) {
                throw new Error('Status ' + response.status);
            }

            const data = await response.json();
            const totalOmzet = Number(data.totalOmzetGlobal || 0);

            animateNumber(elTotalProduk, data.totalProdukGlobal || 0, (v) => fmtNumber(Math.round(v)), 520);
            animateNumber(elTotalTransaksi, data.totalTransaksiGlobal || 0, (v) => fmtNumber(Math.round(v)), 520);
            animateNumber(elTotalOmzet, totalOmzet, (v) => fmtRupiah(Math.round(v)), 650);
            elOutletList.innerHTML = renderRankList(data.historyByOutlet || [], totalOmzet, 'outlet');
            elChannelList.innerHTML = renderRankList(data.historyByChannel || [], totalOmzet, 'channel');
            elRecentBody.innerHTML = renderRecentRows(data.recentGlobalOrders || []);

            const timeLabel = data.generatedAt || new Date().toLocaleTimeString('id-ID');
            elUpdated.textContent = 'Update: ' + timeLabel;
            elStatus.textContent = 'Realtime aktif';
            elFootStatus.textContent = 'Data sinkron otomatis setiap 15 detik';
            elDot.style.background = '#ef4444';
            root.classList.remove('syncing');
        } catch (error) {
            elStatus.textContent = 'Koneksi data terputus';
            elFootStatus.textContent = 'Gagal refresh otomatis, mencoba lagi...';
            elDot.style.background = '#94a3b8';
            root.classList.remove('syncing');
        }
    }

    refreshGlobalStats();
    elTotalProduk.setAttribute('data-raw-value', '{{ (int) $totalProdukGlobal }}');
    elTotalTransaksi.setAttribute('data-raw-value', '{{ (int) $totalTransaksiGlobal }}');
    elTotalOmzet.setAttribute('data-raw-value', '{{ (int) $totalOmzetGlobal }}');
    applyInitialProgressWidth();
    setInterval(refreshGlobalStats, 15000);
})();
</script>
@endsection
