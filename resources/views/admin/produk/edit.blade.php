@extends('layouts.admin')

@section('title', 'Edit Principle Logo')
@section('page-title', 'Edit Principle Logo')

@section('content')

<div class="mb-6">
  <a href="{{ route('admin.produk.index') }}" class="text-sm text-indigo-600 hover:underline">← Kembali ke daftar</a>
  <h3 class="mt-3 text-2xl font-semibold text-gray-800">Edit Logo Mitra</h3>
</div>

<form action="{{ route('admin.produk.update', $medicine->id) }}" method="POST" enctype="multipart/form-data">
  @csrf
  @method('PUT')
  <div class="card" style="max-width:880px;">
    <div class="form-group">
      <label class="form-label">Nama Mitra</label>
      <input type="text" name="nama_obat" value="{{ old('nama_obat', $medicine->nama_obat) }}" required class="form-control">
      @error('nama_obat') <div class="form-errors">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
      <label class="form-label">Link Mitra (https://...)</label>
      <input type="url" name="brand" value="{{ old('brand', $medicine->brand) }}" class="form-control">
      @error('brand') <div class="form-errors">{{ $message }}</div> @enderror
    </div>

    <div class="form-group">
      <label class="form-label">Foto Logo saat ini</label>
      @if($medicine->gambar)
        <div style="margin-bottom:0.6rem;"><img src="{{ url('storage/' . $medicine->gambar) }}" style="max-width:200px;max-height:120px;object-fit:contain;border:1px solid #eef2f7;" alt="logo"></div>
        <label style="display:inline-flex;align-items:center;gap:0.4rem;">
          <input type="checkbox" name="delete_gambar" value="1"> Hapus foto saat ini
        </label>
      @else
        <div style="color:#6b7280;">Belum ada foto.</div>
      @endif
    </div>

    <div class="form-group">
      <label class="form-label">Unggah Foto Baru (opsional)</label>
      <input type="file" id="fileInput" name="gambar" accept="image/*" class="form-control" style="padding:0.4rem;" />
      @error('gambar') <div class="form-errors">{{ $message }}</div> @enderror
    </div>

    <div style="display:flex;gap:0.5rem;">
      <button class="btn btn-primary" type="submit">Simpan</button>
      <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">Batal</a>
    </div>
  </div>
</form>

@section('scripts')
<link  rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<script>
  (function(){
    let cropper;
    const fileInput = document.getElementById('fileInput');
    const modalImage = document.createElement('img');
    modalImage.style.maxWidth = '100%';

    const previewBox = document.createElement('div');
    previewBox.style.marginTop = '0.5rem';

    const previewThumb = document.createElement('img');
    previewThumb.style.maxWidth = '160px';
    previewThumb.style.maxHeight = '90px';
    previewThumb.style.objectFit = 'contain';
    previewThumb.style.display = 'none';
    previewBox.appendChild(previewThumb);

    fileInput.parentNode.appendChild(previewBox);

    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'cropped_image';
    fileInput.form.appendChild(hiddenInput);

    fileInput.addEventListener('change', function(e){
      const file = e.target.files && e.target.files[0];
      if (!file) return;
      const reader = new FileReader();
      reader.onload = function(ev){
        const overlay = document.createElement('div');
        overlay.style.position = 'fixed';
        overlay.style.inset = 0;
        overlay.style.background = 'rgba(0,0,0,0.6)';
        overlay.style.display = 'flex';
        overlay.style.alignItems = 'center';
        overlay.style.justifyContent = 'center';
        overlay.style.zIndex = 9999;

        const box = document.createElement('div');
        box.style.width = '80%';
        box.style.maxWidth = '900px';
        box.style.background = '#fff';
        box.style.padding = '12px';
        box.style.borderRadius = '8px';
        box.style.boxShadow = '0 6px 24px rgba(0,0,0,0.2)';

        modalImage.src = ev.target.result;
        box.appendChild(modalImage);

        const btnRow = document.createElement('div');
        btnRow.style.marginTop = '8px';
        btnRow.style.display = 'flex';
        btnRow.style.gap = '8px';

        const cropBtn = document.createElement('button');
        cropBtn.type = 'button';
        cropBtn.className = 'btn btn-primary';
        cropBtn.textContent = 'Crop & Gunakan';

        const cancelBtn = document.createElement('button');
        cancelBtn.type = 'button';
        cancelBtn.className = 'btn btn-secondary';
        cancelBtn.textContent = 'Batal';

        btnRow.appendChild(cropBtn);
        btnRow.appendChild(cancelBtn);
        box.appendChild(btnRow);

        overlay.appendChild(box);
        document.body.appendChild(overlay);

        cropper = new Cropper(modalImage, { viewMode: 1, aspectRatio: NaN });

        cancelBtn.addEventListener('click', function(){
          cropper.destroy();
          document.body.removeChild(overlay);
          fileInput.value = '';
        });

        cropBtn.addEventListener('click', function(){
          const canvas = cropper.getCroppedCanvas({ maxWidth: 1200, maxHeight: 800, imageSmoothingQuality: 'high' });
          const dataUrl = canvas.toDataURL('image/png');
          hiddenInput.value = dataUrl;
          previewThumb.src = dataUrl;
          previewThumb.style.display = 'inline-block';
          cropper.destroy();
          document.body.removeChild(overlay);
        });
      };
      reader.readAsDataURL(file);
    });
  })();
</script>
@endsection

@endsection




