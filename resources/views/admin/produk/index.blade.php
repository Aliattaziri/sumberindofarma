@extends('layouts.admin')

@section('title', 'Principle Logo - Admin')
@section('page-title', 'Principle Logo')

@section('styles')
<style>
  .list-card { background:white; border-radius:8px; padding:1rem; border:1px solid #eef2f7; }
  .logo-img { width:96px; height:56px; object-fit:contain; border:1px solid #f3f4f6; background:#fff; }
  .row { display:flex; gap:1rem; align-items:center; padding:0.6rem 0; border-bottom:1px solid #f5f7fa; }
  .row:last-child { border-bottom:none; }
  .actions a, .actions form { display:inline-block; margin-left:0.5rem; }
</style>
@endsection

@section('content')

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
  <div>
    <h2 style="margin:0;">Principle Logo</h2>
    <div style="color:#6b7280;font-size:0.9rem;">Total: <strong>{{ $medicines->total() }}</strong></div>
  </div>
  <div>
    <a href="{{ route('admin.produk.create') }}" class="btn btn-primary">Tambah Logo</a>
  </div>
</div>

<div class="list-card">
  @forelse($medicines as $m)
    <div class="row">
      <div style="width:100px;flex:0 0 100px;">
        @if($m->gambar)
          <img src="{{ url('storage/' . $m->gambar) }}" alt="{{ $m->nama_obat }}" class="logo-img">
        @else
          <div class="logo-img" style="display:flex;align-items:center;justify-content:center;color:#9ca3af;">No image</div>
        @endif
      </div>
      <div style="flex:1;">
        <div style="font-weight:700;color:#111827;">{{ $m->nama_obat }}</div>
        <div style="color:#6b7280;font-size:0.9rem;">Link: @if($m->brand)<a href="{{ $m->brand }}" target="_blank">{{ $m->brand }}</a>@else - @endif</div>
      </div>
      <div style="width:200px;text-align:right;" class="actions">
        <a href="{{ route('admin.produk.edit', $m->id) }}" class="btn btn-sm btn-secondary">Edit</a>
        <form action="{{ route('admin.produk.destroy', $m->id) }}" method="POST" style="display:inline-block;">
          @csrf
          @method('DELETE')
          <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus logo ini?')">Hapus</button>
        </form>
      </div>
    </div>
  @empty
    <div style="padding:1rem;text-align:center;color:#6b7280;">Belum ada principle logo. Tambah menggunakan tombol di atas.</div>
  @endforelse

  <div style="margin-top:0.75rem;">
    {{ $medicines->links() }}
  </div>
</div>

@endsection

