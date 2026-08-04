<?php $__env->startSection('title', 'Edit Produk Promo - Admin Sumberindo Farma Tama'); ?>
<?php $__env->startSection('page-title', '🏷️ Edit Produk Promo'); ?>

<?php $__env->startSection('content'); ?>
<div style="background: white; padding: 2rem; border-radius: 0.75rem; max-width: 900px;">
    <form action="<?php echo e(route('admin.news.update', $news->id)); ?>" method="POST" enctype="multipart/form-data" id="newsForm">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <!-- Judul -->
        <div style="margin-bottom: 1.5rem;">
            <label for="judul" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">
                Judul Produk Promo <span style="color: #ef4444;">*</span>
            </label>
            <input 
                type="text" 
                id="judul" 
                name="judul" 
                value="<?php echo e(old('judul', $news->judul)); ?>"
                placeholder="Masukkan judul produk promo..."
                style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;"
                required
            >
            <?php $__errorArgs = ['judul'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Deskripsi Singkat -->
        <div style="margin-bottom: 1.5rem;">
            <label for="deskripsi" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">
                Deskripsi Singkat <span style="color: #ef4444;">*</span> <span style="color: #6b7280; font-weight: 400;">(Max. 500 karakter)</span>
            </label>
            <textarea 
                id="deskripsi" 
                name="deskripsi"
                rows="3"
                placeholder="Ringkasan singkat untuk tampilan daftar berita..."
                maxlength="500"
                style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-family: inherit;"
                required
            ><?php echo e(old('deskripsi', $news->deskripsi)); ?></textarea>
            <p style="color: #6b7280; font-size: 0.875rem; margin-top: 0.25rem;">
                <span id="charCount">0</span>/500 karakter
            </p>
            <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Konten -->
        <div style="margin-bottom: 1.5rem;">
            <label for="konten" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">
                Konten Lengkap <span style="color: #ef4444;">*</span>
            </label>
            <textarea 
                id="konten" 
                name="konten"
                rows="8"
                placeholder="Tulis konten berita lengkap di sini..."
                style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-family: inherit;"
                required
            ><?php echo e(old('konten', $news->konten)); ?></textarea>
            <?php $__errorArgs = ['konten'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Tipe Berita -->
        <div style="margin-bottom: 1.5rem;">
            <label for="tipe" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">
                Jenis Produk Promo <span style="color: #ef4444;">*</span>
            </label>
            <select 
                id="tipe" 
                name="tipe"
                style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem;"
                required
                onchange="handleTypeChange()"
            >
                <option value="">-- Pilih Jenis --</option>
                <option value="diskon"        <?php echo e(old('tipe', $news->tipe) === 'diskon'        ? 'selected' : ''); ?>>🏷️ Diskon</option>
                <option value="flash_sale"    <?php echo e(old('tipe', $news->tipe) === 'flash_sale'    ? 'selected' : ''); ?>>⚡ Flash Sale</option>
                <option value="bundling"      <?php echo e(old('tipe', $news->tipe) === 'bundling'      ? 'selected' : ''); ?>>📦 Bundling</option>
                <option value="promo_spesial" <?php echo e(old('tipe', $news->tipe) === 'promo_spesial' ? 'selected' : ''); ?>>🎁 Promo Spesial</option>
            </select>
            <?php $__errorArgs = ['tipe'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- File Upload -->
        <div style="margin-bottom: 1.5rem;">
            <label for="file" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">
                File Media 
                <span style="color: #6b7280; font-weight: 400;">(Maks. 20MB - Kosongkan jika tidak ingin mengubah)</span>
            </label>
            <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.75rem;">
                Gambar produk promo (JPG, PNG, GIF) atau video promosi (MP4, WebM, MOV)
            </p>

            <?php if($news->file): ?>
                <div style="margin-bottom: 1rem; padding: 1rem; background: #fff5f5; border-radius: 0.375rem;">
                    <p style="margin: 0 0 0.5rem 0; color: #15803d; font-weight: 600;">📁 File Saat Ini:</p>
                    <?php if(\Str::startsWith($news->file, ['news/'])): ?>
                        <?php
                            $ext = pathinfo($news->file, PATHINFO_EXTENSION);
                        ?>
                        <?php if(in_array(strtolower($ext), ['mp4', 'webm', 'mov', 'avi', 'mkv'])): ?>
                            <video src="<?php echo e(url('storage/' . $news->file)); ?>" style="max-height: 150px; max-width: 100%; border-radius: 0.375rem;" controls></video>
                        <?php else: ?>
                            <img src="<?php echo e(url('storage/' . $news->file)); ?>" style="max-height: 150px; max-width: 100%; object-fit: cover; border-radius: 0.375rem;">
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div style="
                border: 2px dashed #d1d5db;
                border-radius: 0.375rem;
                padding: 2rem;
                text-align: center;
                cursor: pointer;
                background: #f9fafb;
                transition: all 0.3s;
                position: relative;
            " id="dropZone">
                <input 
                    type="file" 
                    id="file" 
                    name="file"
                    style="display: none;"
                >
                <div id="fileLabel" style="pointer-events: none;">
                    <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">📤</div>
                    <p style="margin: 0;">Drag & drop file media baru di sini</p>
                    <p style="color: #6b7280; font-size: 0.875rem; margin-top: 0.5rem;">atau klik untuk memilih file</p>
                </div>
                <div id="filePreview" style="margin-top: 1rem;"></div>
            </div>
            <?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Thumbnail -->
        <div style="margin-bottom: 1.5rem;">
            <label for="thumbnail" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">
                Thumbnail (Gambar Preview) <span style="color: #6b7280; font-weight: 400;">(Maks. 5MB - Kosongkan jika tidak ingin mengubah)</span>
            </label>
            
            <?php if($news->thumbnail): ?>
                <div style="margin-bottom: 1rem; padding: 1rem; background: #fff5f5; border-radius: 0.375rem;">
                    <p style="margin: 0 0 0.5rem 0; color: #15803d; font-weight: 600;">🖼️ Thumbnail Saat Ini:</p>
                    <img src="<?php echo e(url('storage/' . $news->thumbnail)); ?>" style="max-height: 150px; max-width: 100%; object-fit: cover; border-radius: 0.375rem;">
                </div>
            <?php endif; ?>

            <div style="
                border: 2px dashed #d1d5db;
                border-radius: 0.375rem;
                padding: 2rem;
                text-align: center;
                cursor: pointer;
                background: #f9fafb;
                transition: all 0.3s;
            " id="thumbnailDropZone">
                <input 
                    type="file" 
                    id="thumbnail" 
                    name="thumbnail"
                    accept="image/*"
                    style="display: none;"
                >
                <div id="thumbnailLabel" style="pointer-events: none;">
                    <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">🖼️</div>
                    <p style="margin: 0;">Drag & drop thumbnail baru di sini</p>
                    <p style="color: #6b7280; font-size: 0.875rem; margin-top: 0.5rem;">atau klik untuk memilih file</p>
                </div>
                <div id="thumbnailPreview" style="margin-top: 1rem;"></div>
            </div>
            <?php $__errorArgs = ['thumbnail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Publikasi -->
        <div style="margin-bottom: 2rem; padding: 1rem; background: #f3f4f6; border-radius: 0.375rem;">
            <label style="display: flex; align-items: center; cursor: pointer;">
                <input 
                    type="checkbox" 
                    name="is_published" 
                    value="1"
                    <?php echo e(old('is_published', $news->is_published) ? 'checked' : ''); ?>

                    style="width: 1rem; height: 1rem; margin-right: 0.5rem; cursor: pointer;"
                >
                <span style="margin: 0; font-weight: 600;">✓ Publikasikan</span>
            </label>
            <p style="color: #6b7280; font-size: 0.875rem; margin: 0.5rem 0 0 1.75rem;">
                Status publikasi: <strong><?php echo e($news->is_published ? '✓ Dipublikasi' : '✕ Draft'); ?></strong>
            </p>
        </div>

        <!-- Buttons -->
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">
                ✓ Update Berita
            </button>
            <a href="<?php echo e(route('admin.news.index')); ?>" class="btn btn-secondary">
                ✕ Batal
            </a>
        </div>
    </form>
</div>

<style>
    #dropZone:hover, #thumbnailDropZone:hover {
        border-color: #ef4444;
        background: #fef2f2;
    }
    
    #filePreview img, #thumbnailPreview img {
        max-height: 200px;
        max-width: 100%;
        object-fit: cover;
        border-radius: 0.375rem;
    }
    
    video {
        max-height: 200px;
        max-width: 100%;
        border-radius: 0.375rem;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Character counter for deskripsi
    const deskripsiField = document.getElementById('deskripsi');
    const charCount = document.getElementById('charCount');
    
    deskripsiField.addEventListener('input', function() {
        charCount.textContent = this.value.length;
    });
    
    // Initialize character count
    charCount.textContent = deskripsiField.value.length;
    
    // File upload handlers
    setupDropZone('dropZone', 'file', 'fileLabel', 'filePreview', 20); // 20MB max for media
    setupDropZone('thumbnailDropZone', 'thumbnail', 'thumbnailLabel', 'thumbnailPreview', 5); // 5MB max for thumbnail
});

function setupDropZone(zoneId, inputId, labelId, previewId, maxMB) {
    const zone = document.getElementById(zoneId);
    const input = document.getElementById(inputId);
    const label = document.getElementById(labelId);
    const preview = document.getElementById(previewId);
    
    zone.addEventListener('click', () => input.click());
    
    zone.addEventListener('dragover', (e) => {
        e.preventDefault();
        zone.style.borderColor = '#ef4444';
        zone.style.background = '#fef2f2';
    });
    
    zone.addEventListener('dragleave', () => {
        zone.style.borderColor = '#d1d5db';
        zone.style.background = '#f9fafb';
    });
    
    zone.addEventListener('drop', (e) => {
        e.preventDefault();
        zone.style.borderColor = '#d1d5db';
        zone.style.background = '#f9fafb';
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleFile(files[0], input, label, preview, maxMB);
        }
    });
    
    input.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            handleFile(e.target.files[0], input, label, preview, maxMB);
        }
    });
}

