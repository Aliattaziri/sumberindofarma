

<?php $__env->startSection('title', 'Principle Logo - Admin'); ?>
<?php $__env->startSection('page-title', 'Principle Logo'); ?>

<?php $__env->startSection('styles'); ?>
<style>
  .list-card { background:white; border-radius:8px; padding:1rem; border:1px solid #eef2f7; }
  .logo-img { width:96px; height:56px; object-fit:contain; border:1px solid #f3f4f6; background:#fff; }
  .row { display:flex; gap:1rem; align-items:center; padding:0.6rem 0; border-bottom:1px solid #f5f7fa; }
  .row:last-child { border-bottom:none; }
  .actions a, .actions form { display:inline-block; margin-left:0.5rem; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;">
  <div>
    <h2 style="margin:0;">Principle Logo</h2>
    <div style="color:#6b7280;font-size:0.9rem;">Total: <strong><?php echo e($medicines->total()); ?></strong></div>
  </div>
  <div>
    <a href="<?php echo e(route('admin.produk.create')); ?>" class="btn btn-primary">Tambah Logo</a>
  </div>
</div>

<div class="list-card">
  <?php $__empty_1 = true; $__currentLoopData = $medicines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <div class="row">
      <div style="width:100px;flex:0 0 100px;">
        <?php if($m->gambar): ?>
          <img src="<?php echo e(url('storage/' . $m->gambar)); ?>" alt="<?php echo e($m->nama_obat); ?>" class="logo-img">
        <?php else: ?>
          <div class="logo-img" style="display:flex;align-items:center;justify-content:center;color:#9ca3af;">No image</div>
        <?php endif; ?>
      </div>
      <div style="flex:1;">
        <div style="font-weight:700;color:#111827;"><?php echo e($m->nama_obat); ?></div>
        <div style="color:#6b7280;font-size:0.9rem;">Link: <?php if($m->brand): ?><a href="<?php echo e($m->brand); ?>" target="_blank"><?php echo e($m->brand); ?></a><?php else: ?> - <?php endif; ?></div>
      </div>
      <div style="width:200px;text-align:right;" class="actions">
        <a href="<?php echo e(route('admin.produk.edit', $m->id)); ?>" class="btn btn-sm btn-secondary">Edit</a>
        <form action="<?php echo e(route('admin.produk.destroy', $m->id)); ?>" method="POST" style="display:inline-block;">
          <?php echo csrf_field(); ?>
          <?php echo method_field('DELETE'); ?>
          <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus logo ini?')">Hapus</button>
        </form>
      </div>
    </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div style="padding:1rem;text-align:center;color:#6b7280;">Belum ada principle logo. Tambah menggunakan tombol di atas.</div>
  <?php endif; ?>

  <div style="margin-top:0.75rem;">
    <?php echo e($medicines->links()); ?>

  </div>
</div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Ali Attaziri\sumberindofarma\resources\views\admin\produk\index.blade.php ENDPATH**/ ?>