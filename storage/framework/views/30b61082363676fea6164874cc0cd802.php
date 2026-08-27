<?php $__env->startSection('title', 'Produk - Sumberindo Farma Tama'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .products-header {
        background: linear-gradient(135deg, #7F1D1D 0%, #991B1B 50%, #B91C1C 100%);
        padding: calc(1rem + var(--navbar-height, 65px)) 0 3rem;
        position: relative;
        overflow: hidden;
    }
    .products-header::before {
        content: '';
        position: absolute;
        top: -80px; right: -80px;
        width: 350px; height: 350px;
        background: radial-gradient(circle, rgba(220,38,38,0.18) 0%, transparent 70%);
        border-radius: 50%;
    }
    .products-header .header-deco-icon {
        position: absolute;
        color: rgba(255,255,255,0.08);
        pointer-events: none;
        animation: headerIconFloat 6s ease-in-out infinite;
    }
    .products-header .header-deco-icon-1 { bottom: 10px; right: 12%; font-size: 4rem; animation-delay: 0s; }
    .products-header .header-deco-icon-2 { top: 15px;   right: 28%; font-size: 3rem; animation-delay: 2s; }
    .products-header .header-deco-icon-3 { bottom: 20px; right: 40%; font-size: 2.5rem; animation-delay: 4s; }
    @keyframes headerIconFloat {
        0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.08; }
        50%       { transform: translateY(-12px) rotate(8deg); opacity: 0.14; }
    }
    .products-header h1 {
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 800; color: white;
        margin-bottom: 0.5rem; position: relative;
    }
    .products-header p { color: rgba(255,255,255,0.8); font-size: 1rem; position: relative; }
    .breadcrumb-custom { display: flex; gap: 0.5rem; align-items: center; margin-bottom: 1rem; position: relative; }
    .breadcrumb-custom a { color: rgba(255,255,255,0.7); text-decoration: none; font-size: 0.9rem; }
    .breadcrumb-custom a:hover { color: white; }
    .breadcrumb-custom span { color: rgba(255,255,255,0.5); font-size: 0.9rem; }
    .breadcrumb-custom .current { color: #a5d65a; font-size: 0.9rem; font-weight: 600; }

    .products-main { background: transparent; padding: 2.5rem 0 5rem; min-height: 60vh; }

    .filter-bar {
        background: white; border-radius: 16px; padding: 1.25rem 1.5rem;
        margin-bottom: 2rem; box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        border: 1px solid #e5e7eb; display: flex; gap: 0.75rem;
        flex-wrap: wrap; align-items: flex-end;
    }
    .filter-group { flex: 1; min-width: 160px; }
    .filter-label { display: block; font-weight: 600; font-size: 0.8rem; color: #374151; margin-bottom: 0.35rem; }
    .filter-input, .filter-select {
        width: 100%; padding: 0.6rem 0.9rem; border: 1.5px solid #e5e7eb;
        border-radius: 10px; font-size: 0.9rem; color: #374151;
        background: #f9fafb; transition: all 0.2s; outline: none;
    }
    .filter-input:focus, .filter-select:focus {
        border-color: #B91C1C; background: white;
        box-shadow: 0 0 0 3px rgba(220,38,38,0.1);
    }
    .btn-filter {
        padding: 0.6rem 1.4rem; background: linear-gradient(135deg, #B91C1C, #991B1B);
        color: white; border: none; border-radius: 10px; cursor: pointer;
        font-weight: 600; font-size: 0.9rem; transition: all 0.3s; white-space: nowrap;
    }
    .btn-filter:hover { background: linear-gradient(135deg, #991B1B, #7F1D1D); transform: translateY(-2px); }
    .btn-reset {
        padding: 0.6rem 1rem; background: white; color: #6b7280;
        border: 1.5px solid #e5e7eb; border-radius: 10px; cursor: pointer;
        font-weight: 600; font-size: 0.9rem; text-decoration: none; white-space: nowrap; transition: all 0.2s;
    }
    .btn-reset:hover { border-color: #ef4444; color: #ef4444; }

    .result-info { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 0.5rem; }
    .result-info p { color: #6b7280; font-size: 0.875rem; margin: 0; }

    .medicines-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 1.5rem; margin-bottom: 2.5rem;
    }
    .medicine-card {
        background: white; border-radius: 16px; overflow: hidden;
        border: 1px solid #e5e7eb; transition: all 0.3s;
        display: flex; flex-direction: column;
    }
    .medicine-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 35px rgba(220,38,38,0.12);
        border-color: #fecaca;
    }
    .medicine-image {
        width: 100%; height: 180px;
        background: linear-gradient(135deg, #fef2f2, #fee2e2);
        display: flex; align-items: center; justify-content: center;
        font-size: 3rem; overflow: hidden;
    }
    .medicine-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s; }
    .medicine-card:hover .medicine-image img { transform: scale(1.05); }
    .medicine-body { padding: 1.1rem; flex: 1; display: flex; flex-direction: column; }
    .medicine-desc { color: #374151; font-size: 0.9rem; margin: 0 0 0.6rem; line-height: 1.35; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    .medicine-meta { font-size: 0.78rem; color: #6b7280; margin-bottom: 0.45rem; }
    .medicine-company {
        display: inline-block; background: #fef2f2; color: #991B1B;
        padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.72rem;
        font-weight: 700; margin-bottom: 0.5rem; letter-spacing: 0.3px;
    }
    .medicine-name {
        font-size: 0.95rem; font-weight: 700; margin-bottom: 0.5rem; color: #1f2937;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
        overflow: hidden; line-height: 1.4; flex: 1;
    }
    .medicine-price { font-size: 1.15rem; font-weight: 800; color: #B91C1C; margin-bottom: 0.5rem; }
    .stock-badge { display: inline-block; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600; margin-bottom: 0.85rem; }
    .stock-available { background: #fee2e2; color: #065f46; }
    .stock-low       { background: #fee2e2; color: #B91C1C; }
    .stock-out       { background: #fee2e2; color: #7f1d1d; }
    .medicine-btn {
        display: block; width: 100%; padding: 0.65rem;
        background: linear-gradient(135deg, #B91C1C, #991B1B);
        color: white; border: none; border-radius: 10px; cursor: pointer;
        font-weight: 700; font-size: 0.875rem; text-align: center;
        text-decoration: none; transition: all 0.3s;
    }
    .medicine-btn:hover {
        background: linear-gradient(135deg, #991B1B, #7F1D1D);
        transform: translateY(-2px); color: white;
        box-shadow: 0 4px 12px rgba(220,38,38,0.18);
    }

    .empty-state { text-align: center; padding: 5rem 2rem; background: white; border-radius: 16px; border: 1px solid #e5e7eb; }
    .empty-state h3 { font-size: 1.4rem; font-weight: 700; color: #1f2937; margin: 1rem 0 0.5rem; }
    .empty-state p  { color: #6b7280; }

    .pagination-wrap { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-top: 1rem; }
    .pagination-wrap .info { color: #6b7280; font-size: 0.875rem; }
    .pagination-btns { display: flex; gap: 0.35rem; align-items: center; }
    .page-btn {
        padding: 0.4rem 0.75rem; border-radius: 0.4rem; background: white;
        color: #374151; font-size: 0.875rem; text-decoration: none;
        border: 1px solid #e5e7eb; min-width: 36px; text-align: center; transition: all 0.2s;
    }
    .page-btn:hover  { background: #B91C1C; color: white; border-color: #B91C1C; }
    .page-btn.active { background: #B91C1C; color: white; border-color: #B91C1C; font-weight: 700; }
    .page-btn.disabled { background: #f3f4f6; color: #d1d5db; cursor: not-allowed; pointer-events: none; }

    @media (max-width: 1200px) {
        .medicines-grid { grid-template-columns: repeat(4, 1fr); }
    }

    @media (max-width: 768px) {
        .filter-bar { flex-direction: column; padding: 1rem; gap: 0.75rem; }
        .filter-group { width: 100%; min-width: unset; }
        .filter-bar > div:last-child { width: 100%; display: flex; gap: 0.5rem; }
        .btn-filter, .btn-reset { flex: 1; text-align: center; }
        .medicines-grid { grid-template-columns: repeat(3, 1fr); gap: 0.85rem; }
    }

    @media (max-width: 480px) {
        .medicines-grid { grid-template-columns: repeat(2, 1fr); gap: 0.65rem; }
        .medicine-image { height: 120px; }
        .medicine-body { padding: 0.65rem; }
        .medicine-name { font-size: 0.82rem; }
        .medicine-price { font-size: 0.9rem; }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="products-header">
    <div class="container">
        <div class="breadcrumb-custom">
            <a href="<?php echo e(route('home')); ?>"><i class="fa-solid fa-house"></i> Home</a>
            <span>/</span>
            <span class="current">Produk</span>
        </div>
        <h1><i class="fa-solid fa-pills"></i> Produk</h1>
        <p><?php echo e($total); ?> produk tersedia dari berbagai perusahaan farmasi terpercaya</p>
    </div>
    <i class="fa-solid fa-pills header-deco-icon header-deco-icon-1"></i>
    <i class="fa-solid fa-prescription-bottle-medical header-deco-icon header-deco-icon-2"></i>
    <i class="fa-solid fa-stethoscope header-deco-icon header-deco-icon-3"></i>
</div>

<div class="products-main">
    <div class="container">

        <form method="GET" action="<?php echo e(route('prescriptions')); ?>" class="filter-bar">
            <div class="filter-group" style="flex: 2; min-width: 200px;">
                <label class="filter-label"><i class="fa-solid fa-magnifying-glass"></i> Cari Produk</label>
                <input type="text" name="search" class="filter-input"
                       placeholder="Nama obat atau deskripsi..."
                       value="<?php echo e($search); ?>">
            </div>
            <div class="filter-group">
                <label class="filter-label"><i class="fa-solid fa-building"></i> Merk/Brand</label>
                <select name="perusahaan" class="filter-select">
                    <option value="">Semua Merk/Brand</option>
                    <?php $__currentLoopData = $perusahaans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($p); ?>" <?php if($perusahaan === $p): echo 'selected'; endif; ?>><?php echo e($p); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label"><i class="fa-solid fa-arrow-up-wide-short"></i> Urutkan</label>
                <select name="sort" class="filter-select">
                    <option value="terbaru"    <?php if($sort === 'terbaru'): echo 'selected'; endif; ?>>Terbaru</option>
                    <option value="harga_asc"  <?php if($sort === 'harga_asc'): echo 'selected'; endif; ?>>Harga Terendah</option>
                    <option value="harga_desc" <?php if($sort === 'harga_desc'): echo 'selected'; endif; ?>>Harga Tertinggi</option>
                    <option value="nama"       <?php if($sort === 'nama'): echo 'selected'; endif; ?>>Nama A-Z</option>
                </select>
            </div>
            <div style="display: flex; gap: 0.5rem; align-items: flex-end;">
                <button type="submit" class="btn-filter">
                    <i class="fa-solid fa-magnifying-glass"></i> Cari
                </button>
                <?php if($search || $perusahaan || $sort !== 'terbaru'): ?>
                    <a href="<?php echo e(route('prescriptions')); ?>" class="btn-reset"><i class="fa-solid fa-xmark"></i> Reset</a>
                <?php endif; ?>
            </div>
        </form>

        <div class="result-info">
            <p>
                Menampilkan <strong><?php echo e($medicines->firstItem() ?? 0); ?>-<?php echo e($medicines->lastItem() ?? 0); ?></strong>
                dari <strong><?php echo e($medicines->total()); ?></strong> produk
                <?php if($search): ?> - "<strong><?php echo e($search); ?></strong>" <?php endif; ?>
                <?php if($perusahaan): ?> - <strong><?php echo e($perusahaan); ?></strong> <?php endif; ?>
            </p>
        </div>

        <?php if($medicines->count() > 0): ?>
            <div class="medicines-grid">
                <?php $__currentLoopData = $medicines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $medicine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="medicine-card">
                        <div class="medicine-image">
                            <?php if($medicine->gambar): ?>
                                <img src="<?php echo e(url('storage/' . $medicine->gambar)); ?>" alt="<?php echo e($medicine->nama_obat); ?>">
                            <?php else: ?>
                                <i class="fa-solid fa-pills" style="color:#fecaca;font-size:3rem;"></i>
                            <?php endif; ?>
                        </div>
                        <div class="medicine-body">
                            <h3 class="medicine-name"><?php echo e($medicine->nama_obat); ?></h3>
                            
                            <div style="font-size:0.72rem;color:#6b7280;font-weight:600;line-height:1.4;margin-bottom:0.5rem;">
                                <?php echo e($medicine->pabrik_label); ?>

                            </div>
                            <?php if($medicine->sediaan_label): ?>
                                <div class="medicine-meta" style="display:flex;align-items:center;gap:0.35rem;margin-bottom:0.6rem;">
                                    <i class="fa-solid fa-cube"></i> <span>Sediaan: <?php echo e($medicine->sediaan_label); ?></span>
                                </div>
                            <?php endif; ?>
                            <a href="<?php echo e(route('medicines.show', $medicine->id)); ?>" class="medicine-btn">
                                Lihat Detail <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="pagination-wrap">
                <p class="info">Halaman <?php echo e($medicines->currentPage()); ?> dari <?php echo e($medicines->lastPage()); ?></p>
                <div class="pagination-btns">
                    <?php if($medicines->onFirstPage()): ?>
                        <span class="page-btn disabled"><i class="fa-solid fa-chevron-left"></i></span>
                    <?php else: ?>
                        <a href="<?php echo e($medicines->previousPageUrl()); ?>" class="page-btn"><i class="fa-solid fa-chevron-left"></i></a>
                    <?php endif; ?>

                    <?php $__currentLoopData = $medicines->getUrlRange(1, $medicines->lastPage()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $medicines->currentPage()): ?>
                            <span class="page-btn active"><?php echo e($page); ?></span>
                        <?php elseif($page == 1 || $page == $medicines->lastPage() || abs($page - $medicines->currentPage()) <= 2): ?>
                            <a href="<?php echo e($url); ?>" class="page-btn"><?php echo e($page); ?></a>
                        <?php elseif(abs($page - $medicines->currentPage()) == 3): ?>
                            <span class="page-btn disabled">...</span>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php if($medicines->hasMorePages()): ?>
                        <a href="<?php echo e($medicines->nextPageUrl()); ?>" class="page-btn"><i class="fa-solid fa-chevron-right"></i></a>
                    <?php else: ?>
                        <span class="page-btn disabled"><i class="fa-solid fa-chevron-right"></i></span>
                    <?php endif; ?>
                </div>
            </div>

        <?php else: ?>
            <div class="empty-state">
                <i class="fa-solid fa-box-open" style="font-size:3.5rem;color:#d1d5db;"></i>
                <h3>Produk tidak ditemukan</h3>
                <p>
                    <?php if($search || $perusahaan): ?>
                        Coba ubah kata kunci atau filter pencarian.
                    <?php else: ?>
                        Belum ada produk tersedia.
                    <?php endif; ?>
                </p>
                <?php if($search || $perusahaan): ?>
                    <a href="<?php echo e(route('prescriptions')); ?>" class="btn-reset" style="display:inline-block;margin-top:1rem;"><i class="fa-solid fa-xmark"></i> Hapus Filter</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php $__env->stopSection(); ?>






<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Ali Attaziri\sumberindofarma\resources\views\prescriptions.blade.php ENDPATH**/ ?>