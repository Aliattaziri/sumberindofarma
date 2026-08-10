

<?php $__env->startSection('title', 'Pilih Outlet Apotek Alfa Group'); ?>

<?php $__env->startSection('styles'); ?>
<style>
.select-hero {
    background: linear-gradient(135deg, #b45309 0%, #d97706 50%, #f59e0b 100%);
    padding: calc(1rem + var(--navbar-height, 65px)) 0 3rem;
    margin-top: calc(-1 * var(--navbar-height, 65px));
    color: #fff;
    border-radius: 0 0 28px 28px;
    text-align: center;
}
.select-hero h1 {
    font-size: clamp(1.6rem, 3vw, 2.4rem);
    font-weight: 800;
    margin-bottom: .5rem;
}
.select-hero p {
    color: rgba(255,255,255,0.9);
    font-size: 1rem;
    margin: 0;
}
.select-hero .hero-badge {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    background: rgba(255,255,255,0.2);
    border: 1px solid rgba(255,255,255,0.35);
    border-radius: 50px;
    padding: .35rem 1rem;
    font-size: .8rem;
    font-weight: 700;
    letter-spacing: .5px;
    text-transform: uppercase;
    margin-bottom: 1rem;
}

.outlets-section {
    padding: 3rem 0 4rem;
    background: #f8fafc;
}
.outlets-section .sec-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: .35rem;
}
.outlets-section .sec-sub {
    color: #64748b;
    font-size: .93rem;
    margin-bottom: 2rem;
}

.outlets-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 1.25rem;
}
.outlet-card {
    background: #fff;
    border: 1.5px solid #e2e8f0;
    border-radius: 16px;
    padding: 1.4rem 1.5rem;
    display: flex;
    flex-direction: column;
    gap: .75rem;
    text-decoration: none;
    color: inherit;
    transition: box-shadow .2s, border-color .2s, transform .15s;
    position: relative;
    overflow: hidden;
}
.outlet-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg, #d97706, #f59e0b);
    border-radius: 16px 16px 0 0;
    opacity: 0;
    transition: opacity .2s;
}
.outlet-card:hover {
    box-shadow: 0 8px 30px rgba(0,0,0,0.10);
    border-color: #f59e0b;
    transform: translateY(-3px);
    text-decoration: none;
    color: inherit;
}
.outlet-card:hover::before { opacity: 1; }

.outlet-icon {
    width: 44px; height: 44px;
    background: #fffbeb;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    color: #d97706;
    font-size: 1.15rem;
    flex-shrink: 0;
}
.outlet-name {
    font-size: 1rem;
    font-weight: 700;
    color: #1e293b;
    line-height: 1.3;
}
.outlet-address {
    font-size: .82rem;
    color: #64748b;
    line-height: 1.5;
    display: flex;
    align-items: flex-start;
    gap: .4rem;
}
.outlet-address i { margin-top: 2px; color: #94a3b8; flex-shrink: 0; }
.outlet-cta {
    margin-top: auto;
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    font-size: .82rem;
    font-weight: 600;
    color: #d97706;
}
.outlet-card:hover .outlet-cta { gap: .65rem; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<section class="select-hero">
    <div class="container">
        <div class="hero-badge">
            <i class="fa-solid fa-store"></i> Apotek Alfa Group
        </div>
        <h1>Pilih Outlet</h1>
        <p>Kunjungi katalog produk outlet Apotek Alfa Group di berbagai lokasi.</p>
    </div>
</section>


<section class="outlets-section">
    <div class="container">
        <p class="sec-title"><?php echo e(count($outlets)); ?> Outlet Tersedia</p>
        <p class="sec-sub">Klik outlet untuk melihat katalog produk di lokasi tersebut.</p>

        <div class="outlets-grid">
            <?php $__currentLoopData = $outlets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $outlet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('products.apotek', ['outlet' => $outlet['name']])); ?>" class="outlet-card">
                <div class="outlet-icon">
                    <i class="fa-solid fa-store"></i>
                </div>
                <div>
                    <div class="outlet-name"><?php echo e($outlet['name']); ?></div>
                    <div class="outlet-address">
                        <i class="fa-solid fa-location-dot"></i>
                        <span><?php echo e($outlet['address']); ?></span>
                    </div>
                </div>
                <div class="outlet-cta">
                    Lihat Katalog <i class="fa-solid fa-arrow-right"></i>
                </div>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Ali Attaziri\sumberindofarma\resources\views/apotek_select.blade.php ENDPATH**/ ?>