@extends('layouts.admin')
@section('title', 'Edit Banner - Admin Sumberindo Farma Tama')
@section('page-title', '🖼️ Edit Banner Slideshow')

@section('styles')
<style>
.form-card { background:#fff; border-radius:1rem; padding:1.75rem; border:1px solid #e5e7eb; box-shadow:0 1px 4px rgba(0,0,0,0.06); max-width:680px; }
.form-group { margin-bottom:1.25rem; }
.form-label { display:block; font-size:0.82rem; font-weight:700; color:#374151; margin-bottom:0.4rem; }
.form-label .req { color:#ef4444; }
.form-control { width:100%; padding:0.65rem 0.9rem; border:1.5px solid #e5e7eb; border-radius:0.5rem; font-size:0.9rem; color:#374151; transition:border-color 0.2s; background:#fafafa; }
.form-control:focus { outline:none; border-color:#B91C1C; background:#fff; box-shadow:0 0 0 3px rgba(220,38,38,0.08); }
.form-hint { font-size:0.75rem; color:#9ca3af; margin-top:0.3rem; }
.form-row { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
.toggle-wrap { display:flex; align-items:center; gap:0.75rem; padding:0.75rem 1rem; background:#f8faff; border-radius:0.5rem; border:1.5px solid #e5e7eb; }
.toggle-switch { position:relative; width:44px; height:24px; }
.toggle-switch input { opacity:0; width:0; height:0; }
.toggle-slider { position:absolute; inset:0; background:#d1d5db; border-radius:24px; cursor:pointer; transition:0.3s; }
.toggle-slider::before { content:''; position:absolute; width:18px; height:18px; left:3px; bottom:3px; background:#fff; border-radius:50%; transition:0.3s; }
.toggle-switch input:checked + .toggle-slider { background:#B91C1C; }
.toggle-switch input:checked + .toggle-slider::before { transform:translateX(20px); }
.current-img { width:100%; height:160px; object-fit:cover; border-radius:0.5rem; border:1.5px solid #e5e7eb; margin-bottom:0.5rem; display:block; }
.img-preview { width:100%; height:160px; object-fit:cover; border-radius:0.5rem; border:1.5px solid #fecaca; display:none; margin-top:0.5rem; }
.btn-actions { display:flex; gap:0.75rem; margin-top:1.5rem; flex-wrap:wrap; }
.btn-save { padding:0.7rem 2rem; background:#B91C1C; color:#fff; border:none; border-radius:0.5rem; font-size:0.9rem; font-weight:700; cursor:pointer; transition:all 0.2s; display:inline-flex; align-items:center; gap:0.4rem; }
.btn-save:hover { background:#991B1B; transform:translateY(-1px); }
.btn-back { padding:0.7rem 1.5rem; background:#fff; color:#374151; border:1.5px solid #e5e7eb; border-radius:0.5rem; font-size:0.9rem; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:0.4rem; transition:all 0.2s; }
.btn-back:hover { background:#f9fafb; color:#374151; }
@media(max-width:600px) { .form-row { grid-template-columns:1fr; } }
</style>
@endsection

@section('content')
<div style="margin-bottom:1.25rem;">
    <a href="{{ route('admin.banners.index') }}" style="color:#6b7280;text-decoration:none;font-size:0.85rem;">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Banner
    </a>
</div>

<div class="form-card">
    @if($errors->any())
    <div style="background:#fee2e2;color:#7f1d1d;padding:0.85rem 1.1rem;border-radius:0.5rem;margin-bottom:1.25rem;font-size:0.85rem;">
        <strong>Ada kesalahan:</strong>
        <ul style="margin:0.4rem 0 0 1rem;">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="form-group">
            <label class="form-label">Banner Media</label>
            <p class="form-hint" style="margin-bottom:0.5rem;">Media saat ini:</p>
            @if($banner->is_video)
                <video class="current-img" controls muted>
                    <source src="{{ url('storage/'.$banner->gambar) }}">
                </video>
            @else
                <img src="{{ url('storage/'.$banner->gambar) }}" alt="{{ $banner->judul }}" class="current-img" id="currentImg">
            @endif
            <input type="file" name="gambar" id="gambarInput" accept="image/*,video/mp4,video/webm,video/quicktime" class="form-control" onchange="previewMedia(this)">
            <p class="form-hint">Kosongkan jika tidak ingin mengganti media. Ukuran: 3998×1224px atau video maksimal 100MB</p>
            <img id="imgPreview" class="img-preview" src="#" alt="Preview Baru">
            <video id="videoPreview" class="img-preview" controls style="display:none;"></video>
        </div>

        <div class="form-row">
            <div class="form-group" style="margin-bottom:0;">
                <label class="form-label">URL Tujuan <span style="font-weight:400;color:#9ca3af;">(opsional)</span></label>
                <input type="text" name="url_tujuan" id="urlTujuanInput" class="form-control" value="{{ old('url_tujuan', $banner->url_tujuan) }}" placeholder="/products atau https://..." oninput="syncButtonField()">
                <p class="form-hint">Link ketika tombol banner diklik</p>
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label class="form-label">Teks Tombol <span style="font-weight:400;color:#9ca3af;">(opsional)</span></label>
                <input type="text" name="label_tombol" id="labelTombolInput" class="form-control" value="{{ old('label_tombol', $banner->label_tombol) }}" placeholder="Cth: Lihat Produk" maxlength="80">
                <p class="form-hint" id="labelHint" style="color:#f59e0b;display:none;"><i class="fa-solid fa-triangle-exclamation"></i> Isi URL dulu agar tombol muncul</p>
                <p class="form-hint" id="labelHintOk" style="display:none;">Tombol akan tampil di atas banner</p>
            </div>
        </div>

        <div class="form-row" style="margin-top:1.25rem;">
            <div class="form-group" style="margin-bottom:0;">
                <label class="form-label">Urutan Tampil</label>
                <input type="number" name="urutan" class="form-control" min="0" value="{{ old('urutan', $banner->urutan) }}">
                <p class="form-hint">Angka kecil tampil lebih dulu</p>
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label class="form-label">Status</label>
                <div class="toggle-wrap">
                    <label class="toggle-switch">
                        <input type="checkbox" name="aktif" value="1" {{ $banner->aktif ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                    <label>Aktif (tampil di website)</label>
                </div>
            </div>
        </div>

        <div class="btn-actions">
            <button type="submit" class="btn-save"><i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan</button>
            <a href="{{ route('admin.banners.index') }}" class="btn-back"><i class="fa-solid fa-xmark"></i> Batal</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
function previewMedia(input) {
    const imgPreview = document.getElementById('imgPreview');
    const videoPreview = document.getElementById('videoPreview');
    const current = document.getElementById('currentImg');
    if (current) current.style.opacity = '0.4';
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();
        reader.onload = e => {
            if (file.type.startsWith('image/')) {
                imgPreview.src = e.target.result;
                imgPreview.style.display = 'block';
                if (videoPreview) videoPreview.style.display = 'none';
            } else if (file.type.startsWith('video/')) {
                if (videoPreview) { videoPreview.src = e.target.result; videoPreview.style.display = 'block'; }
                if (imgPreview) imgPreview.style.display = 'none';
            }
        };
        reader.readAsDataURL(file);
    }
}

function syncButtonField() {
    const url    = document.getElementById('urlTujuanInput');
    const label  = document.getElementById('labelTombolInput');
    const hint   = document.getElementById('labelHint');
    const hintOk = document.getElementById('labelHintOk');
    if (!url || !label) return;
    const hasUrl = url.value.trim().length > 0;
    label.disabled = !hasUrl;
    if (hint)   hint.style.display   = hasUrl ? 'none' : (label.value.trim() ? 'block' : 'none');
    if (hintOk) hintOk.style.display = (hasUrl && label.value.trim()) ? 'block' : 'none';
    if (!hasUrl) label.value = '';
}

document.addEventListener('DOMContentLoaded', function() {
    syncButtonField();
});
</script>
@endsection



