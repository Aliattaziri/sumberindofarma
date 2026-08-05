<?php $__env->startSection('title', 'Promo Produk - Admin Sumberindo Farma Tama'); ?>
<?php $__env->startSection('page-title', '🏷️ Promo Produk'); ?>

<?php $__env->startSection('styles'); ?>
<style>
.page-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; gap:1rem; flex-wrap:wrap; }
.page-header h2 { font-size:1.1rem; font-weight:700; color:#1f2937; margin:0 0 0.2rem; }
.page-header p  { font-size:0.85rem; color:#6b7280; margin:0; }
.btn-add { display:inline-flex; align-items:center; gap:0.4rem; padding:0.6rem 1.25rem; background:#B91C1C; color:#fff; border-radius:0.5rem; font-size:0.875rem; font-weight:600; text-decoration:none; transition:all 0.2s; }
.btn-add:hover { background:#991B1B; color:#fff; transform:translateY(-1px); }

.promo-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:1.25rem; }
.promo-card { background:#fff; border-radius:1rem; overflow:hidden; border:1px solid #e5e7eb; box-shadow:0 1px 4px rgba(0,0,0,0.06); transition:box-shadow 0.2s; }
.promo-card:hover { box-shadow:0 4px 16px rgba(0,0,0,0.1); }
.promo-img-wrap { width:100%; aspect-ratio:1/1; overflow:hidden; background:#fef2f2; position:relative; }
.promo-img { width:100%; height:100%; object-fit:cover; display:block; }
.promo-body { padding:0.85rem; }
.promo-title { font-size:0.88rem; font-weight:700; color:#1f2937; margin:0 0 0.2rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.promo-sub   { font-size:0.76rem; color:#6b7280; margin:0 0 0.5rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.promo-meta  { display:flex; align-items:center; gap:0.4rem; flex-wrap:wrap; margin-bottom:0.75rem; }
.badge-aktif   { padding:0.18rem 0.55rem; border-radius:20px; font-size:0.7rem; font-weight:700; background:#fee2e2; color:#065f46; }
.badge-nonaktif{ padding:0.18rem 0.55rem; border-radius:20px; font-size:0.7rem; font-weight:700; background:#fee2e2; color:#991b1b; }
.badge-urutan  { padding:0.18rem 0.55rem; border-radius:20px; font-size:0.7rem; font-weight:600; background:#fef2f2; color:#991B1B; }
.promo-actions { display:flex; gap:0.4rem; align-items:center; flex-wrap:wrap; }
.btn-edit { display:inline-flex; align-items:center; gap:0.25rem; padding:0.35rem 0.7rem; background:#fef2f2; color:#991B1B; border-radius:0.4rem; font-size:0.75rem; font-weight:600; text-decoration:none; transition:all 0.2s; border:none; cursor:pointer; }
.btn-edit:hover { background:#B91C1C; color:#fff; }
.btn-del  { display:inline-flex; align-items:center; gap:0.25rem; padding:0.35rem 0.7rem; background:#fee2e2; color:#991b1b; border-radius:0.4rem; font-size:0.75rem; font-weight:600; border:none; cursor:pointer; transition:all 0.2s; }
.btn-del:hover  { background:#ef4444; color:#fff; }
.btn-toggle { display:inline-flex; align-items:center; gap:0.25rem; padding:0.35rem 0.7rem; border-radius:0.4rem; font-size:0.75rem; font-weight:600; border:none; cursor:pointer; transition:all 0.2s; }
.btn-toggle-on  { background:#fee2e2; color:#B91C1C; }
.btn-toggle-on:hover  { background:#ef4444; color:#fff; }
.btn-toggle-off { background:#fee2e2; color:#065f46; }
.btn-toggle-off:hover { background:#ef4444; color:#fff; }

.empty-state { text-align:center; padding:4rem 2rem; background:#fff; border-radius:1rem; border:1px solid #e5e7eb; }
.empty-state i { font-size:3rem; color:#d1d5db; display:block; margin-bottom:1rem; }

.modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center; }
.modal-overlay.show { display:flex; }
.modal-box { background:#fff; border-radius:1rem; padding:2rem; max-width:360px; width:90%; box-shadow:0 20px 60px rgba(0,0,0,0.2); text-align:center; }
.modal-box h3 { font-size:1rem; font-weight:700; margin:0 0 0.5rem; }
.modal-box p  { font-size:0.875rem; color:#6b7280; margin:0 0 1.5rem; }
.modal-actions { display:flex; gap:0.6rem; justify-content:center; }
.btn-cancel { padding:0.6rem 1.5rem; background:#fff; color:#374151; border:1.5px solid #e5e7eb; border-radius:0.5rem; font-size:0.875rem; font-weight:600; cursor:pointer; }
.btn-danger { padding:0.6rem 1.5rem; background:#ef4444; color:#fff; border:none; border-radius:0.5rem; font-size:0.875rem; font-weight:600; cursor:pointer; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="page-header">
    <div>
        <h2>Kelola Promo Produk</h2>
        <p>Foto promo ditampilkan sebagai grid 1:1 kecil di halaman utama website</p>
    </div>
    <a href="<?php echo e(route('admin.promo-products.create')); ?>" class="btn-add">
        <i class="fa-solid fa-plus"></i> Tambah Promo
    </a>
</div>

<?php if(session('success')): ?>
<div style="background:#fee2e2;color:#065f46;padding:0.85rem 1.25rem;border-radius:0.5rem;margin-bottom:1.25rem;font-size:0.875rem;font-weight:600;">
    <i class="fa-solid fa-circle-check"></i> <?php echo e(session('success')); ?>

</div>
<?php endif; ?>
<?php if(session('warning')): ?>
<div style="background:#fee2e2;color:#B91C1C;padding:0.85rem 1.25rem;border-radius:0.5rem;margin-bottom:1.25rem;font-size:0.875rem;font-weight:600;">
    <i class="fa-solid fa-triangle-exclamation"></i> <?php echo e(session('warning')); ?>

</div>
<?php endif; ?>

<?php if($promos->count()): ?>
<div class="promo-grid">
    <?php $__currentLoopData = $promos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="promo-card">
        <div class="promo-img-wrap">
            <img src="<?php echo e(url('storage/'.$promo->gambar)); ?>" alt="<?php echo e($promo->judul); ?>" class="promo-img">
        </div>
        <div class="promo-body">
            <h3 class="promo-title"><?php echo e($promo->judul); ?></h3>
            <?php if($promo->subjudul): ?><p class="promo-sub"><?php echo e($promo->subjudul); ?></p><?php endif; ?>
            <div class="promo-meta">
                <span class="<?php echo e($promo->aktif ? 'badge-aktif' : 'badge-nonaktif'); ?>">
                    <?php echo e($promo->aktif ? '● Aktif' : '○ Nonaktif'); ?>

                </span>
                <span class="badge-urutan">#<?php echo e($promo->urutan); ?></span>
            </div>
            <div class="promo-actions">
                <a href="<?php echo e(route('admin.promo-products.edit', $promo)); ?>" class="btn-edit">
                    <i class="fa-solid fa-pen"></i> Edit
                </a>
                <button class="btn-toggle <?php echo e($promo->aktif ? 'btn-toggle-on' : 'btn-toggle-off'); ?>"
                    onclick="togglePromo(<?php echo e($promo->id); ?>, this)">
                    <i class="fa-solid <?php echo e($promo->aktif ? 'fa-eye-slash' : 'fa-eye'); ?>"></i>
                    <?php echo e($promo->aktif ? 'Off' : 'On'); ?>

                </button>
                <button class="btn-del" onclick="confirmDelete(<?php echo e($promo->id); ?>, '<?php echo e(addslashes($promo->judul)); ?>')">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php else: ?>
<div class="empty-state">
    <i class="fa-solid fa-tag"></i>
    <h3 style="color:#374151;margin-bottom:0.5rem;">Belum ada promo produk</h3>
    <p>Tambahkan foto promo untuk ditampilkan di halaman utama.</p>
    <a href="<?php echo e(route('admin.promo-products.create')); ?>" class="btn-add" style="margin-top:1rem;display:inline-flex;">
        <i class="fa-solid fa-plus"></i> Tambah Promo Pertama
    </a>
</div>
<?php endif; ?>


<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <div style="font-size:2.5rem;margin-bottom:0.75rem;">🗑️</div>
        <h3>Hapus Promo?</h3>
        <p id="deleteMsg">Promo ini akan dihapus permanen.</p>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeModal()">Batal</button>
            <form id="deleteForm" method="POST">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn-danger">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function confirmDelete(id, judul) {
    document.getElementById('deleteMsg').textContent = 'Promo "' + judul + '" akan dihapus permanen.';
    document.getElementById('deleteForm').action = '/admin/promo-products/' + id;
    document.getElementById('deleteModal').classList.add('show');
}
function closeModal() { document.getElementById('deleteModal').classList.remove('show'); }

async function togglePromo(id, btn) {
    const res  = await fetch('/admin/promo-products/' + id + '/toggle', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>', 'Accept': 'application/json' }
    });
    const data = await res.json();
    const aktif = data.aktif;
    btn.className = 'btn-toggle ' + (aktif ? 'btn-toggle-on' : 'btn-toggle-off');
    btn.innerHTML = `<i class="fa-solid ${aktif ? 'fa-eye-slash' : 'fa-eye'}"></i> ${aktif ? 'Off' : 'On'}`;
    const badge = btn.closest('.promo-card').querySelector('.badge-aktif, .badge-nonaktif');
    badge.className = aktif ? 'badge-aktif' : 'badge-nonaktif';
    badge.textContent = aktif ? '● Aktif' : '○ Nonaktif';
}
</script>
<?php $__env->stopSection(); ?>





<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Ali Attaziri\sumberindofarma\resources\views/admin/promo_products/index.blade.php ENDPATH**/ ?>