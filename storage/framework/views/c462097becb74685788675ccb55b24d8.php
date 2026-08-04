<?php $__env->startSection('title', 'Manajemen Produk Promo - Admin Sumberindo Farma Tama'); ?>
<?php $__env->startSection('page-title', '🏷️ Manajemen Produk Promo'); ?>

<?php $__env->startSection('content'); ?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
    <div>
        <p style="color: #6b7280;">Total: <strong><?php echo e($news->total()); ?> produk promo</strong>
            <?php if($search || $tipe || $status): ?>
                <span style="color: #B91C1C;"> — hasil pencarian</span>
            <?php endif; ?>
        </p>
    </div>
    <a href="<?php echo e(route('admin.news.create')); ?>" class="btn btn-primary">
        ➕ Tambah Produk Promo
    </a>
</div>


<form method="GET" action="<?php echo e(route('admin.news.index')); ?>"
      style="background: white; padding: 1rem 1.25rem; border-radius: 0.75rem; margin-bottom: 1.5rem; display: flex; gap: 0.75rem; flex-wrap: wrap; align-items: flex-end; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">

    <div style="flex: 1; min-width: 200px;">
        <label style="font-size: 0.8rem; color: #6b7280; display: block; margin-bottom: 0.3rem;">Cari Produk Promo</label>
        <div style="position: relative;">
            <span style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: #9ca3af;">🔍</span>
            <input type="text" name="search" value="<?php echo e($search); ?>"
                   placeholder="Judul atau deskripsi produk promo..."
                   style="width: 100%; padding: 0.5rem 0.75rem 0.5rem 2.25rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.9rem; outline: none;"
                   onfocus="this.style.borderColor='#ef4444'" onblur="this.style.borderColor='#d1d5db'">
        </div>
    </div>

    <div style="min-width: 140px;">
        <label style="font-size: 0.8rem; color: #6b7280; display: block; margin-bottom: 0.3rem;">Tipe</label>
        <select name="tipe"
                style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.9rem; background: white; outline: none;"
                onfocus="this.style.borderColor='#ef4444'" onblur="this.style.borderColor='#d1d5db'">
            <option value="">Semua Tipe</option>
            <option value="diskon"        <?php echo e($tipe === 'diskon'        ? 'selected' : ''); ?>>🏷️ Diskon</option>
            <option value="flash_sale"    <?php echo e($tipe === 'flash_sale'    ? 'selected' : ''); ?>>⚡ Flash Sale</option>
            <option value="bundling"      <?php echo e($tipe === 'bundling'      ? 'selected' : ''); ?>>📦 Bundling</option>
            <option value="promo_spesial" <?php echo e($tipe === 'promo_spesial' ? 'selected' : ''); ?>>🎁 Promo Spesial</option>
        </select>
    </div>

    <div style="min-width: 140px;">
        <label style="font-size: 0.8rem; color: #6b7280; display: block; margin-bottom: 0.3rem;">Status</label>
        <select name="status"
                style="width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.9rem; background: white; outline: none;"
                onfocus="this.style.borderColor='#ef4444'" onblur="this.style.borderColor='#d1d5db'">
            <option value="">Semua Status</option>
            <option value="published" <?php echo e($status === 'published' ? 'selected' : ''); ?>>✓ Dipublikasi</option>
            <option value="draft"     <?php echo e($status === 'draft'     ? 'selected' : ''); ?>>✕ Draft</option>
        </select>
    </div>

    <div style="display: flex; gap: 0.5rem;">
        <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1.25rem;">
            Cari
        </button>
        <?php if($search || $tipe || $status): ?>
            <a href="<?php echo e(route('admin.news.index')); ?>" class="btn btn-secondary" style="padding: 0.5rem 1rem;">
                ✕ Reset
            </a>
        <?php endif; ?>
    </div>
</form>

