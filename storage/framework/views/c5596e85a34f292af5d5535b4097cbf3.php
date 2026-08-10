<?php
    $storeName = $storeName ?? 'Toko';
    $storeDescription = $storeDescription ?? 'Katalog produk khusus toko ini.';
    $badgeText = $badgeText ?? 'Outlet';
    $accentColor = $accentColor ?? '#991b1b';
    $accentSoft = $accentSoft ?? '#fef2f2';
    $routeName = $routeName ?? 'products.apotek';
    $routeSlug = $routeSlug ?? Str::slug($storeName);
    $storeAddress = $storeAddress ?? 'Kalimantan Barat';
    $storePhone = $storePhone ?? '';
    $storeWa = $storeWa ?? '6285248965590';
?>



<?php $__env->startSection('title', $storeName . ' - Produk'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .store-shell {
        padding: 0 0 3rem;
        background: linear-gradient(135deg, #f8fafc 0%, #fdf2f8 100%);
        min-height: 100vh;
    }
    .page-offset {
        padding-top: 0 !important;
    }
    .store-hero {
        background: linear-gradient(135deg, <?php echo e($accentColor); ?> 0%, <?php echo e($accentColor); ?>cc 100%);
        color: white;
        border-radius: 24px;
        padding: 2rem;
        box-shadow: 0 20px 50px rgba(0,0,0,0.12);
        margin-bottom: 1.25rem;
    }
    .store-badge {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .45rem .8rem;
        border-radius: 999px;
        background: rgba(255,255,255,.16);
        font-size: .78rem;
        font-weight: 700;
        margin-bottom: .8rem;
    }
    .store-hero h1 { font-size: clamp(1.6rem, 2.4vw, 2.3rem); font-weight: 800; margin-bottom: .45rem; }
    .store-hero p { margin: 0; max-width: 760px; color: rgba(255,255,255,.92); line-height: 1.7; }
    .store-meta { margin-top: 1rem; display: flex; flex-wrap: wrap; gap: .7rem; }
    .store-meta .chip { background: rgba(255,255,255,.16); padding: .45rem .7rem; border-radius: 999px; font-size: .8rem; }
    .filter-card, .product-card, .empty-state { border: 1px solid #e5e7eb; background: white; border-radius: 16px; box-shadow: 0 10px 24px rgba(15,23,42,.05); }
    .filter-card { padding: 1rem; margin-bottom: 1rem; }
    .filter-row { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: .75rem; align-items: end; }
    .filter-group label { display: block; font-size: .76rem; font-weight: 700; color: #374151; margin-bottom: .38rem; }
    .filter-group input, .filter-group select { width: 100%; border: 1px solid #e5e7eb; border-radius: 10px; padding: .7rem .8rem; background: #fff; }
    .btn-filter, .btn-reset { border: none; border-radius: 10px; padding: .72rem 1rem; font-weight: 700; cursor: pointer; text-decoration: none; display: inline-flex; justify-content: center; align-items: center; gap: .35rem; }
    .btn-filter { background: <?php echo e($accentColor); ?>; color: white; }
    .btn-reset { background: <?php echo e($accentSoft); ?>; color: <?php echo e($accentColor); ?>; }
    .result-info { color: #64748b; font-size: .9rem; margin-bottom: .85rem; }
    .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px,1fr)); gap: 1rem; }
    .product-card { overflow: hidden; display: flex; flex-direction: column; }
    .product-card img { width: 100%; height: 160px; object-fit: cover; background: #f8fafc; }
    .product-body { padding: 1rem; display: flex; flex-direction: column; gap: .5rem; }
    .product-tag { display: inline-flex; width: fit-content; padding: .25rem .6rem; border-radius: 999px; background: <?php echo e($accentSoft); ?>; color: <?php echo e($accentColor); ?>; font-size: .72rem; font-weight: 700; }
    .product-name { font-size: .95rem; font-weight: 700; color: #111827; line-height: 1.35; }
    .product-price { font-size: 1rem; font-weight: 800; color: <?php echo e($accentColor); ?>; }
    .stock-badge { display: inline-flex; width: fit-content; padding: .25rem .6rem; border-radius: 999px; font-size: .75rem; font-weight: 700; }
    .stock-ok { background: #ecfdf5; color: #065f46; }
    .stock-low { background: #fffbeb; color: #b45309; }
    .stock-out { background: #fef2f2; color: #991b1b; }
    .product-btn, .btn-cart { display: inline-flex; justify-content: center; align-items: center; gap: .35rem; padding: .7rem .9rem; border-radius: 10px; text-decoration: none; font-weight: 700; font-size: .88rem; margin-top: auto; }
    .product-btn { background: <?php echo e($accentColor); ?>; color: white; }
    .btn-cart { background: white; border: 1px solid <?php echo e($accentColor); ?>; color: <?php echo e($accentColor); ?>; }
    .empty-state { padding: 2rem; text-align: center; color: #6b7280; }
    @media (max-width: 768px) { .filter-row { grid-template-columns: 1fr; } .product-grid { grid-template-columns: repeat(2,1fr); } }
    @media (max-width: 480px) { .product-grid { grid-template-columns: 1fr; } .store-hero { padding: 1.4rem; } }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="store-shell">
    <div class="container">
        <div class="store-hero">
            <div class="store-badge"><i class="fa-solid fa-store"></i> <?php echo e($badgeText); ?></div>
            <h1><?php echo e($storeName); ?></h1>
            <p><?php echo e($storeDescription); ?></p>
            <div class="store-meta">
                <span class="chip"><i class="fa-solid fa-box-open"></i> <?php echo e($total ?? 0); ?> Produk</span>
                <span class="chip"><i class="fa-solid fa-location-dot"></i> <?php echo e($storeAddress); ?></span>
            </div>
        </div>

        <div class="filter-card">
            <form method="GET" action="<?php echo e(route($routeName, ['slug' => $routeSlug])); ?>" class="filter-row">
                <div class="filter-group">
                    <label><i class="fa-solid fa-magnifying-glass"></i> Cari Produk</label>
                    <input type="text" name="search" value="<?php echo e($search ?? ''); ?>" placeholder="Nama produk atau deskripsi">
                </div>
                <div class="filter-group">
                    <label><i class="fa-solid fa-tag"></i> Kategori</label>
                    <select name="kategori_produk">
                        <option value="">Semua Kategori</option>
                        <?php $__currentLoopData = $kategoriOptions ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($k); ?>" <?php if(($kategori_produk ?? '') === $k): echo 'selected'; endif; ?>><?php echo e($k); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="filter-group">
                    <label><i class="fa-solid fa-building"></i> Perusahaan</label>
                    <select name="perusahaan">
                        <option value="">Semua Perusahaan</option>
                        <?php $__currentLoopData = $perusahaanList ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($p); ?>" <?php if(($perusahaan ?? '') === $p): echo 'selected'; endif; ?>><?php echo e($p); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="filter-group">
                    <label><i class="fa-solid fa-arrow-up-wide-short"></i> Urutkan</label>
                    <select name="sort">
                        <option value="terbaru" <?php if(($sort ?? 'terbaru') === 'terbaru'): echo 'selected'; endif; ?>>Terbaru</option>
                        <option value="harga_asc" <?php if(($sort ?? 'terbaru') === 'harga_asc'): echo 'selected'; endif; ?>>Harga Terendah</option>
                        <option value="harga_desc" <?php if(($sort ?? 'terbaru') === 'harga_desc'): echo 'selected'; endif; ?>>Harga Tertinggi</option>
                        <option value="nama" <?php if(($sort ?? 'terbaru') === 'nama'): echo 'selected'; endif; ?>>Nama A-Z</option>
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

        <?php if(($medicines ?? collect())->count() > 0): ?>
            <div class="product-grid">
                <?php $__currentLoopData = $medicines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $medicine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="product-card">
                        <?php if($medicine->gambar): ?>
                            <img src="<?php echo e(url('storage/' . $medicine->gambar)); ?>" alt="<?php echo e($medicine->nama_obat); ?>">
                        <?php else: ?>
                            <img src="<?php echo e(asset('page1.jpeg')); ?>" alt="<?php echo e($medicine->nama_obat); ?>">
                        <?php endif; ?>
                        <div class="product-body">
                            <span class="product-tag"><?php echo e($medicine->kategori_produk ?: 'OBAT'); ?></span>
                            <h3 class="product-name"><?php echo e($medicine->nama_obat); ?></h3>
                            <div class="product-price"><?php echo e($medicine->getFormattedPrice()); ?></div>
                            <?php if($medicine->stok > 10): ?>
                                <span class="stock-badge stock-ok"><i class="fa-solid fa-circle-check"></i> Stok tersedia</span>
                            <?php elseif($medicine->stok > 0): ?>
                                <span class="stock-badge stock-low"><i class="fa-solid fa-triangle-exclamation"></i> Stok terbatas</span>
                            <?php else: ?>
                                <span class="stock-badge stock-out"><i class="fa-solid fa-circle-xmark"></i> Stok habis</span>
                            <?php endif; ?>
                            <a href="<?php echo e(route('medicines.show', $medicine->id)); ?>" class="product-btn"><i class="fa-solid fa-eye"></i> Lihat Detail</a>
                            <?php if($medicine->stok > 0): ?>
                                <button type="button" class="btn-cart" onclick="addToCart(<?php echo e($medicine->id); ?>, '<?php echo e(addslashes($medicine->nama_obat)); ?>', <?php echo e($medicine->harga); ?>, '<?php echo e($medicine->gambar ? url('storage/'.$medicine->gambar) : ''); ?>', '<?php echo e(addslashes($medicine->brand ?: $medicine->kategori)); ?>', this)"><i class="fa-solid fa-cart-plus"></i> Tambah</button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fa-solid fa-box-open" style="font-size:2rem; margin-bottom:.7rem;"></i>
                <h3 style="margin:0 0 .3rem; color:#111827;">Belum ada produk yang cocok</h3>
                <p>Coba ubah kata kunci atau filter pencarian.</p>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
<?php
    $cartScope = 'store_' . preg_replace('/[^a-z0-9]+/', '_', strtolower($routeSlug ?? ($storeName ?? 'default')));
?>
window.cartSettings = Object.assign({}, window.cartSettings || {}, {
    storageKey: <?php echo json_encode(auth()->check()
        ? 'sumberindofarmatama_cart_user_' . auth()->user()->id . '_' . $cartScope
        : 'sumberindofarmatama_cart_' . $cartScope, 15, 512) ?>,
    receiptStoreName: '<?php echo e(addslashes($storeName)); ?>',
    receiptStoreAddress: '<?php echo e(addslashes($storeAddress)); ?>',
    receiptStorePhone: '<?php echo e($storePhone); ?>',
    wa: '<?php echo e($storeWa); ?>'
});
</script>
<?php echo $__env->make('partials.cart_store', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Ali Attaziri\sumberindofarma\resources\views/partials/store_catalog.blade.php ENDPATH**/ ?>