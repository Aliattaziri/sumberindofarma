<?php $__env->startSection('title', 'PT. Surya Sharone Abadi - Produk PBF'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .products-header {
        background: linear-gradient(135deg, #0047b3 0%, #0f4c81 40%, #fb8c00 100%);
        padding: calc(1rem + var(--navbar-height, 65px)) 0 3rem;
        position: relative;
        overflow: hidden;
        color: white;
    }
    .products-header::before,
    .products-header::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        opacity: 0.35;
    }
    .products-header::before {
        top: -60px; right: -90px;
        width: 320px; height: 320px;
        background: rgba(255, 152, 0, 0.22);
    }
    .products-header::after {
        bottom: -80px; left: -80px;
        width: 260px; height: 260px;
        background: rgba(2, 136, 209, 0.22);
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
    @keyframes headerIconFloatMobile {
        0%, 100% { transform: translate(0, 0) rotate(0deg); opacity: 0.08; }
        25%       { transform: translate(-4px, -8px) rotate(-4deg); opacity: 0.12; }
        50%       { transform: translate(4px, -10px) rotate(6deg); opacity: 0.14; }
        75%       { transform: translate(-2px, -6px) rotate(-2deg); opacity: 0.12; }
    }
    .products-header h1 {
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 800; color: white;
        margin-bottom: 0.5rem; position: relative;
    }
    .products-header p { color: rgba(255,255,255,0.8); font-size: 1rem; position: relative; }
    .breadcrumb-custom { display: flex; gap: 0.4rem; align-items: center; margin-bottom: 0.9rem; position: relative; font-size: 0.88rem; }
    .breadcrumb-custom a { color: rgba(255,255,255,0.85); text-decoration: none; font-size: 0.88rem; transition: color 0.2s; font-weight: 500; }
    .breadcrumb-custom a:hover { color: #ffffff; }
    .breadcrumb-custom span { color: rgba(255,255,255,0.55); font-size: 0.88rem; }
    .breadcrumb-custom .current { color: #ffd79b; font-size: 0.88rem; font-weight: 600; }
    .products-header .hero-panel {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 3rem;
        align-items: flex-start;
        position: relative;
        z-index: 2;
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.22);
        border-radius: 32px;
        padding: 3rem;
        box-shadow: 0 35px 70px rgba(0,0,0,0.18);
        backdrop-filter: blur(16px);
    }
    .products-header .brand-logo {
        max-height: 150px;
        width: auto;
        display: block;
        border-radius: 24px;
        padding: 0.75rem;
        background: rgba(255,255,255,0.96);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        flex-shrink: 0;
        margin-top: 0.5rem;
    }
    .products-header .brand-copy {
        max-width: 100%;
    }
    .products-header .brand-copy h1 { margin-bottom: 0.6rem; line-height: 1.08; letter-spacing: -0.02em; font-size: 2.5rem; font-weight: 800; color: #ffffff; }
    .products-header .brand-copy p { margin: 0 0 0.75rem; color: rgba(255,255,255,0.96); font-size: 1.08rem; line-height: 1.65; font-weight: 400; }
    .products-header .brand-copy .brand-address { margin-top: 0.75rem; margin-bottom: 0.5rem; font-size: 0.93rem; color: rgba(255,255,255,0.85); line-height: 1.55; max-width: 100%; font-weight: 400; }
    .products-header .partner-logos { display: flex; flex-wrap: wrap; align-items: center; gap: 1.5rem; margin-top: -0.8rem; justify-content: flex-start; width: 100%; }
    .products-header .partner-logo-desktop { display: block; max-height: 380px; max-width: 120%; width: auto; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.16)); }
    .products-header .partner-card { display: none; width: 110%; max-width: 280px; background: rgba(255,255,255,0.16); border: 1px solid rgba(255,255,255,0.22); border-radius: 26px; padding: 0.6rem; align-items: center; justify-content: center; box-shadow: 0 18px 40px rgba(0,0,0,0.14); }
    .products-header .partner-card img { max-height: 80px; width: 30%; display: block; filter: drop-shadow(0 14px 32px rgba(0,0,0,0.18)); }
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
        background: linear-gradient(180deg, rgba(3,37,131,0.08) 0%, rgba(251,140,0,0.06) 100%);
        border-radius: 20px; overflow: hidden;
        border: 1px solid rgba(30, 103, 196, 0.18); transition: all 0.3s;
        display: flex; flex-direction: column;
        backdrop-filter: blur(8px);
    }
    .medicine-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 42px rgba(3,37,131,0.16);
        border-color: rgba(251,140,0,0.45);
    }
    .medicine-image {
        width: 100%; height: 180px;
        background: linear-gradient(135deg, rgba(2,118,210,0.18), rgba(251,140,0,0.18));
        display: flex; align-items: center; justify-content: center;
        font-size: 3rem; overflow: hidden;
    }
    .medicine-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s; }
    .medicine-card:hover .medicine-image img { transform: scale(1.05); }
    .medicine-body { padding: 1.1rem; flex: 1; display: flex; flex-direction: column; }
    .medicine-company {
        display: inline-block; background: #fef2f2; color: #991B1B;
        padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.72rem;
        font-weight: 700; margin-bottom: 0.5rem; letter-spacing: 0.3px;
    }
      .medicine-desc { color: #374151; font-size: 0.9rem; margin: 0 0 0.6rem; line-height: 1.35; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
      .medicine-meta { font-size: 0.78rem; color: #6b7280; margin-bottom: 0.45rem; }
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

/* ORDER MODAL */
.modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.55); z-index: 3000; }
.modal-box { display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%,-50%); width: 92%; max-width: 480px; max-height: 90vh; overflow-y: auto; background: #fff; border-radius: 20px; z-index: 3001; box-shadow: 0 25px 60px rgba(0,0,0,0.25); }
.modal-head { background: linear-gradient(135deg,#991B1B,#B91C1C); padding: 1.25rem 1.5rem; border-radius: 20px 20px 0 0; display: flex; justify-content: space-between; align-items: center; }
.modal-head h3 { color: #fff; margin: 0; font-size: 1rem; font-weight: 700; }
.modal-head p { color: rgba(255,255,255,0.8); margin: 0; font-size: 0.75rem; }
.modal-close { background: rgba(255,255,255,0.2); border: none; color: #fff; width: 32px; height: 32px; border-radius: 50%; cursor: pointer; font-size: 1rem; }
.modal-summary { padding: 1rem 1.5rem; background: #f8faff; border-bottom: 1px solid #e5e7eb; font-size: 0.85rem; color: #374151; }
.modal-form { padding: 1.25rem 1.5rem; }
.form-lbl { display: block; font-size: 0.78rem; font-weight: 700; color: #374151; margin-bottom: 0.3rem; }
.form-inp { width: 100%; padding: 0.6rem 0.85rem; border: 1.5px solid #e5e7eb; border-radius: 10px; font-size: 0.9rem; outline: none; transition: border-color 0.2s; margin-bottom: 0.75rem; }
.form-inp:focus { border-color: #B91C1C; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; }
.form-error { display: none; background: #fee2e2; color: #7f1d1d; padding: 0.6rem; border-radius: 8px; font-size: 0.8rem; margin-bottom: 0.75rem; }
.btn-submit-wa { width: 100%; padding: 0.85rem; background: linear-gradient(135deg,#25D366,#1f8f4a); color: #fff; border: none; border-radius: 12px; font-size: 1rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; }



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

    @media (max-width: 768px) {
        .products-header {
            padding: 3rem 0 2.5rem;
        }
        .products-header .hero-panel {
            grid-template-columns: 1fr;
            text-align: center;
            gap: 1.5rem;
            padding: 2rem;
        }
        .products-header .brand-logo {
            margin: 0 auto;
            max-height: 130px;
            width: auto;
        }
        .products-header .brand-copy h1 {
            font-size: 2rem;
            line-height: 1.1;
            margin-bottom: 0.5rem;
        }
        .products-header .brand-copy p {
            font-size: 1rem;
            line-height: 1.6;
        }
        .products-header .brand-copy {
            max-width: none;
        }
        .products-header .partner-logos {
            justify-content: center;
            margin-top: 1.2rem;
        }
        .products-header .partner-card {
            display: flex;
            margin: 0 auto;
            max-width: 280px;
        }
        .products-header .partner-card img {
            max-height: 170px;
            width: auto;
        }
        .products-header .partner-logo-desktop {
            display: none;
        }
        .products-header .header-deco-icon-1,
        .products-header .header-deco-icon-2,
        .products-header .header-deco-icon-3 {
            animation: headerIconFloatMobile 5.5s ease-in-out infinite;
            opacity: 0.08;
        }
        .products-header .header-deco-icon-1 { right: 6%; bottom: 18px; font-size: 3.2rem; }
        .products-header .header-deco-icon-2 { right: 18%; top: 12px; font-size: 2.2rem; }
        .products-header .header-deco-icon-3 { right: 30%; bottom: 14px; font-size: 1.9rem; }
        .products-header h1 { font-size: clamp(1.8rem, 6vw, 2.4rem); }
        .products-header p { font-size: 0.98rem; line-height: 1.6; }
        .filter-bar { flex-direction: column; padding: 1rem; gap: 0.75rem; }
        .filter-group { width: 100%; min-width: unset; }
        .filter-bar > div:last-child { width: 100%; display: flex; gap: 0.5rem; }
        .btn-filter, .btn-reset { flex: 1; text-align: center; }
        .medicines-grid { grid-template-columns: repeat(4, 1fr); gap: 0.85rem; }
    }

    @media (max-width: 1024px) {
        .medicines-grid { grid-template-columns: repeat(3, 1fr); gap: 0.85rem; }
    }

    @media (max-width: 768px) {
        .medicines-grid { grid-template-columns: repeat(2, 1fr); gap: 0.85rem; }
    }

    @media (max-width: 480px) {
        .products-header {
            padding: 2.5rem 0 2rem;
        }
        .products-header .brand-card {
            padding: 0.85rem;
            gap: 0.85rem;
        }
        .products-header .brand-logo {
            max-height: 90px;
        }
        .products-header .brand-copy h1 {
            font-size: 2rem;
        }
        .products-header .brand-copy p {
            font-size: 0.95rem;
        }
        .products-header .partner-chip {
            padding: 0.55rem 0.8rem;
            font-size: 0.85rem;
        }
        .products-header .header-deco-icon-1,
        .products-header .header-deco-icon-2,
        .products-header .header-deco-icon-3 {
            animation: headerIconFloatMobile 6s ease-in-out infinite;
            opacity: 0.06;
        }
        .products-header .header-deco-icon-1 { right: 4%; bottom: 10px; font-size: 2.6rem; }
        .products-header .header-deco-icon-2 { right: 18%; top: 10px; font-size: 1.8rem; }
        .products-header .header-deco-icon-3 { right: 28%; bottom: 8px; font-size: 1.5rem; }
        .medicines-grid { grid-template-columns: repeat(2, 1fr); gap: 0.85rem; }
        .medicine-image { height: 120px; }
        .medicine-body { padding: 0.75rem; }
        .medicine-name { font-size: 0.88rem; }
        .medicine-price { font-size: 1rem; }
        .medicine-btn { font-size: 0.82rem; padding: 0.55rem; }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="products-header">
    <div class="container">
        <div class="hero-panel">
            <img src="<?php echo e(asset('logo pt sumber indo farma tama.png')); ?>" alt="Sumberindo Farma" class="brand-logo" />
            <div class="brand-copy">
                <div class="breadcrumb-custom" style="margin:0 0 0.75rem;">
                    <a href="<?php echo e(route('home')); ?>"><i class="fa-solid fa-house"></i> Home</a>
                    <span>/</span>
                    <span class="current">Apotek & PBF</span>
                </div>
                <h1><i class="fa-solid fa-box"></i> Katalog Produk PBF</h1>
                <p><?php echo e($total); ?> produk PBF tersedia untuk mitra apotek dan distributor.</p>
                <p style="margin-top:0.6rem;">
                    <a href="<?php echo e(route('partners')); ?>" class="btn-hero-outline" style="text-decoration:none;display:inline-block;padding:0.5rem 0.9rem;border-radius:8px;border:1.5px solid rgba(255,255,255,0.18);background:rgba(255,255,255,0.06);color:#fff;font-weight:700;">Lihat Mitra Kami Ini</a>
                </p>
                <p class="brand-address">Komp. Pergudangan Ocean 88 C2-3, Jl. Adisucipto, Arang Limbung, Kec. Sungai Raya, Kab. Kubu Raya, Kalimantan Barat</p>
            </div>
        </div>
    </div>
    <i class="fa-solid fa-pills header-deco-icon header-deco-icon-1"></i>
    <i class="fa-solid fa-capsules header-deco-icon header-deco-icon-2"></i>
    <i class="fa-solid fa-syringe header-deco-icon header-deco-icon-3"></i>
</div>

<div class="products-main">
    <div class="container">

        
        <?php if(session('pbf_success')): ?>
        <div style="background:#fee2e2;border:1px solid #6ee7b7;border-radius:12px;padding:0.85rem 1.25rem;margin-bottom:1.5rem;display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
            <span style="color:#065f46;font-weight:700;font-size:0.9rem;display:flex;align-items:center;gap:0.5rem;">
                <i class="fa-solid fa-circle-check"></i>
                <?php echo e(session('pbf_success')); ?>

            </span>
        </div>
        <?php endif; ?>

        
        <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:12px;padding:0.75rem 1.25rem;margin-bottom:1.5rem;display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
            <span style="color:#B91C1C;font-size:0.85rem;font-weight:600;display:flex;align-items:center;gap:0.5rem;">
                <i class="fa-solid fa-shield-halved" style="color:#ef4444;"></i>
                Anda masuk sebagai mitra PBF terverifikasi
            </span>
            <form method="POST" action="<?php echo e(route('products.pbf.logout')); ?>" style="margin:0;">
                <?php echo csrf_field(); ?>
                <button type="submit" style="background:none;border:1.5px solid #ef4444;color:#B91C1C;padding:0.35rem 0.9rem;border-radius:8px;font-size:0.78rem;font-weight:700;cursor:pointer;transition:all 0.2s;">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar Akses
                </button>
            </form>
        </div>

        
        <?php
            $principalsDir = storage_path('principellogos');
            $principalFiles = [];
            if (is_dir($principalsDir)) {
                foreach (scandir($principalsDir) as $it) {
                    if (in_array($it, ['.', '..'])) continue;
                    $principalFiles[] = $it;
                }
            }
        ?>

        <?php if(count($principalFiles) > 0): ?>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:1.25rem;align-items:center;">
                <?php $__currentLoopData = $principalFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div style="background:white;border-radius:12px;padding:0.8rem;border:1px solid #e6e6e6;display:flex;align-items:center;justify-content:center;min-height:120px;">
                        <img src="<?php echo e(asset('storage/principellogos/' . $pf)); ?>" alt="<?php echo e($pf); ?>" style="max-width:100%;max-height:90px;object-fit:contain;">
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fa-solid fa-building" style="font-size:3.5rem;color:#d1d5db;"></i>
                <h3>Tidak ada logo principal</h3>
                <p>Silakan unggah logo melalui admin → Principal Logos.</p>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php $__env->stopSection(); ?>







<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Ali Attaziri\sumberindofarma\resources\views\products_pbf.blade.php ENDPATH**/ ?>