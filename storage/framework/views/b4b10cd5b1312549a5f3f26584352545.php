

<?php $__env->startSection('title', 'Manajemen Berita - Admin Sumberindo Farma Tama'); ?>
<?php $__env->startSection('page-title', '📰 Manajemen Berita'); ?>

<?php $__env->startSection('content'); ?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <div>
        <p style="color: #6b7280;">Total: <strong><?php echo e($news->total()); ?> berita</strong>
            <?php if($search || $tipe || $status): ?>
                <span style="color: #B91C1C;"> — hasil pencarian</span>
            <?php endif; ?>
        </p>
    </div>
    <a href="<?php echo e(route('admin.news.create')); ?>" class="btn btn-primary">
        ➕ Tambah Berita Baru
    </a>
</div>


<form method="GET" action="<?php echo e(route('admin.news.index')); ?>" style="background: white; padding: 1rem 1.25rem; border-radius: 0.75rem; margin-bottom: 1.5rem; display: flex; gap: 0.75rem; flex-wrap: wrap; align-items: flex-end; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">
    <div style="flex: 1; min-width: 200px;">
        <label style="font-size: 0.8rem; color: #6b7280; display: block; margin-bottom: 0.3rem;">Cari Berita</label>
        <div style="position: relative;">
            <span style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: #9ca3af;">🔍</span>
            <input type="text" name="search" value="<?php echo e($search); ?>" placeholder="Judul atau deskripsi berita..." style="width: 100%; padding: 0.5rem 0.75rem 0.5rem 2.25rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.9rem; outline: none;" onfocus="this.style.borderColor='#ef4444'" onblur="this.style.borderColor='#d1d5db'">
        </div>
    </div>
    <div style="min-width: 140px;">
        <label style="font-size: 0.8rem; color: #6b7280; display: block; margin-bottom: 0.3rem;">Jenis</label>
        <select name="tipe" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.9rem; background: white; outline: none;" onfocus="this.style.borderColor='#ef4444'" onblur="this.style.borderColor='#d1d5db'">
            <option value="">Semua Jenis</option>
            <option value="artikel" <?php echo e($tipe === 'artikel' ? 'selected' : ''); ?>>📄 Artikel</option>
            <option value="video" <?php echo e($tipe === 'video' ? 'selected' : ''); ?>>🎥 Video</option>
            <option value="galeri" <?php echo e($tipe === 'galeri' ? 'selected' : ''); ?>>📸 Galeri</option>
        </select>
    </div>
    <div style="min-width: 140px;">
        <label style="font-size: 0.8rem; color: #6b7280; display: block; margin-bottom: 0.3rem;">Status</label>
        <select name="status" style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.9rem; background: white; outline: none;" onfocus="this.style.borderColor='#ef4444'" onblur="this.style.borderColor='#d1d5db'">
            <option value="">Semua Status</option>
            <option value="published" <?php echo e($status === 'published' ? 'selected' : ''); ?>>✓ Dipublikasi</option>
            <option value="draft" <?php echo e($status === 'draft' ? 'selected' : ''); ?>>✕ Draft</option>
        </select>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1.25rem;">Cari</button>
        <?php if($search || $tipe || $status): ?>
            <a href="<?php echo e(route('admin.news.index')); ?>" class="btn btn-secondary" style="padding: 0.5rem 1rem;">✕ Reset</a>
        <?php endif; ?>
    </div>
</form>

<?php if($news->count() > 0): ?>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Deskripsi</th>
                    <th>Status</th>
                    <th>Dilihat</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td style="width: 60px;">
                            <?php
                                $previewMedia = $item->thumbnail ?: ($item->file ?: (is_array($item->gallery) && !empty($item->gallery) ? $item->gallery[0] : null));
                            ?>
                            <?php if($previewMedia): ?>
                                <img src="<?php echo e(asset('storage/' . $previewMedia)); ?>" alt="Preview berita" style="width: 44px; height: 44px; object-fit: cover; border-radius: 0.35rem; border: 1px solid #e5e7eb; background: #f9fafb;">
                            <?php else: ?>
                                <div style="width: 44px; height: 44px; background: #f3f4f6; border-radius: 0.35rem; display: flex; align-items: center; justify-content: center; font-size: 1rem; border: 1px solid #e5e7eb;">
                                    <?php switch($item->tipe):
                                        case ('video'): ?> 🎥 <?php break; ?>
                                        <?php case ('galeri'): ?> 📸 <?php break; ?>
                                        <?php default: ?> 📄
                                    <?php endswitch; ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="font-size: 0.92rem; color: #374151; line-height: 1.5;"><?php echo e(Str::limit($item->deskripsi, 120)); ?></div>
                        </td>
                        <td>
                            <?php if($item->is_published): ?>
                                <span style="background: #d1fae5; color: #065f46; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; white-space: nowrap;">✓ Dipublikasi</span>
                            <?php else: ?>
                                <span style="background: #e5e7eb; color: #374151; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; white-space: nowrap;">✕ Draft</span>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: center;"><?php echo e($item->views); ?></td>
                        <td style="font-size: 0.875rem; color: #6b7280;"><?php echo e($item->created_at->format('d M Y')); ?></td>
                        <td style="white-space: nowrap;">
                            <a href="<?php echo e(route('admin.news.edit', $item->id)); ?>" class="btn btn-sm" style="padding: 0.375rem 0.75rem; margin-right: 0.5rem; background: #3b82f6; color: white; text-decoration: none; border-radius: 0.375rem; font-size: 0.875rem;">✏️ Edit</a>
                            <form action="<?php echo e(route('admin.news.destroy', $item->id)); ?>" method="POST" style="display: inline;">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm" style="padding: 0.375rem 0.75rem; background: #ef4444; color: white; border: none; border-radius: 0.375rem; font-size: 0.875rem; cursor: pointer;" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">🗑️ Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    
    <div style="margin-top: 2rem; display: flex; justify-content: center;">
        <?php echo e($news->links()); ?>

    </div>
<?php else: ?>
    <div style="background: white; padding: 3rem; border-radius: 0.75rem; text-align: center;">
        <div style="font-size: 3rem; margin-bottom: 1rem;">📰</div>
        <p style="color: #6b7280; margin: 0;">Belum ada berita. <a href="<?php echo e(route('admin.news.create')); ?>" style="color: #ef4444; font-weight: 600; text-decoration: none;">Buat berita baru</a></p>
    </div>
<?php endif; ?>

<style>
    .table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-radius: 0.75rem; overflow: hidden; }
    .table th { background: #f3f4f6; padding: 1rem; text-align: left; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb; }
    .table td { padding: 1rem; border-bottom: 1px solid #e5e7eb; }
    .table tbody tr:hover { background: #f9fafb; }
    .table-container { overflow-x: auto; }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Ali Attaziri\sumberindofarma\resources\views/admin/news/index.blade.php ENDPATH**/ ?>