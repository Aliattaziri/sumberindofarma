

<?php $__env->startSection('title', 'Edit Berita - Admin Sumberindo Farma Tama'); ?>
<?php $__env->startSection('page-title', '📰 Edit Berita'); ?>

<?php $__env->startSection('content'); ?>
<div style="background: white; padding: 2rem; border-radius: 0.75rem; max-width: 900px;">
    <form action="<?php echo e(route('admin.news.update', $news->id)); ?>" method="POST" enctype="multipart/form-data" id="newsForm">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <!-- Deskripsi -->
        <div style="margin-bottom: 1.5rem;">
            <label for="deskripsi" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">
                Deskripsi <span style="color: #ef4444;">*</span>
            </label>
            <textarea 
                id="deskripsi" 
                name="deskripsi"
                rows="4"
                placeholder="Tulis deskripsi konten berita Anda di sini..."
                style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-family: inherit;"
                required
            ><?php echo e(old('deskripsi', $news->deskripsi)); ?></textarea>
            <p style="color: #6b7280; font-size: 0.875rem; margin-top: 0.25rem;">
                <span id="charCount">0</span> karakter (tanpa batasan)
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

        <!-- File Media -->
        <div style="margin-bottom: 1.5rem;">
            <label for="file" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">
                File Media Utama <span style="color: #6b7280; font-weight: 400;">(opsional)</span>
            </label>
            <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.75rem;">
                Foto (JPG, PNG, GIF, WebP) atau Video (MP4, WebM, MOV). Maksimal 500MB. Untuk carousel, upload beberapa foto di bagian galeri.
            </p>
            <?php if($news->file): ?>
                <div style="background: #f3f4f6; padding: 1rem; border-radius: 0.375rem; margin-bottom: 1rem;">
                    <p style="margin: 0 0 0.5rem 0; font-weight: 600; color: #374151;">File saat ini:</p>
                    <?php if(str_contains($news->file, '.mp4') || str_contains($news->file, '.webm') || str_contains($news->file, '.mov')): ?>
                        <video src="<?php echo e(asset('storage/' . $news->file)); ?>" controls style="max-height: 150px; max-width: 100%; border-radius: 0.375rem;"></video>
                    <?php else: ?>
                        <img src="<?php echo e(asset('storage/' . $news->file)); ?>" alt="Current media" style="max-height: 150px; max-width: 100%; object-fit: cover; border-radius: 0.375rem;">
                    <?php endif; ?>
                    <label style="display: flex; align-items: center; cursor: pointer; margin-top: 0.75rem;">
                        <input type="checkbox" name="delete_file" value="1" style="width: 1rem; height: 1rem; margin-right: 0.5rem; cursor: pointer;">
                        <span style="font-size: 0.875rem; color: #ef4444; font-weight: 600;">🗑️ Hapus file ini dan ganti dengan yang baru</span>
                    </label>
                </div>
            <?php endif; ?>
            <div style="border: 2px dashed #d1d5db; border-radius: 0.375rem; padding: 2rem; text-align: center; cursor: pointer; background: #f9fafb; transition: all 0.3s;" id="dropZoneMain">
                <input type="file" id="file" name="file" style="display: none;" accept="image/*,video/*">
                <div id="fileLabel" style="pointer-events: none;">
                    <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">📤</div>
                    <p style="margin: 0; font-weight: 600;">Drag & drop file media utama di sini</p>
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

        <!-- Gallery Carousel -->
        <div style="margin-bottom: 1.5rem;">
            <label for="gallery" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">
                Galeri Foto Carousel <span style="color: #6b7280; font-weight: 400;">(opsional)</span>
            </label>
            <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.75rem;">
                Atur urutan foto sesuai preferensi Anda. Foto paling atas akan jadi cover utama. Semua foto default memakai rasio 3:4. Maksimal 500MB per file.
            </p>
            <?php if(!empty($news->gallery)): ?>
                <div id="existingGalleryPreview" style="display: flex; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1rem;">
                    <?php $__currentLoopData = $news->gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $galleryImage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="existing-gallery-item" data-path="<?php echo e($galleryImage); ?>" style="position: relative; width: 90px; height: 120px; border-radius: 0.5rem; overflow: hidden; border: <?php echo e($index === 0 ? '2px solid #f59e0b' : '1px solid #e5e7eb'); ?>; box-shadow: <?php echo e($index === 0 ? '0 0 0 1px rgba(245,158,11,0.45)' : 'none'); ?>; background: #fff;">
                            <img src="<?php echo e(asset('storage/' . $galleryImage)); ?>" alt="Gallery" style="width: 100%; height: 100%; object-fit: cover;">
                            <div style="position:absolute; top:6px; left:6px; background: <?php echo e($index === 0 ? '#f59e0b' : 'rgba(15,23,42,0.8)'); ?>; color:#fff; font-size:0.65rem; font-weight:700; padding:0.2rem 0.45rem; border-radius:999px;"><?php echo e($index === 0 ? 'Cover' : '#' . ($index + 1)); ?></div>
                            <div style="position:absolute; bottom:6px; left:6px; right:6px; display:flex; gap:0.25rem; justify-content:space-between;">
                                <button type="button" class="gallery-move-left" data-path="<?php echo e($galleryImage); ?>" style="flex:1; border:none; border-radius:0.4rem; background:rgba(0,0,0,0.65); color:#fff; font-size:0.7rem; cursor:pointer;">←</button>
                                <button type="button" class="gallery-move-right" data-path="<?php echo e($galleryImage); ?>" style="flex:1; border:none; border-radius:0.4rem; background:rgba(0,0,0,0.65); color:#fff; font-size:0.7rem; cursor:pointer;">→</button>
                                <button type="button" class="gallery-remove" data-path="<?php echo e($galleryImage); ?>" style="flex:1; border:none; border-radius:0.4rem; background:rgba(239,68,68,0.9); color:#fff; font-size:0.7rem; cursor:pointer;">✕</button>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
            <div style="border: 2px dashed #d1d5db; border-radius: 0.375rem; padding: 1.25rem; background: #f9fafb;" id="galleryDropZone">
                <input type="file" id="gallery" name="gallery[]" multiple accept="image/*" style="display: none;">
                <div id="galleryLabel" style="cursor: pointer; text-align: center; color: #374151;">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">🖼️</div>
                    <p style="margin: 0; font-weight: 600;">Klik untuk memilih beberapa foto</p>
                </div>
                <div id="galleryPreview" style="display: flex; flex-wrap: wrap; gap: 0.75rem; margin-top: 1rem;"></div>
            </div>
            <input type="hidden" id="galleryOrder" name="gallery_order" value="">
            <input type="hidden" id="galleryExistingOrder" name="gallery_existing_order" value='<?php echo e(json_encode($news->gallery ?? [])); ?>'>
            <?php $__errorArgs = ['gallery'];
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

        <!-- Tanggal & Publikasi -->
        <div style="margin-bottom: 2rem; padding: 1rem; background: #f3f4f6; border-radius: 0.375rem;">
            <div style="margin-bottom: 1rem;">
                <label for="created_at" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">
                    Tanggal Berita
                </label>
                <input
                    type="date"
                    id="created_at"
                    name="created_at"
                    value="<?php echo e(old('created_at', $news->created_at ? $news->created_at->format('Y-m-d') : now()->format('Y-m-d'))); ?>"
                    style="width: 100%; max-width: 280px; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-family: inherit;"
                >
                <p style="color: #6b7280; font-size: 0.875rem; margin: 0.5rem 0 0 0;">
                    Atur tanggal publikasi berita sesuai kebutuhan.
                </p>
            </div>

            <label style="display: flex; align-items: center; cursor: pointer;">
                <input type="checkbox" name="is_published" value="1" <?php echo e(old('is_published', $news->is_published) ? 'checked' : ''); ?> style="width: 1rem; height: 1rem; margin-right: 0.5rem; cursor: pointer;">
                <span style="margin: 0; font-weight: 600;">✓ Publikasikan</span>
            </label>
            <p style="color: #6b7280; font-size: 0.875rem; margin: 0.5rem 0 0 1.75rem;">
                Jika tidak dicentang, berita akan disimpan sebagai draft dan tidak ditampilkan ke user.
            </p>
        </div>

        <!-- Info -->
        <div style="margin-bottom: 2rem; padding: 1rem; background: #ecfdf5; border-radius: 0.375rem; border-left: 4px solid #10b981;">
            <p style="margin: 0; color: #047857; font-size: 0.875rem;">
                ℹ️ Dibuat: <?php echo e($news->created_at->format('d M Y H:i')); ?> | Dilihat: <?php echo e($news->views); ?> kali
            </p>
        </div>

        <!-- Buttons -->
        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn btn-primary">✓ Simpan Perubahan</button>
            <a href="<?php echo e(route('admin.news.index')); ?>" class="btn btn-secondary">✕ Batal</a>
        </div>
    </form>

    <!-- Delete Form (Outside Main Form) -->
    <form action="<?php echo e(route('admin.news.destroy', $news->id)); ?>" method="POST" style="display: inline; margin-top: 1rem;">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">🗑️ Hapus</button>
    </form>
