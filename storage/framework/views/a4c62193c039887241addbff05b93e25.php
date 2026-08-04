<?php $__env->startSection('title', 'Tambah Produk - Admin Sumberindo Farma Tama'); ?>
<?php $__env->startSection('page-title', '➕ Tambah Produk'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .form-card { background:white; border-radius:0.75rem; box-shadow:0 1px 4px rgba(0,0,0,0.06); border:1px solid #f0f0f0; overflow:hidden; }
    .form-card-header { padding:1rem 1.5rem; border-bottom:1px solid #f3f4f6; display:flex; align-items:center; gap:0.6rem; }
    .form-card-header h3 { font-size:0.95rem; font-weight:700; color:#1f2937; margin:0; }
    .header-icon { width:32px; height:32px; background:#fef2f2; border-radius:0.4rem; display:flex; align-items:center; justify-content:center; color:#B91C1C; font-size:0.9rem; }
    .form-body { padding:1.5rem; display:flex; flex-direction:column; gap:1rem; }
    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
    .form-group { margin-bottom:0; }
    .form-label { display:block; font-size:0.8rem; font-weight:700; color:#374151; margin-bottom:0.4rem; text-transform:uppercase; letter-spacing:0.04em; }
    .form-label .req { color:#ef4444; margin-left:2px; }
    .form-input { width:100%; padding:0.6rem 0.85rem; border:1px solid #e5e7eb; border-radius:0.5rem; font-size:0.9rem; color:#1f2937; background:#fafafa; transition:all 0.2s; }
    .form-input:focus { outline:none; border-color:#B91C1C; background:white; box-shadow:0 0 0 3px rgba(220,38,38,0.08); }
    .form-input.is-invalid { border-color:#ef4444; }
    .form-error { font-size:0.78rem; color:#ef4444; margin-top:0.3rem; display:flex; align-items:center; gap:0.3rem; }
    .upload-zone { border:2px dashed #d1d5db; border-radius:0.6rem; padding:1.75rem 1rem; text-align:center; background:#fafafa; cursor:pointer; transition:all 0.2s; }
    .upload-zone:hover, .upload-zone.drag-over { border-color:#B91C1C; background:#fef2f2; }
    .upload-zone .upload-icon { font-size:2rem; margin-bottom:0.5rem; }
    .upload-zone p { font-size:0.85rem; color:#6b7280; margin:0 0 0.75rem; }
    .upload-zone small { font-size:0.75rem; color:#9ca3af; display:block; margin-top:0.5rem; }
    .btn-choose { display:inline-flex; align-items:center; gap:0.35rem; padding:0.45rem 1rem; background:white; border:1px solid #d1d5db; border-radius:0.4rem; font-size:0.82rem; font-weight:600; color:#374151; cursor:pointer; transition:all 0.2s; }
    .btn-choose:hover { background:#f3f4f6; border-color:#9ca3af; }
    .img-preview-wrap { margin-top:0.75rem; display:none; border-radius:0.5rem; overflow:hidden; border:1px solid #e5e7eb; position:relative; }
    .img-preview-wrap img { width:100%; max-height:220px; object-fit:contain; display:block; background:#f9fafb; }
    .img-preview-label { position:absolute; top:0.5rem; left:0.5rem; background:rgba(0,0,0,0.55); color:white; font-size:0.7rem; font-weight:600; padding:0.2rem 0.5rem; border-radius:0.3rem; }
    .form-footer { padding:1rem 1.5rem; border-top:1px solid #f3f4f6; display:flex; gap:0.6rem; align-items:center; }
    .btn-save { display:inline-flex; align-items:center; gap:0.4rem; padding:0.6rem 1.5rem; background:#B91C1C; color:white; border:none; border-radius:0.5rem; font-size:0.9rem; font-weight:700; cursor:pointer; transition:all 0.2s; }
    .btn-save:hover { background:#991B1B; transform:translateY(-1px); }
    .btn-cancel { display:inline-flex; align-items:center; gap:0.4rem; padding:0.6rem 1.25rem; background:white; color:#6b7280; border:1px solid #e5e7eb; border-radius:0.5rem; font-size:0.9rem; font-weight:600; text-decoration:none; transition:all 0.2s; }
    .btn-cancel:hover { background:#f9fafb; color:#374151; }
    .two-col-layout { display:grid; grid-template-columns:1fr 340px; gap:1.25rem; align-items:start; }
    /* Kategori selector cards */
    .kat-selector { display:grid; grid-template-columns:repeat(3,1fr); gap:0.6rem; }
    .kat-card { border:2px solid #e5e7eb; border-radius:0.6rem; padding:0.75rem 0.5rem; text-align:center; cursor:pointer; transition:all 0.2s; background:white; }
    .kat-card:hover { border-color:#B91C1C; }
    .kat-card.selected { border-color:#B91C1C; background:#fef2f2; }
    .kat-card input[type=radio] { display:none; }
    .kat-card .kat-icon { font-size:1.5rem; display:block; margin-bottom:0.3rem; }
    .kat-card .kat-label { font-size:0.72rem; font-weight:700; color:#374151; line-height:1.3; }
    .kat-card.selected .kat-label { color:#991B1B; }
    @media (max-width:900px) { .two-col-layout { grid-template-columns:1fr; } }
    @media (max-width:600px) { .form-grid { grid-template-columns:1fr; } .form-body { padding:1rem; } .form-footer { padding:1rem; } .kat-selector { grid-template-columns:1fr 1fr; } }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div style="display:flex;align-items:center;gap:0.5rem;font-size:0.82rem;color:#9ca3af;margin-bottom:1.25rem;">
    <a href="<?php echo e(route('admin.produk.index')); ?>" style="color:#B91C1C;text-decoration:none;font-weight:600;">🛒 Produk Kami</a>
    <i class="fa-solid fa-chevron-right" style="font-size:0.65rem;"></i>
    <span style="color:#374151;font-weight:600;">Tambah Produk</span>
</div>

<form action="<?php echo e(route('admin.produk.store')); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <div class="two-col-layout">

        
        <div class="form-card">
            <div class="form-card-header">
                <div class="header-icon"><i class="fa-solid fa-circle-info"></i></div>
                <h3>Informasi Produk</h3>
            </div>
            <div class="form-body">

                <?php if(auth()->check() && auth()->user()->isSuperAdmin()): ?>
                    <div class="form-group">
                        <label class="form-label">Outlet / Apotek <span class="req">*</span></label>
                        <select name="kategori" class="form-input <?php echo e($errors->has('kategori') ? 'is-invalid' : ''); ?>" required>
                            <option value="">— Pilih Outlet —</option>
                            <?php $__currentLoopData = $outletOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $outlet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($outlet); ?>" <?php echo e(old('kategori') == $outlet ? 'selected' : ''); ?>><?php echo e($outlet); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['kategori'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                <?php else: ?>
                    <div class="form-group">
                        <label class="form-label">Pabrik / Merek <span class="req">*</span></label>
                        <input type="text" name="kategori" class="form-input <?php echo e($errors->has('kategori') ? 'is-invalid' : ''); ?>"
                               placeholder="Contoh: KIMIA FARMA / WARDAH / OMRON" value="<?php echo e(old('kategori')); ?>" required>
                        <?php $__errorArgs = ['kategori'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label class="form-label">Nama Produk <span class="req">*</span></label>
                    <input type="text" name="nama_obat" class="form-input <?php echo e($errors->has('nama_obat') ? 'is-invalid' : ''); ?>"
                           placeholder="Contoh: Paracetamol 500mg" value="<?php echo e(old('nama_obat')); ?>" required>
                    <?php $__errorArgs = ['nama_obat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label class="form-label">Sediaan</label>
                    <input type="text" name="sediaan"
                           class="form-input <?php echo e($errors->has('sediaan') ? 'is-invalid' : ''); ?>"
                           placeholder="Contoh: fls, box, tube, pcs atau ketik bebas"
                           value="<?php echo e(old('sediaan')); ?>">
                    <?php $__errorArgs = ['sediaan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi Produk</label>
                    <textarea name="deskripsi" class="form-input <?php echo e($errors->has('deskripsi') ? 'is-invalid' : ''); ?>" rows="3"
                              placeholder="Contoh: Obat pereda demam dan nyeri ringan."><?php echo e(old('deskripsi')); ?></textarea>
                    <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Harga (Rp) <span class="req">*</span></label>
                        <input type="number" name="harga" class="form-input <?php echo e($errors->has('harga') ? 'is-invalid' : ''); ?>"
                               placeholder="5000" step="1" min="0" value="<?php echo e(old('harga')); ?>" required>
                        <?php $__errorArgs = ['harga'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Stok <span class="req">*</span></label>
                        <input type="number" name="stok" class="form-input <?php echo e($errors->has('stok') ? 'is-invalid' : ''); ?>"
                               placeholder="100" min="0" value="<?php echo e(old('stok')); ?>" required>
                        <?php $__errorArgs = ['stok'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">SKU</label>
                        <input type="text" name="sku" class="form-input <?php echo e($errors->has('sku') ? 'is-invalid' : ''); ?>"
                               placeholder="Contoh: SKU-001" value="<?php echo e(old('sku')); ?>">
                        <?php $__errorArgs = ['sku'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Brand</label>
                        <input type="text" name="brand" class="form-input <?php echo e($errors->has('brand') ? 'is-invalid' : ''); ?>"
                               placeholder="Contoh: WARDAH" value="<?php echo e(old('brand')); ?>">
                        <?php $__errorArgs = ['brand'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Terjual</label>
                        <input type="number" name="terjual" class="form-input <?php echo e($errors->has('terjual') ? 'is-invalid' : ''); ?>"
                               placeholder="0" min="0" value="<?php echo e(old('terjual', 0)); ?>">
                        <?php $__errorArgs = ['terjual'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Komposisi / Bahan</label>
                    <textarea name="komposisi" class="form-input" rows="3"
                              placeholder="Contoh: Paracetamol 500 mg, Aqua, Glycerin..."><?php echo e(old('komposisi')); ?></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Indikasi / Kegunaan</label>
                    <textarea name="indikasi" class="form-input" rows="3"
                              placeholder="Contoh: Meredakan demam dan nyeri ringan hingga sedang..."><?php echo e(old('indikasi')); ?></textarea>
                </div>

                
                <div class="form-group">
                    <label class="form-label">Kategori Produk <span class="req">*</span></label>
                    <div class="kat-selector" id="katSelector">
                        <?php $__currentLoopData = $kategoriOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $icon = match($kat) { 'OBAT' => '💊', 'SKINCARE & KOSMETIK' => '✨', 'ALAT KESEHATAN' => '🩺', default => '📦' };
                                $isSelected = old('kategori_produk', 'OBAT') === $kat;
                            ?>
                            <label class="kat-card <?php echo e($isSelected ? 'selected' : ''); ?>" onclick="selectKat(this)">
                                <input type="radio" name="kategori_produk" value="<?php echo e($kat); ?>" <?php echo e($isSelected ? 'checked' : ''); ?>>
                                <span class="kat-icon"><?php echo e($icon); ?></span>
                                <span class="kat-label"><?php echo e($kat); ?></span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php $__errorArgs = ['kategori_produk'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="form-error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

            </div>
            <div class="form-footer">
                <button type="submit" class="btn-save">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Produk
                </button>
                <a href="<?php echo e(route('admin.produk.index')); ?>" class="btn-cancel">
                    <i class="fa-solid fa-xmark"></i> Batal
                </a>
            </div>
        </div>

        
        <div class="form-card">
            <div class="form-card-header">
                <div class="header-icon"><i class="fa-solid fa-image"></i></div>
                <h3>Foto Produk</h3>
            </div>
            <div class="form-body">
                <div class="upload-zone" id="dropZone" onclick="document.getElementById('gambar').click()">
                    <div class="upload-icon">📸</div>
                    <p>Klik atau drag & drop gambar di sini</p>
                    <button type="button" class="btn-choose" onclick="event.stopPropagation();document.getElementById('gambar').click()">
                        <i class="fa-solid fa-folder-open"></i> Pilih File
                    </button>
                    <small>JPG, PNG, GIF — Maks. 10MB</small>
                </div>
                <input type="file" id="gambar" name="gambar" accept="image/*" style="display:none;">
                <?php $__errorArgs = ['gambar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="form-error" style="margin-top:0.5rem;"><i class="fa-solid fa-circle-exclamation"></i> <?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <div class="img-preview-wrap" id="imgPreviewWrap">
                    <span class="img-preview-label">Preview</span>
                    <img id="previewImg" src="" alt="Preview">
                </div>
                <div style="margin-top:1rem;padding:0.75rem;background:#f8faff;border-radius:0.5rem;border:1px solid #fef2f2;">
                    <p style="font-size:0.78rem;color:#6b7280;margin:0;line-height:1.6;">
                        <i class="fa-solid fa-circle-info" style="color:#B91C1C;margin-right:0.3rem;"></i>
                        Foto opsional. Jika tidak diupload, akan ditampilkan ikon default.
                    </p>
                </div>
            </div>
        </div>

    </div>
</form>

<script>
function selectKat(el) {
    document.querySelectorAll('.kat-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    el.querySelector('input[type=radio]').checked = true;
}
const input = document.getElementById('gambar');
const dropZone = document.getElementById('dropZone');
const previewWrap = document.getElementById('imgPreviewWrap');
const previewImg = document.getElementById('previewImg');
function showPreview(file) {
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => { previewImg.src = e.target.result; previewWrap.style.display = 'block'; };
    reader.readAsDataURL(file);
}
input.addEventListener('change', e => showPreview(e.target.files[0]));
['dragenter','dragover'].forEach(ev => dropZone.addEventListener(ev, e => { e.preventDefault(); e.stopPropagation(); dropZone.classList.add('drag-over'); }));
['dragleave','drop'].forEach(ev => dropZone.addEventListener(ev, e => { e.preventDefault(); e.stopPropagation(); dropZone.classList.remove('drag-over'); }));
dropZone.addEventListener('drop', e => {
    const file = e.dataTransfer.files[0];
    if (file) { const dt = new DataTransfer(); dt.items.add(file); input.files = dt.files; showPreview(file); }
});
</script>
<?php $__env->stopSection(); ?>





<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Ali Attaziri\sumberindofarma\resources\views\admin\produk\create.blade.php ENDPATH**/ ?>