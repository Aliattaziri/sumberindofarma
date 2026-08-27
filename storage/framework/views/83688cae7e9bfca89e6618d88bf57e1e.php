

<?php $__env->startSection('title', 'Apotek Medistra - Produk'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .apotek-hero {
        background: linear-gradient(135deg, #7F1D1D 0%, #991B1B 50%, #B91C1C 100%);
        padding: calc(1rem + var(--navbar-height, 65px)) 0 3rem;
        margin-top: calc(-1 * var(--navbar-height, 65px));
        color: #fff;
        border-radius: 0 0 28px 28px;
    }

    .apotek-hero h1 {
        font-size: clamp(1.9rem, 3.3vw, 2.7rem);
        font-weight: 800;
        margin-bottom: .75rem;
    }

    .apotek-hero p {
        color: rgba(255,255,255,0.9);
        max-width: 760px;
        line-height: 1.8;
        margin-bottom: 0;
    }

    .apotek-badge {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        background: rgba(255,255,255,0.16);
        color: #fff;
        padding: .55rem .95rem;
        border-radius: 999px;
        font-weight: 700;
        font-size: .85rem;
        margin-bottom: 1rem;
    }

    .apotek-main {
        padding: 2rem 0 4rem;
        background: #fffaf9;
    }

    .apotek-panel {
        background: #fff;
        border: 1px solid #f2d8d8;
        border-radius: 20px;
        padding: 1.2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        margin-bottom: 1.25rem;
    }

    .filter-row {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr auto;
        gap: .75rem;
        align-items: end;
    }

    .filter-group label {
        display: block;
        font-size: .78rem;
        font-weight: 700;
        color: #374151;
        margin-bottom: .35rem;
    }

    .filter-group input,
    .filter-group select {
        width: 100%;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: .7rem .8rem;
        font-size: .9rem;
        background: #fff;
    }

    .btn-filter,
    .btn-reset {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .4rem;
        padding: .75rem 1rem;
        border-radius: 10px;
        font-weight: 700;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .btn-filter {
        background: #ef4444;
        color: #fff;
    }

    .btn-reset {
        background: #fef2f2;
        color: #991B1B;
    }

    .result-info {
        color: #6b7280;
        font-size: .9rem;
        margin-bottom: .9rem;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 1rem;
    }
    .pagination-wrap { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-top: 1rem; }
    .pagination-wrap .info { color: #6b7280; font-size: 0.875rem; }
    .pagination-btns { display: flex; gap: 0.35rem; align-items: center; flex-wrap: wrap; }
    .page-btn {
        padding: 0.4rem 0.75rem; border-radius: 0.4rem; background: white;
        color: #374151; font-size: 0.875rem; text-decoration: none;
        border: 1px solid #e5e7eb; min-width: 36px; text-align: center; transition: all 0.2s;
    }
    .page-btn:hover { background: #B91C1C; color: white; border-color: #B91C1C; }
    .page-btn.active { background: #B91C1C; color: white; border-color: #B91C1C; font-weight: 700; }
    .page-btn.disabled { background: #f3f4f6; color: #d1d5db; cursor: not-allowed; pointer-events: none; }

    .product-card {
        background: #fff;
        border: 1px solid #f2d8d8;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0,0,0,0.04);
        display: flex;
        flex-direction: column;
    }

    .product-card img {
        width: 100%;
        height: 160px;
        object-fit: cover;
        background: #fef2f2;
    }

    .product-body {
        padding: 1rem;
        display: flex;
        flex-direction: column;
        gap: .5rem;
    }

    .product-tag {
        display: inline-block;
        width: fit-content;
        padding: .25rem .6rem;
        border-radius: 999px;
        background: #fef2f2;
        color: #991B1B;
        font-size: .72rem;
        font-weight: 700;
    }

    .product-name {
        font-size: .95rem;
        font-weight: 700;
        color: #1f2937;
        line-height: 1.35;
    }

    .product-price {
        font-size: 1rem;
        font-weight: 800;
        color: #B91C1C;
    }

    .stock-badge {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        width: fit-content;
        padding: .25rem .6rem;
        border-radius: 999px;
        font-size: .75rem;
        font-weight: 700;
    }

    .stock-ok { background: #fef2f2; color: #065f46; }
    .stock-low { background: #fff7ed; color: #b45309; }
    .stock-out { background: #fef2f2; color: #991B1B; }

    .outlet-info {
        background: #fff7ed;
        border: 1px solid #fde3c0;
        border-radius: 16px;
        padding: 1rem 1.2rem;
        margin-top: 1rem;
        color: #92400e;
        max-width: 720px;
    }

    .outlet-info p {
        margin: 0.35rem 0;
        font-size: 0.94rem;
        line-height: 1.5;
    }

    .outlet-info strong {
        color: #b45309;
    }

    .product-btn {
        margin-top: auto;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .4rem;
        padding: .7rem .9rem;
        background: #ef4444;
        color: #fff;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 700;
        font-size: .88rem;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
        background: #fff;
        border: 1px solid #f2d8d8;
        border-radius: 16px;
        color: #6b7280;
    }

    @media (max-width: 1200px) {
        .product-grid { grid-template-columns: repeat(4, 1fr); }
    }

    @media (max-width: 768px) {
        .filter-row { grid-template-columns: 1fr; }
        .product-grid { grid-template-columns: repeat(3, 1fr); }
    }

    @media (max-width: 480px) {
        .product-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="apotek-hero">
    <div class="container">
        <div class="apotek-badge"><i class="fa-solid fa-store"></i> <?php echo e($displayPerusahaan ?: 'Apotek Medistra'); ?></div>
        <h1>Katalog Produk <?php echo e($displayPerusahaan ?: 'Apotek Medistra'); ?></h1>
        <p>Temukan berbagai produk obat, suplemen, dan kebutuhan kesehatan yang tersedia untuk kebutuhan apotek dan pelanggan Anda.</p>
    </div>
</section>

<section class="apotek-main">
    <div class="container">
        <div class="apotek-panel">
            <form method="GET" action="<?php echo e(route('products.apotek')); ?>" class="filter-row" style="grid-template-columns: 2fr 1fr 1fr 1fr auto;">
                <div class="filter-group">
                    <label><i class="fa-solid fa-magnifying-glass"></i> Cari produk</label>
                    <input type="text" name="search" value="<?php echo e($search); ?>" placeholder="Nama produk, merk, atau deskripsi">
                </div>
                <div class="filter-group">
                    <label><i class="fa-solid fa-tag"></i> Kategori</label>
                    <select name="kategori_produk">
                        <option value="">Semua Kategori</option>
                        <?php $__currentLoopData = $kategoriOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($k); ?>" <?php if(($kategori_produk ?? '') === $k): echo 'selected'; endif; ?>><?php echo e($k); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="filter-group">
                    <label><i class="fa-solid fa-building"></i> Merk/Brand</label>
                    <select name="perusahaan">
                        <option value="">Semua Merk/Brand</option>
                        <?php $__currentLoopData = $perusahaanList ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($p); ?>" <?php if(($perusahaan ?? '') === $p): echo 'selected'; endif; ?>><?php echo e($p); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="filter-group">
                    <label><i class="fa-solid fa-arrow-up-wide-short"></i> Urutkan</label>
                    <select name="sort">
                        <option value="terbaru" <?php if($sort === 'terbaru'): echo 'selected'; endif; ?>>Terbaru</option>
                        <option value="harga_asc" <?php if($sort === 'harga_asc'): echo 'selected'; endif; ?>>Harga Terendah</option>
                        <option value="harga_desc" <?php if($sort === 'harga_desc'): echo 'selected'; endif; ?>>Harga Tertinggi</option>
                        <option value="nama" <?php if($sort === 'nama'): echo 'selected'; endif; ?>>Nama A-Z</option>
                    </select>
                </div>
                <div class="filter-group">
                    <button type="submit" class="btn-filter"><i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                </div>
            </form>
        </div>

        <div class="result-info">
            Menampilkan <?php echo e($medicines->firstItem() ?? 0); ?>-<?php echo e($medicines->lastItem() ?? 0); ?> dari <?php echo e($medicines->total()); ?> produk.
        </div>

        <?php if($medicines->count() > 0): ?>
            <div class="product-grid">
                <?php $__currentLoopData = $medicines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $medicine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="product-card">
                        <?php if($medicine->gambar): ?>
                            <img src="<?php echo e(url('storage/' . $medicine->gambar)); ?>" alt="<?php echo e($medicine->nama_obat); ?>">
                        <?php else: ?>
                            <div style="display:flex;align-items:center;justify-content:center;width:100%;height:100%;min-height:184px;background:linear-gradient(135deg,#fef2f2,#fee2e2);color:#b91c1c;">
                                <i class="fa-solid fa-pills" style="font-size:2.5rem;"></i>
                            </div>
                        <?php endif; ?>
                        <div class="product-body">
                            <span class="product-tag"><?php echo e($medicine->kategori_produk ?: 'OBAT'); ?></span>
                            <h3 class="product-name"><?php echo e($medicine->nama_obat); ?></h3>
                            <div style="font-size:0.72rem;color:#6b7280;font-weight:600;line-height:1.4;margin-bottom:0.45rem;">
                                <?php echo e($medicine->pabrik_label); ?>

                            </div>
                            <a href="<?php echo e(route('medicines.show', $medicine->id)); ?>" class="product-btn"><i class="fa-solid fa-eye"></i> Lihat Detail</a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Pagination Navigation -->
            <?php if($medicines->hasPages()): ?>
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
            <?php endif; ?>
        <?php else: ?>
            <div class="empty-state">
                <i class="fa-solid fa-box-open" style="font-size:2.2rem; margin-bottom:.8rem;"></i>
                <h3 style="margin:0 0 .4rem; color:#1f2937;">Belum ada produk yang cocok</h3>
                <p>Coba ubah kata kunci atau filter pencarian.</p>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Ali Attaziri\sumberindofarma\resources\views\products_apotek.blade.php ENDPATH**/ ?>