</div>

<style>
    .btn-danger { background: #dc2626 !important; color: white !important; }
    .btn-danger:hover { background: #b91c1c !important; }
    #dropZone:hover { border-color: #ef4444; background: #fef2f2; }
    #filePreview img { max-height: 250px; max-width: 100%; object-fit: cover; border-radius: 0.375rem; margin-bottom: 1rem; }
    #filePreview video { max-height: 250px; max-width: 100%; border-radius: 0.375rem; margin-bottom: 1rem; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deskripsiField = document.getElementById('deskripsi');
    const charCount = document.getElementById('charCount');
    const existingGalleryPreview = document.getElementById('existingGalleryPreview');
    const galleryExistingOrder = document.getElementById('galleryExistingOrder');

    deskripsiField.addEventListener('input', function() { charCount.textContent = this.value.length; });
    charCount.textContent = deskripsiField.value.length;
    setupDropZone('dropZoneMain', 'file', 'fileLabel', 'filePreview', 100);
    setupGalleryDropZone('galleryDropZone', 'gallery', 'galleryLabel', 'galleryPreview');

    if (existingGalleryPreview) {
        const items = Array.from(existingGalleryPreview.querySelectorAll('.existing-gallery-item'));
        const reorderExistingGallery = () => {
            const ordered = Array.from(existingGalleryPreview.querySelectorAll('.existing-gallery-item')).map(el => el.dataset.path);
            if (galleryExistingOrder) galleryExistingOrder.value = JSON.stringify(ordered);
        };

        items.forEach((item, index) => {
            const left = item.querySelector('.gallery-move-left');
            const right = item.querySelector('.gallery-move-right');
            const remove = item.querySelector('.gallery-remove');

            left.addEventListener('click', () => {
                const current = Array.from(existingGalleryPreview.children);
                const currentIndex = current.indexOf(item);
                if (currentIndex > 0) {
                    existingGalleryPreview.insertBefore(item, current[currentIndex - 1]);
                    reorderExistingGallery();
                }
            });

            right.addEventListener('click', () => {
                const current = Array.from(existingGalleryPreview.children);
                const currentIndex = current.indexOf(item);
                if (currentIndex < current.length - 1) {
                    const nextSibling = current[currentIndex + 1];
                    existingGalleryPreview.insertBefore(nextSibling, item);
                    reorderExistingGallery();
                }
            });

            remove.addEventListener('click', () => {
                item.remove();
                reorderExistingGallery();
            });
        });

        reorderExistingGallery();
    }
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
        if (e.dataTransfer.files.length > 0) {
            handleFile(e.dataTransfer.files[0], input, label, preview, maxMB);
        }
    });
    input.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            handleFile(e.target.files[0], input, label, preview, maxMB);
        }
    });
}

