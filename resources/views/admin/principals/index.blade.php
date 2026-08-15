@extends('layouts.admin')

@section('title', 'Manajemen Principal Logos - Admin')

@section('content')
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;gap:0.75rem;">
        <h3>Principal Logos</h3>
        <div style="display:flex;gap:0.5rem;">
            <a href="{{ route('partners') }}" target="_blank" class="btn btn-outline">Lihat di Mitra Kami</a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <div style="margin-bottom:1rem;display:flex;align-items:center;gap:1rem;">
        <form action="{{ route('admin.principals.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label class="form-lbl">Unggah logo principal (max 2MB)</label>
            <input type="file" name="image" accept="image/*" required>
            <button class="btn btn-primary" style="margin-left:0.5rem;">Unggah</button>
        </form>
        <small style="color:#6b7280;">Setelah diunggah, logo akan otomatis tampil di halaman <strong>Mitra Kami</strong>.</small>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:1rem;">
        @forelse($files as $f)
            <div style="border:1px solid #e5e7eb;padding:0.6rem;border-radius:8px;text-align:center;">
                <img src="{{ asset('principals/' . $f) }}" alt="{{ $f }}" style="max-width:100%;height:100px;object-fit:contain;margin-bottom:0.5rem;">
                <div style="display:flex;justify-content:center;gap:0.5rem;">
                    <form action="{{ route('admin.principals.destroy', $f) }}" method="POST" onsubmit="return confirm('Hapus logo ini?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <h3>Belum ada logo principal</h3>
                <p>Unggah logo melalui form di atas untuk menampilkannya di halaman utama PBF.</p>
            </div>
        @endforelse
    </div>

@endsection