<?php if($news->count() > 0): ?>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Thumbnail</th>
                    <th>Judul Berita</th>
                    <th>Jenis</th>
                    <th>Status</th>
                    <th>Views</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td style="width: 50px;">
                            <?php if($item->thumbnail): ?>
                                <img src="<?php echo e(url('storage/' . $item->thumbnail)); ?>" 
                                     alt="<?php echo e($item->judul); ?>" 
                                     style="width: 40px; height: 40px; object-fit: cover; border-radius: 0.25rem;">
                            <?php else: ?>
                                <div style="width: 40px; height: 40px; background: #f3f4f6; border-radius: 0.25rem; display: flex; align-items: center; justify-content: center; font-size: 1rem;">
                                    <?php switch($item->tipe):
                                        case ('flash_sale'): ?>
                                            ⚡
                                            <?php break; ?>
                                        <?php case ('bundling'): ?>
                                            📦
                                            <?php break; ?>
                                        <?php case ('promo_spesial'): ?>
                                            🎁
                                            <?php break; ?>
                                        <?php default: ?>
                                            🏷️
                                    <?php endswitch; ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?php echo e(\Str::limit($item->judul, 30)); ?></strong>
                        </td>
                        <td>
                            <?php if($item->tipe === 'diskon'): ?>
                                <span style="background: #fee2e2; color: #B91C1C; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.875rem; font-weight: 600;">🏷️ Diskon</span>
                            <?php elseif($item->tipe === 'flash_sale'): ?>
                                <span style="background: #FCE7F3; color: #9F1239; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.875rem; font-weight: 600;">⚡ Flash Sale</span>
                            <?php elseif($item->tipe === 'bundling'): ?>
                                <span style="background: #E0E7FF; color: #3730A3; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.875rem; font-weight: 600;">📦 Bundling</span>
                            <?php else: ?>
                                <span style="background: #fff5f5; color: #166534; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.875rem; font-weight: 600;">🎁 Promo Spesial</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($item->is_published): ?>
                                <span style="background: #fee2e2; color: #065f46; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.875rem; font-weight: 600;">✓ Dipublikasi</span>
                            <?php else: ?>
                                <span style="background: #fee2e2; color: #7F1D1D; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.875rem; font-weight: 600;">✕ Draft</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?php echo e($item->views); ?></strong>
                        </td>
                        <td><?php echo e($item->created_at->format('d M Y')); ?></td>
                        <td style="width: 200px;">
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="<?php echo e(route('admin.news.edit', $item->id)); ?>" class="btn btn-secondary btn-sm">
                                    ✏️ Edit
                                </a>
                                <form action="<?php echo e(route('admin.news.destroy', $item->id)); ?>" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="margin-top: 1.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
        <div style="color: #6b7280; font-size: 0.875rem;">
            Menampilkan <?php echo e($news->firstItem()); ?>–<?php echo e($news->lastItem()); ?> dari <?php echo e($news->total()); ?> produk promo
        </div>
        <div style="display: flex; gap: 0.35rem; align-items: center;">
            <?php if($news->onFirstPage()): ?>
                <span style="padding: 0.4rem 0.75rem; border-radius: 0.4rem; background: #f3f4f6; color: #d1d5db; font-size: 0.875rem; cursor: not-allowed;">‹</span>
            <?php else: ?>
                <a href="<?php echo e($news->previousPageUrl()); ?>" style="padding: 0.4rem 0.75rem; border-radius: 0.4rem; background: white; color: #374151; font-size: 0.875rem; text-decoration: none; border: 1px solid #e5e7eb;" onmouseover="this.style.background='#B91C1C';this.style.color='white'" onmouseout="this.style.background='white';this.style.color='#374151'">‹</a>
            <?php endif; ?>

            <?php $__currentLoopData = $news->getUrlRange(1, $news->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($page == $news->currentPage()): ?>
                    <span style="padding: 0.4rem 0.75rem; border-radius: 0.4rem; background: #B91C1C; color: white; font-size: 0.875rem; font-weight: 600; min-width: 36px; text-align: center;"><?php echo e($page); ?></span>
                <?php else: ?>
                    <a href="<?php echo e($url); ?>" style="padding: 0.4rem 0.75rem; border-radius: 0.4rem; background: white; color: #374151; font-size: 0.875rem; text-decoration: none; border: 1px solid #e5e7eb; min-width: 36px; text-align: center;" onmouseover="this.style.background='#B91C1C';this.style.color='white'" onmouseout="this.style.background='white';this.style.color='#374151'"><?php echo e($page); ?></a>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if($news->hasMorePages()): ?>
                <a href="<?php echo e($news->nextPageUrl()); ?>" style="padding: 0.4rem 0.75rem; border-radius: 0.4rem; background: white; color: #374151; font-size: 0.875rem; text-decoration: none; border: 1px solid #e5e7eb;" onmouseover="this.style.background='#B91C1C';this.style.color='white'" onmouseout="this.style.background='white';this.style.color='#374151'">›</a>
            <?php else: ?>
                <span style="padding: 0.4rem 0.75rem; border-radius: 0.4rem; background: #f3f4f6; color: #d1d5db; font-size: 0.875rem; cursor: not-allowed;">›</span>
            <?php endif; ?>
        </div>
    </div>
<?php else: ?>
    <div style="background: white; padding: 3rem; border-radius: 0.75rem; text-align: center; color: #6b7280;">
        <?php if($search || $tipe || $status): ?>
            <div style="font-size: 2rem; margin-bottom: 1rem;">🔍</div>
            <p>Tidak ada produk promo yang cocok dengan filter yang dipilih.</p>
            <a href="<?php echo e(route('admin.news.index')); ?>" class="btn btn-secondary" style="margin-top: 1rem;">
                ✕ Hapus Filter
            </a>
        <?php else: ?>
            <div style="font-size: 2rem; margin-bottom: 1rem;">📭</div>
            <p>Belum ada produk promo.</p>
            <a href="<?php echo e(route('admin.news.create')); ?>" class="btn btn-primary" style="margin-top: 1rem;">
                ➕ Tambah Produk Promo Pertama
            </a>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>





<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Ali Attaziri\sumberindofarma\resources\views\admin\news\index.blade.php ENDPATH**/ ?>