function setupGalleryDropZone(zoneId, inputId, labelId, previewId) {
    const zone = document.getElementById(zoneId);
    const input = document.getElementById(inputId);
    const label = document.getElementById(labelId);
    const preview = document.getElementById(previewId);
    zone.addEventListener('click', () => input.click());
    input.addEventListener('change', (e) => {
        const files = Array.from(e.target.files || []);
        if (!files.length) return;
        renderGalleryPreview(files, preview, input, label);
    });
}

function renderGalleryPreview(files, preview, input, label) {
    preview.innerHTML = '';
    files.forEach((file, index) => {
        const wrapper = document.createElement('div');
        wrapper.style.position = 'relative';
        wrapper.style.width = '120px';
        wrapper.style.height = '160px';
        wrapper.style.borderRadius = '0.75rem';
        wrapper.style.overflow = 'hidden';
        wrapper.style.border = index === 0 ? '2px solid #f59e0b' : '1px solid #e5e7eb';
        wrapper.style.background = '#fff';
        wrapper.style.boxShadow = index === 0 ? '0 0 0 1px rgba(245,158,11,0.45)' : 'none';

        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.style.width = '100%';
        img.style.height = '100%';
        img.style.objectFit = 'cover';
        wrapper.appendChild(img);

        const tag = document.createElement('div');
        tag.textContent = index === 0 ? 'Cover' : `#${index + 1}`;
        tag.style.position = 'absolute';
        tag.style.top = '6px';
        tag.style.left = '6px';
        tag.style.background = index === 0 ? '#f59e0b' : 'rgba(15,23,42,0.8)';
        tag.style.color = '#fff';
        tag.style.fontSize = '0.65rem';
        tag.style.fontWeight = '700';
        tag.style.padding = '0.2rem 0.45rem';
        tag.style.borderRadius = '999px';
        wrapper.appendChild(tag);

        const controls = document.createElement('div');
        controls.style.position = 'absolute';
        controls.style.bottom = '6px';
        controls.style.left = '6px';
        controls.style.right = '6px';
        controls.style.display = 'flex';
        controls.style.gap = '0.25rem';
        controls.style.justifyContent = 'space-between';

        const moveLeft = document.createElement('button');
        moveLeft.type = 'button';
        moveLeft.textContent = '←';
        moveLeft.style.cssText = 'flex:1; border:none; border-radius:0.4rem; background:rgba(0,0,0,0.65); color:#fff; font-size:0.75rem; cursor:pointer;';
        moveLeft.disabled = index === 0;
        moveLeft.onclick = () => {
            if (index === 0) return;
            const arr = Array.from(input.files || []);
            [arr[index - 1], arr[index]] = [arr[index], arr[index - 1]];
            const dt = new DataTransfer();
            arr.forEach(fileItem => dt.items.add(fileItem));
            input.files = dt.files;
            renderGalleryPreview(Array.from(input.files || []), preview, input, label);
        };

        const moveRight = document.createElement('button');
        moveRight.type = 'button';
        moveRight.textContent = '→';
        moveRight.style.cssText = 'flex:1; border:none; border-radius:0.4rem; background:rgba(0,0,0,0.65); color:#fff; font-size:0.75rem; cursor:pointer;';
        moveRight.disabled = index === files.length - 1;
        moveRight.onclick = () => {
            if (index === files.length - 1) return;
            const arr = Array.from(input.files || []);
            [arr[index], arr[index + 1]] = [arr[index + 1], arr[index]];
            const dt = new DataTransfer();
            arr.forEach(fileItem => dt.items.add(fileItem));
            input.files = dt.files;
            renderGalleryPreview(Array.from(input.files || []), preview, input, label);
        };

        const remove = document.createElement('button');
        remove.type = 'button';
        remove.textContent = '✕';
        remove.style.cssText = 'flex:1; border:none; border-radius:0.4rem; background:rgba(239,68,68,0.9); color:#fff; font-size:0.7rem; cursor:pointer;';
        remove.onclick = () => {
            const arr = Array.from(input.files || []).filter((_, i) => i !== index);
            const dt = new DataTransfer();
            arr.forEach(fileItem => dt.items.add(fileItem));
            input.files = dt.files;
            renderGalleryPreview(Array.from(input.files || []), preview, input, label);
        };

        controls.appendChild(moveLeft);
        controls.appendChild(moveRight);
        controls.appendChild(remove);
        wrapper.appendChild(controls);
        preview.appendChild(wrapper);
    });
    label.style.display = files.length ? 'none' : 'block';
    const orderInput = document.getElementById('galleryOrder');
    if (orderInput) {
        orderInput.value = JSON.stringify(Array.from(input.files || []).map(file => file.name + '::' + file.size));
    }
}

function handleFile(file, input, label, preview, maxMB) {
    if (file.size > maxMB * 1024 * 1024) {
        alert(`File terlalu besar. Maksimal ${maxMB}MB.`);
        return;
    }
    const dataTransfer = new DataTransfer();
    dataTransfer.items.add(file);
    input.files = dataTransfer.files;
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
            video.style.width = '100%';
            preview.appendChild(video);
        }
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.textContent = '✕ Hapus File';
        removeBtn.style.cssText = 'display: block; margin: 1rem auto 0; padding: 0.5rem 1rem; background: #ef4444; color: white; border: none; border-radius: 0.375rem; cursor: pointer;';
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
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Ali Attaziri\sumberindofarma\resources\views/admin/news/edit.blade.php ENDPATH**/ ?>