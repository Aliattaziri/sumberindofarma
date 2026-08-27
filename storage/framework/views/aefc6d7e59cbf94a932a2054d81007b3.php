

<?php $__env->startSection('title', 'Manajemen Principal Logos - Admin'); ?>

<?php $__env->startSection('content'); ?>
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;gap:0.75rem;">
        <h3>Principal Logos</h3>
        <div style="display:flex;gap:0.5rem;">
            <a href="<?php echo e(route('partners')); ?>" target="_blank" class="btn btn-outline">Lihat di Mitra Kami</a>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-error"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <div style="margin-bottom:1rem;display:flex;align-items:center;gap:1rem;">
        <form action="<?php echo e(route('admin.principals.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <label class="form-lbl">Unggah logo principal (max 2MB)</label>
            <input type="file" name="image" accept="image/*" required>
            <button class="btn btn-primary" style="margin-left:0.5rem;">Unggah</button>
        </form>
        <small style="color:#6b7280;">Setelah diunggah, logo akan otomatis tampil di halaman <strong>Mitra Kami</strong>.</small>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:1rem;">
        <?php $__empty_1 = true; $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div style="border:1px solid #e5e7eb;padding:0.6rem;border-radius:8px;text-align:center;">
                <img src="<?php echo e(asset('storage/principellogos/' . $f)); ?>" alt="<?php echo e($f); ?>" style="max-width:100%;height:100px;object-fit:contain;margin-bottom:0.5rem;">
                <div style="display:flex;justify-content:center;gap:0.5rem;">
                    <form action="<?php echo e(route('admin.principals.destroy', $f)); ?>" method="POST" onsubmit="return confirm('Hapus logo ini?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty-state">
                <h3>Belum ada logo principal</h3>
                <p>Unggah logo melalui form di atas untuk menampilkannya di halaman utama PBF.</p>
            </div>
        <?php endif; ?>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Ali Attaziri\sumberindofarma\resources\views\admin\principals\index.blade.php ENDPATH**/ ?>