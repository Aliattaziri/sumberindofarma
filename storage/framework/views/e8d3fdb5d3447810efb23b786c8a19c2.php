<?php $__env->startSection('title', 'Edit Banner - Admin Sumberindo Farma Tama'); ?>
<?php $__env->startSection('page-title', '🖼️ Edit Banner Promo'); ?>

<?php $__env->startSection('styles'); ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div style="margin-bottom:1.25rem;">
    <a href="<?php echo e(route('admin.banners.index')); ?>" style="color:#6b7280;text-decoration:none;font-size:0.85rem;">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Banner
    </a>
</div>

<div class="form-card">
    <?php if($errors->any()): ?>
    <div style="background:#fee2e2;color:#7f1d1d;padding:0.85rem 1.1rem;border-radius:0.5rem;margin-bottom:1.25rem;font-size:0.85rem;">
        <strong>Ada kesalahan:</strong>
        <ul style="margin:0.4rem 0 0 1rem;">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.banners.update', $banner)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

        <div class="form-group">
            <label class="form-label">Judul Banner <span class="req">*</span></label>
            <input type="text" name="judul" class="form-control" value="<?php echo e(old('judul', $banner->judul)); ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label">Subjudul / Deskripsi Singkat</label>
            <input type="text" name="subjudul" class="form-control" value="<?php echo e(old('subjudul', $banner->subjudul)); ?>">
        </div>

        <div class="form-group">
            <label class="form-label">Banner Media</label>
            <p class="form-hint" style="margin-bottom:0.5rem;">Media saat ini:</p>
            <?php if($banner->is_video): ?>
                <video class="current-img" controls muted>
                    <source src="<?php echo e(url('storage/'.$banner->gambar)); ?>">
                </video>
            <?php else: ?>
                <img src="<?php echo e(url('storage/'.$banner->gambar)); ?>" alt="<?php echo e($banner->judul); ?>" class="current-img" id="currentImg">
            <?php endif; ?>
            <input type="file" name="gambar" id="gambarInput" accept="image/*,video/mp4,video/webm,video/quicktime" class="form-control" onchange="previewMedia(this)">
            <p class="form-hint">Kosongkan jika tidak ingin mengganti media. Ukuran: 3998×1224px atau video maksimal 20MB</p>
            <img id="imgPreview" class="img-preview" src="#" alt="Preview Baru">
            <video id="videoPreview" class="img-preview" controls style="display:none;"></video>
        </div>

        <div class="form-row">
            <div class="form-group" style="margin-bottom:0;">
                <label class="form-label">URL Tujuan (opsional)</label>
                <input type="text" name="url_tujuan" class="form-control" value="<?php echo e(old('url_tujuan', $banner->url_tujuan)); ?>" placeholder="/products">
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label class="form-label">Label Tombol</label>
                <input type="text" name="label_tombol" class="form-control" value="<?php echo e(old('label_tombol', $banner->label_tombol)); ?>">
            </div>
        </div>

        <div class="form-row" style="margin-top:1.25rem;">
            <div class="form-group" style="margin-bottom:0;">
                <label class="form-label">Urutan Tampil</label>
                <input type="number" name="urutan" class="form-control" min="0" value="<?php echo e(old('urutan', $banner->urutan)); ?>">
                <p class="form-hint">Angka kecil tampil lebih dulu</p>
            </div>
            <div class="form-group" style="margin-bottom:0;">
                <label class="form-label">Status</label>
                <div class="toggle-wrap">
                    <label class="toggle-switch">
                        <input type="checkbox" name="aktif" value="1" <?php echo e($banner->aktif ? 'checked' : ''); ?>>
                        <span class="toggle-slider"></span>
                    </label>
                    <label>Aktif (tampil di website)</label>
                </div>
            </div>
        </div>

        <div class="btn-actions">
            <button type="submit" class="btn-save"><i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan</button>
            <a href="<?php echo e(route('admin.banners.index')); ?>" class="btn-back"><i class="fa-solid fa-xmark"></i> Batal</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function previewMedia(input) {
    const imgPreview = document.getElementById('imgPreview');
    const videoPreview = document.getElementById('videoPreview');
    const current = document.getElementById('currentImg');
    if (current) {
        current.style.opacity = '0.4';
    }

    if (input.files && input.files[0]) {
        const file = input.files[0];
        const reader = new FileReader();

        reader.onload = e => {
            if (file.type.startsWith('image/')) {
                imgPreview.src = e.target.result;
                imgPreview.style.display = 'block';
                if (videoPreview) videoPreview.style.display = 'none';
            } else if (file.type.startsWith('video/')) {
                if (videoPreview) {
                    videoPreview.src = e.target.result;
                    videoPreview.style.display = 'block';
                }
                if (imgPreview) imgPreview.style.display = 'none';
            }
        };
        reader.readAsDataURL(file);
    }
}
</script>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Ali Attaziri\sumberindofarma\resources\views/admin/banners/edit.blade.php ENDPATH**/ ?>