function handleFile(file, input, label, preview, maxMB) {
    const maxBytes = maxMB * 1024 * 1024;
    
    if (file.size > maxBytes) {
        alert(`File terlalu besar. Maksimal ${maxMB}MB.`);
        return;
    }
    
    // Create file input
    const dataTransfer = new DataTransfer();
    dataTransfer.items.add(file);
    input.files = dataTransfer.files;
    
    // Show preview
    const reader = new FileReader();
    reader.onload = (e) => {
        label.style.display = 'none';
        preview.innerHTML = '';
        
        if (file.type.startsWith('image/')) {
            const img = document.createElement('img');
            img.src = e.target.result;
            preview.appendChild(img);
        } else if (file.type.startsWith('video/')) {
            const video = document.createElement('video');
            video.src = e.target.result;
            video.controls = true;
            preview.appendChild(video);
        }
        
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.textContent = '✕ Hapus File Baru';
        removeBtn.style.cssText = 'margin-top: 1rem; padding: 0.5rem 1rem; background: #ef4444; color: white; border: none; border-radius: 0.375rem; cursor: pointer;';
        removeBtn.onclick = (e) => {
            e.preventDefault();
            input.value = '';
            label.style.display = 'block';
            preview.innerHTML = '';
        };
        preview.appendChild(removeBtn);
    };
    reader.readAsDataURL(file);
}

function handleTypeChange() {
    // Can add conditional logic here to hide/show file upload based on type
}
</script>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Ali Attaziri\sumberindofarma\resources\views\admin\news\edit.blade.php ENDPATH**/ ?>