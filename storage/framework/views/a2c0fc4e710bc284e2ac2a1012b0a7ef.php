
<?php $__env->startSection('title', 'Sumberindo Farma Tama - Distributor Farmasi Terpercaya'); ?>
<?php $__env->startSection('styles'); ?>
<style>
/* ==============================================
   HOME PAGE - Clean GoApotik Style
   ============================================== */
</style>
<style>
</style>
<style>
/* QUICK CATEGORY */
.quick-section { background: #fff; border-bottom: 1px solid #e5e7eb; padding: 0; display: block; }
.quick-row { display: flex; gap: 0.5rem; overflow-x: auto; padding-bottom: 4px; }
.quick-row::-webkit-scrollbar { height: 3px; }
.quick-row::-webkit-scrollbar-thumb { background: #e5e7eb; border-radius: 2px; }
.quick-btn {
    display: flex; flex-direction: column; align-items: center; gap: 0.35rem;
    padding: 0.5rem 1rem; border-radius: 12px; text-decoration: none;
    color: #374151; white-space: nowrap; flex-shrink: 0;
    border: 1.5px solid #e5e7eb; background: #fff; min-width: 75px;
    transition: all 0.2s; font-size: 0;
}
.quick-btn:hover { background: #fef2f2; border-color: #fecaca; color: #991B1B; }
.quick-btn.active { background: linear-gradient(135deg,#B91C1C,#991B1B); border-color: transparent; color: #fff; }
.quick-btn i { font-size: 1.25rem; }
.quick-btn span { font-size: 0.7rem; font-weight: 600; }

/* PROMO CARDS */
.promo-section { 
    padding: 2.5rem 0; 
    background: linear-gradient(135deg, #7F1D1D 0%, #991B1B 50%, #B91C1C 100%);
    width: 100%;
    margin: 0;
    position: relative;
}

.promo-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255,255,255,0.03) 0%, transparent 50%);
    pointer-events: none;
}

.promo-grid { 
    display: grid; 
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); 
    gap: 2rem;
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 1.5rem;
    justify-items: center;
    position: relative;
    z-index: 1;
}

.promo-card {
    border-radius: 24px; 
    padding: 2rem; 
    color: #fff;
    text-decoration: none; 
    display: flex; 
    flex-direction: column;
    align-items: flex-start; 
    justify-content: space-between;
    gap: 1.5rem;
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1); 
    position: relative; 
    overflow: hidden;
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
    min-height: 200px;
    width: 100%;
    max-width: 100%;
    border: 1px solid rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(8px);
}

.promo-card::before {
    content: ''; 
    position: absolute; 
    inset: 0; 
    background: linear-gradient(135deg, rgba(255,255,255,0.08) 0%, transparent 50%, rgba(0,0,0,0.1) 100%); 
    border-radius: 24px;
    pointer-events: none;
}

.promo-card::after {
    content: ''; 
    position: absolute; 
    right: -80px; 
    bottom: -80px;
    width: 220px; 
    height: 220px; 
    background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%); 
    border-radius: 50%;
}

.promo-card:hover { 
    transform: translateY(-12px) scale(1.02);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
    border-color: rgba(255, 255, 255, 0.2);
}

.promo-card-content {
    display: flex;
    align-items: flex-start;
    gap: 1.5rem;
    width: 100%;
    position: relative;
    z-index: 2;
}

.promo-card-icon-wrap {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 80px;
    height: 80px;
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.promo-card-text {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    flex: 1;
    position: relative;
    z-index: 2;
}
.promo-1 { background: linear-gradient(135deg, #991B1B 0%, #B91C1C 100%); }
.promo-2 { background: linear-gradient(135deg, #991B1B 0%, #ef4444 100%); }
.promo-3 { background: linear-gradient(135deg, #6a1b9a 0%, #8e24aa 100%); }

.promo-contact {
    background: linear-gradient(135deg, #991B1B 0%, #B91C1C 100%);
}

.promo-goapotik {
    background: linear-gradient(135deg, #0d47a1 0%, #1565c0 40%, #1e88e5 75%, #42a5f5 100%);
}

.promo-goapotik-logo {
    height: 80px;
    object-fit: contain;
    flex-shrink: 0;
    filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
}

.promo-pbf {
    background: radial-gradient(circle at 20% 25%, rgba(255,255,255,0.14), transparent 25%),
                linear-gradient(135deg, #111111 0%, #1d1d1d 45%, #2f2f2f 100%);
    border: 1px solid rgba(255, 255, 255, 0.12);
}

.promo-pbf-logo {
    height: 80px;
    object-fit: contain;
    flex-shrink: 0;
    filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
}

.pbf-subtitle {
    display: block;
    font-size: 0.75rem;
    font-weight: 600;
    opacity: 0.95;
    line-height: 1.3;
    letter-spacing: 0.3px;
}

.promo-card > i {
    font-size: 4rem;
    opacity: 0.95;
    flex-shrink: 0;
    filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.15));
}

.promo-card h4 {
    font-size: 1.5rem;
    font-weight: 900;
    margin: 0;
    line-height: 1.1;
    color: #fff;
    letter-spacing: -0.5px;
}

.promo-card p {
    font-size: 0.95rem;
    color: rgba(255, 255, 255, 0.92);
    margin: 0;
    font-weight: 500;
    line-height: 1.5;
    opacity: 0.95;
}

/* SECTION HEADER */
.sec-head { display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1.25rem; }
.sec-head-left { display: flex; flex-direction: column; gap: 0.25rem; }
.sec-tag { display: inline-block; background: #fef2f2; color: #991B1B; padding: 0.2rem 0.75rem; border-radius: 50px; font-size: 0.72rem; font-weight: 600; }
.sec-title { font-size: 1.2rem; font-weight: 800; color: #1f2937; margin: 0; }
.sec-link { font-size: 0.82rem; color: #B91C1C; text-decoration: none; font-weight: 600; white-space: nowrap; }
.sec-link:hover { text-decoration: underline; }
</style>
<style>
/* PRODUCT GRID */
.prod-section { padding: 1.5rem 0; }
.prod-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(185px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
.prod-card {
    background: #fff; border-radius: 14px; overflow: hidden;
    border: 1.5px solid #e5e7eb; display: flex; flex-direction: column;
    transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s;
}
.prod-card:hover { transform: translateY(-5px); box-shadow: 0 12px 30px rgba(220,38,38,0.12); border-color: #fecaca; }
.prod-img {
    width: 100%; height: 148px;
    background: linear-gradient(135deg, #fef2f2, #fee2e2);
    display: flex; align-items: center; justify-content: center;
    overflow: hidden; position: relative;
}
.prod-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s; }
.prod-card:hover .prod-img img { transform: scale(1.06); }
.prod-img .no-img-icon { font-size: 2.5rem; color: #fecaca; }
.prod-badge-label {
    position: absolute; top: 8px; left: 8px;
    background: #B91C1C; color: #fff;
    font-size: 0.62rem; font-weight: 700; padding: 0.18rem 0.45rem; border-radius: 6px;
}
.prod-badge-grade-a {
    position: absolute; top: 8px; right: 8px;
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: #fff;
    font-size: 0.62rem; font-weight: 700; padding: 0.2rem 0.5rem;
    border-radius: 6px;
    display: inline-flex; align-items: center; gap: 0.2rem;
    box-shadow: 0 2px 6px rgba(217,119,6,.35);
}
.prod-body { padding: 0.85rem; flex: 1; display: flex; flex-direction: column; }
.prod-brand-tag {
    font-size: 0.66rem; font-weight: 700; color: #991B1B; background: #fef2f2;
    display: inline-block; padding: 0.15rem 0.5rem; border-radius: 20px; margin-bottom: 0.4rem;
}
.prod-name {
    font-size: 0.86rem; font-weight: 700; color: #1f2937; margin-bottom: 0.4rem;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden; line-height: 1.35; flex: 1;
}
  .prod-desc { color: #374151; font-size: 0.86rem; margin: 0 0 0.45rem; line-height: 1.35; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
  .prod-meta { font-size: 0.72rem; color: #6b7280; margin-bottom: 0.35rem; }
.prod-price { font-size: 1rem; font-weight: 800; color: #B91C1C; margin-bottom: 0.35rem; }
.stock-ok  { font-size: 0.65rem; font-weight: 600; color: #065f46; background: #fee2e2; padding: 0.15rem 0.5rem; border-radius: 20px; display: inline-block; margin-bottom: 0.6rem; }
.stock-low { font-size: 0.65rem; font-weight: 600; color: #B91C1C; background: #fee2e2; padding: 0.15rem 0.5rem; border-radius: 20px; display: inline-block; margin-bottom: 0.6rem; }
.stock-out { font-size: 0.65rem; font-weight: 600; color: #7f1d1d; background: #fee2e2; padding: 0.15rem 0.5rem; border-radius: 20px; display: inline-block; margin-bottom: 0.6rem; }
.btn-detail {
    display: block; width: 100%; padding: 0.5rem;
    background: linear-gradient(135deg, #B91C1C, #991B1B); color: #fff;
    border: none; border-radius: 9px; cursor: pointer; font-weight: 700;
    font-size: 0.78rem; text-align: center; text-decoration: none; transition: all 0.25s;
}
.btn-detail:hover { background: linear-gradient(135deg, #991B1B, #7F1D1D); transform: translateY(-1px); color: #fff; }
.btn-cart {
    display: block; width: 100%; padding: 0.42rem;
    background: #fff; color: #B91C1C;
    border: 1.5px solid #B91C1C; border-radius: 9px; cursor: pointer;
    font-weight: 700; font-size: 0.72rem; text-align: center;
    text-decoration: none; transition: all 0.2s; margin-top: 0.4rem;
}
.btn-cart:hover { background: #fef2f2; }
.btn-cart.added { background: #fee2e2; color: #065f46; border-color: #34d399; }
</style>
<style>
/* WHY US */
.why-section { background: #fff; border-top: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb; padding: 1.25rem 0; }
.why-grid { display: flex; justify-content: center; gap: 2.5rem; flex-wrap: wrap; }
.why-item { display: flex; align-items: center; gap: 0.75rem; }
.why-icon { width: 44px; height: 44px; border-radius: 12px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
.why-text h4 { font-size: 0.84rem; font-weight: 700; color: #1f2937; margin: 0 0 0.1rem; }
.why-text p  { font-size: 0.73rem; color: #6b7280; margin: 0; line-height: 1.4; }

/* CTA */
.cta-section { padding: 1.25rem 0; }
.cta-box {
    background: linear-gradient(135deg, #7F1D1D, #B91C1C);
    border-radius: 20px; padding: 2rem 2.5rem;
    display: flex; align-items: center; justify-content: space-between; gap: 1.5rem; flex-wrap: wrap;
}
.cta-box h3 { font-size: 1.25rem; font-weight: 800; color: #fff; margin: 0 0 0.3rem; }
.cta-box p  { color: rgba(255,255,255,0.85); font-size: 0.9rem; margin: 0; }
.btn-wa {
    display: inline-flex; align-items: center; gap: 0.5rem;
    background: #ef4444; color: #fff; padding: 0.75rem 1.75rem;
    border-radius: 50px; text-decoration: none; font-weight: 700; font-size: 0.95rem;
    transition: all 0.25s; white-space: nowrap; flex-shrink: 0;
}
.btn-wa:hover { background: #991B1B; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(37,211,102,0.4); color: #fff; }

/* CATEGORY GRID */
.cat-section { padding: 1.5rem 0 1rem; }
.cat-grid { display: grid; grid-template-columns: repeat(6, 1fr); gap: 0.75rem; }
.cat-card {
    display: flex; flex-direction: column; align-items: center; gap: 0.5rem;
    padding: 1rem 0.5rem; background: #fff; border-radius: 14px;
    border: 1.5px solid #e5e7eb; text-decoration: none; color: #374151;
    transition: all 0.25s; text-align: center;
}
.cat-card:hover { background: #fef2f2; border-color: #fecaca; color: #991B1B; transform: translateY(-3px); box-shadow: 0 6px 18px rgba(220,38,38,0.1); }
.cat-icon { width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.35rem; }
.cat-card > span { font-size: 0.7rem; font-weight: 600; line-height: 1.3; }

/* ABOUT STRIP */
.about-strip { padding: 1rem 0 2.5rem; }
.about-box {
    background: #fff; border-radius: 20px; padding: 1.75rem 2rem;
    border: 1.5px solid #e5e7eb;
    display: flex; align-items: center; gap: 2rem; flex-wrap: wrap;
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
}
.about-logo { height: 72px; object-fit: contain; flex-shrink: 0; }
.about-info { flex: 1; min-width: 200px; }
.about-info h3 { font-size: 1.05rem; font-weight: 800; color: #1f2937; margin: 0 0 0.4rem; }
.about-info p  { font-size: 0.85rem; color: #6b7280; line-height: 1.7; margin: 0 0 0.85rem; }
.btn-about {
    display: inline-flex; align-items: center; gap: 0.4rem;
    background: #fef2f2; color: #991B1B; padding: 0.45rem 1.1rem;
    border-radius: 50px; text-decoration: none; font-weight: 700; font-size: 0.82rem; transition: all 0.2s;
}
.btn-about:hover { background: #991B1B; color: #fff; }
.about-stats { display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.65rem; flex-shrink: 0; }
.about-stat-item { text-align: center; padding: 0.65rem 1rem; background: #f8faff; border-radius: 12px; border: 1px solid #e5e7eb; }
.about-stat-item .n { font-size: 1.3rem; font-weight: 800; color: #B91C1C; display: block; line-height: 1.2; }
.about-stat-item .l { font-size: 0.68rem; color: #6b7280; }
.about-stat-item:nth-child(even) .n { color: #ef4444; }

/* PBF PROFILE + GALLERY TEMPLATE */
.pbf-profile-section {
    padding: 0.2rem 0 3rem;
}
.pbf-profile-wrap {
    background: linear-gradient(165deg, #fffaf9 0%, #fff1f1 58%, #ffe9e9 100%);
    border: 1px solid #ffd9d9;
    border-radius: 24px;
    padding: 1.8rem;
    position: relative;
    overflow: hidden;
}
.pbf-profile-wrap::before {
    content: '';
    position: absolute;
    top: -70px;
    right: -80px;
    width: 220px;
    height: 220px;
    background: radial-gradient(circle, rgba(220, 38, 38, 0.14), transparent 70%);
    pointer-events: none;
}
.pbf-profile-head {
    display: flex;
    gap: 1.25rem;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
    margin-bottom: 1.4rem;
}
.pbf-profile-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: #B91C1C;
    color: #fff;
    border-radius: 999px;
    padding: 0.33rem 0.8rem;
    font-size: 0.73rem;
    font-weight: 700;
    letter-spacing: 0.02em;
    margin-bottom: 0.65rem;
}
.pbf-profile-head h3 {
    margin: 0 0 0.5rem;
    color: #7f1d1d;
    font-size: clamp(1.08rem, 2.5vw, 1.35rem);
    line-height: 1.35;
    font-weight: 900;
}
.pbf-profile-head p {
    margin: 0;
    color: #6b7280;
    font-size: 0.9rem;
    line-height: 1.75;
    max-width: 760px;
}
.pbf-keypoints {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    margin-top: 0.85rem;
}
.pbf-keypoints span {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.3rem 0.7rem;
    border-radius: 999px;
    background: #fff;
    border: 1px solid #ffd4d4;
    color: #991B1B;
    font-size: 0.74rem;
    font-weight: 700;
}
.pbf-gallery-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    grid-auto-flow: dense;
    gap: 1rem;
    align-items: stretch;
}
.pbf-photo-template {
    background: #fff;
    border: 1px solid #f3c9c9;
    border-radius: 16px;
    min-height: 0;
    padding: 0.72rem;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    text-align: left;
    transition: border-color 0.25s ease, transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
}
.pbf-gallery-grid > .pbf-photo-template:not(.pbf-photo-template-featured) {
    min-height: 228px;
    background: linear-gradient(180deg, #ffffff 0%, #fff6f6 100%);
    box-shadow: 0 8px 18px rgba(127, 29, 29, 0.07);
}
.pbf-photo-template:hover {
    border-color: #ef4444;
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(185, 28, 28, 0.14);
    background: #fff;
}
.pbf-photo-template img {
    width: 100%;
    height: 122px;
    object-fit: cover;
    border-radius: 12px;
    border: 1px solid #fee2e2;
    margin-bottom: 0.62rem;
    background: #fff5f5;
}
.pbf-photo-template-featured {
    grid-column: 2 / span 2;
    grid-row: span 2;
    min-height: 420px;
    padding: 0.95rem;
    border: 1px solid #f3a4a4;
    box-shadow: 0 18px 34px rgba(153, 27, 27, 0.14);
    background: linear-gradient(180deg, #ffffff 0%, #fff5f5 100%);
    justify-content: center;
}
.pbf-photo-template-featured h4 {
    width: 100%;
    text-align: center;
    font-size: 1.16rem;
    margin-bottom: 0;
}
.pbf-photo-template-featured img {
    width: 100%;
    height: 330px;
    object-fit: cover;
    object-position: center top;
    border-radius: 12px;
    border: 1px solid #fecaca;
    background: linear-gradient(180deg, #fffafa 0%, #fff1f1 100%);
    padding: 0.2rem;
    margin-bottom: 0.7rem;
}
.pbf-photo-empty {
    width: 100%;
    height: 300px;
    border-radius: 12px;
    border: 1px dashed #ef9f9f;
    background: repeating-linear-gradient(
        -45deg,
        #fff8f8,
        #fff8f8 10px,
        #ffeaea 10px,
        #ffeaea 20px
    );
    margin-bottom: 0.7rem;
    position: relative;
}
.pbf-photo-empty::after {
    content: 'FOTO MENYUSUL';
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    font-size: 0.76rem;
    letter-spacing: 0.12em;
    font-weight: 800;
    color: #be123c;
    background: rgba(255, 255, 255, 0.84);
    border: 1px solid #fecaca;
    border-radius: 999px;
    padding: 0.35rem 0.7rem;
}
.pbf-photo-template h4 {
    margin: 0 0 0.3rem;
    font-size: 0.83rem;
    color: #374151;
    font-weight: 800;
    line-height: 1.35;
}
.pbf-photo-template p {
    margin: 0;
    font-size: 0.72rem;
    color: #94a3b8;
    line-height: 1.5;
}

/* CART DRAWER */
.cart-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.45); z-index: 2000; opacity: 0; pointer-events: none; transition: opacity 0.3s; }
.cart-overlay.open { opacity: 1; pointer-events: all; }
.cart-drawer { position: fixed; top: 0; right: -420px; width: 420px; max-width: 100vw; height: 100vh; background: #fff; z-index: 2001; display: flex; flex-direction: column; box-shadow: -8px 0 40px rgba(0,0,0,0.15); transition: right 0.35s cubic-bezier(.4,0,.2,1); }
.cart-drawer.open { right: 0; }
.cart-head { background: linear-gradient(135deg, #7F1D1D, #B91C1C); padding: 1.25rem 1.5rem; color: #fff; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; }
.cart-head h2 { font-size: 1.1rem; font-weight: 700; margin: 0; display: flex; align-items: center; gap: 0.5rem; }
.cart-close-btn { background: rgba(255,255,255,0.2); border: none; color: #fff; width: 34px; height: 34px; border-radius: 50%; cursor: pointer; font-size: 1rem; display: flex; align-items: center; justify-content: center; transition: background 0.2s; }
.cart-close-btn:hover { background: rgba(255,255,255,0.35); }
.cart-body { flex: 1; overflow-y: auto; padding: 1rem 1.25rem; }
.cart-empty-msg { text-align: center; padding: 3rem 1rem; color: #9ca3af; }
.cart-empty-msg i { font-size: 3rem; display: block; margin-bottom: 0.75rem; }
.cart-item-row { display: flex; gap: 0.75rem; align-items: flex-start; padding: 0.85rem 0; border-bottom: 1px solid #f3f4f6; }
.cart-item-thumb { width: 52px; height: 52px; border-radius: 10px; flex-shrink: 0; background: linear-gradient(135deg,#fef2f2,#fee2e2); display: flex; align-items: center; justify-content: center; overflow: hidden; }
.cart-item-thumb img { width: 100%; height: 100%; object-fit: cover; }
.cart-item-info { flex: 1; min-width: 0; }
.cart-item-name { font-size: 0.84rem; font-weight: 700; color: #1f2937; margin-bottom: 0.2rem; line-height: 1.3; }
.cart-item-price { font-size: 0.8rem; color: #B91C1C; font-weight: 700; }
.cart-qty-row { display: flex; align-items: center; gap: 0.4rem; margin-top: 0.4rem; }
.qty-btn { width: 26px; height: 26px; border-radius: 6px; border: 1.5px solid #e5e7eb; background: #fff; cursor: pointer; font-size: 0.9rem; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #374151; transition: all 0.2s; }
.qty-btn:hover { border-color: #B91C1C; color: #B91C1C; }
.qty-num { font-size: 0.85rem; font-weight: 700; min-width: 20px; text-align: center; }
.cart-item-del { background: none; border: none; color: #d1d5db; cursor: pointer; font-size: 0.9rem; padding: 0.2rem; flex-shrink: 0; transition: color 0.2s; }
.cart-item-del:hover { color: #ef4444; }
.cart-foot { padding: 1.25rem 1.5rem; border-top: 2px solid #f3f4f6; flex-shrink: 0; background: #fafbff; }
.cart-total-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
.cart-total-row span { font-size: 0.9rem; color: #6b7280; }
.cart-total-row strong { font-size: 1.2rem; color: #B91C1C; font-weight: 800; }
.btn-order-wa { display: flex; align-items: center; justify-content: center; gap: 0.6rem; width: 100%; padding: 0.85rem; background: #ef4444; color: #fff; border: none; border-radius: 12px; cursor: pointer; font-weight: 700; font-size: 1rem; transition: all 0.3s; }
.btn-order-wa:hover { background: #991B1B; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(37,211,102,0.4); }
.btn-clear-cart { display: block; width: 100%; padding: 0.5rem; background: none; border: none; color: #9ca3af; font-size: 0.8rem; cursor: pointer; margin-top: 0.5rem; transition: color 0.2s; }
.btn-clear-cart:hover { color: #ef4444; }
</style>
<style>
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
.btn-submit-wa { width: 100%; padding: 0.85rem; background: linear-gradient(135deg,#ef4444,#991B1B); color: #fff; border: none; border-radius: 12px; font-size: 1rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; }

/* RESPONSIVE */
@media (max-width: 992px) {
    .cat-grid { grid-template-columns: repeat(4,1fr); }
    .why-grid { gap: 1.5rem; }
    .hero-img-wrap { display: none; }
    .promo-section { padding: 2.2rem 0; }
    .promo-grid { gap: 1.75rem; }
    .promo-card { min-height: 190px; padding: 1.8rem; }
}
@media (max-width: 768px) {
    .hero { padding: 2rem 0 1.75rem; }
    .promo-grid { grid-template-columns: 1fr 1fr; gap: 1.5rem; }
    .promo-card { padding: 1.75rem 1.5rem; min-height: 180px; }
    .promo-card-icon-wrap { width: 70px; height: 70px; border-radius: 16px; }
    .promo-card > i { font-size: 3rem; }
    .promo-goapotik-logo, .promo-pbf-logo { height: 70px; }
    .promo-card h4 { font-size: 1.2rem; }
    .promo-card p { font-size: 0.9rem; }
    .cat-grid { grid-template-columns: repeat(3,1fr); }
    .prod-grid { grid-template-columns: repeat(2,1fr); }
    .cta-box { flex-direction: column; text-align: center; padding: 1.5rem; }
    .stats-strip-row { flex-wrap: wrap; }
    .stat-cell { min-width: 50%; border-bottom: 1px solid #e5e7eb; }
    .cart-drawer { width: 100%; max-width: 100%; right: -100%; }
    .cart-drawer.open { right: 0; }
    .about-box { flex-direction: column; align-items: flex-start; }
    .about-stats { width: 100%; grid-template-columns: repeat(4,1fr); }
    .pbf-profile-wrap { padding: 1.2rem; border-radius: 18px; }
    .pbf-gallery-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .pbf-photo-template-featured {
        grid-column: 1 / -1;
        grid-row: auto;
        min-height: 320px;
    }
    .pbf-photo-template-featured img { height: 260px; }
    .pbf-photo-empty { height: 220px; }
}
@media (max-width: 480px) {
    .promo-grid { grid-template-columns: 1fr; gap: 0.75rem; padding: 0 0.5rem; }
    .promo-card { padding: 1.5rem 1.25rem; min-height: 160px; }
    .promo-card-icon-wrap { width: 60px; height: 60px; border-radius: 14px; }
    .promo-card > i { font-size: 2.5rem; }
    .promo-goapotik-logo, .promo-pbf-logo { height: 60px; }
    .promo-card h4 { font-size: 1rem; }
    .promo-card p { font-size: 0.85rem; }
    .pbf-subtitle { font-size: 0.7rem; }
    .cat-grid { grid-template-columns: repeat(3,1fr); }
    .prod-grid { grid-template-columns: repeat(2,1fr); }
    .why-grid { flex-direction: column; align-items: center; gap: 1rem; }
    .hero-btns { flex-direction: column; }
    .about-stats { grid-template-columns: repeat(2,1fr); }
    .pbf-gallery-grid { grid-template-columns: 1fr; }
    .pbf-photo-template { min-height: 0; }
    .pbf-photo-template-featured {
        grid-column: auto;
        min-height: 255px;
    }
    .pbf-photo-template-featured img { height: 210px; }
    .pbf-photo-empty { height: 170px; }
    .form-row { grid-template-columns: 1fr; }
    .cart-head { padding: 0.95rem 1rem; }
    .cart-head h2 { font-size: 0.98rem; }
    .cart-close-btn { width: 30px; height: 30px; font-size: 0.9rem; }
    .cart-body { padding: 0.75rem 0.9rem; }
    .cart-item-row { gap: 0.6rem; padding: 0.7rem 0; }
    .cart-item-thumb { width: 44px; height: 44px; }
    .cart-item-name { font-size: 0.78rem; }
    .cart-item-price { font-size: 0.76rem; }
    .qty-btn { width: 24px; height: 24px; font-size: 0.82rem; }
    .qty-num { font-size: 0.8rem; }
    .cart-foot { padding: 0.9rem 1rem; }
    .cart-total-row { margin-bottom: 0.75rem; }
    .cart-total-row strong { font-size: 1rem; }
    .btn-order-wa { padding: 0.8rem; font-size: 0.92rem; border-radius: 10px; }
    .btn-clear-cart { margin-top: 0.35rem; font-size: 0.75rem; }
    .banner-promo-top {
        justify-content: center;
    }
    .banner-promo-item {
        aspect-ratio: 19 / 6;
        min-height: 0;
        width: 100%;
        max-width: 100%;
        margin: 0;
    }
    .banner-promo-copy {
        min-height: 0;
        padding: 0;
        justify-content: flex-end;
        align-items: center;
        text-align: center;
        background: linear-gradient(180deg, rgba(0,0,0,0) 58%, rgba(0,0,0,0.26) 82%, rgba(0,0,0,0.48) 100%);
    }
    .banner-promo-label {
        font-size: 0.72rem;
        padding: 0.28rem 0.75rem;
    }
    .banner-promo-item h2 {
        font-size: 1.1rem;
    }
    .banner-promo-item p {
        font-size: 0.85rem;
        max-width: 100%;
        margin: 0.55rem auto 0;
    }
    .banner-promo-btn {
        margin: 0.95rem auto 0;
    }
}

.banner-promo-top {
    position: relative;
    overflow: hidden;
    width: 100%;
    max-width: 100%;
    margin: 0 auto;
    padding: 0;
}

.banner-promo-track {
    display: flex;
    width: 100%;
    transition: transform 0.55s cubic-bezier(.4, 0, .2, 1);
    will-change: transform;
}

.banner-promo-top, .banner-promo-item {
    margin-top: 0;
    margin-bottom: 0;
}

.banner-promo-item {
    flex: 0 0 100%;
    position: relative;
    overflow: hidden;
    border-radius: 28px;
    display: block;
    color: #fff;
    text-decoration: none;
    background: #111;
    box-shadow: 0 18px 54px rgba(0, 0, 0, 0.16);
    aspect-ratio: 19 / 6;
    min-height: 0;
    height: auto;
}

.banner-promo-bg {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    filter: brightness(0.74);
    transition: transform 0.45s ease;
    object-fit: cover;
}

.banner-promo-item:hover .banner-promo-bg {
    transform: scale(1.04);
}

.banner-volume-toggle {
    position: absolute;
    bottom: 1rem;
    right: 1rem;
    z-index: 3;
    width: 44px;
    height: 44px;
    border-radius: 999px;
    border: none;
    background: rgba(0, 0, 0, 0.55);
    color: #fff;
    font-size: 1.1rem;
    display: grid;
    place-items: center;
    cursor: pointer;
    transition: background 0.2s ease;
}

.banner-volume-toggle:hover {
    background: rgba(0, 0, 0, 0.75);
}

.banner-promo-copy {
    position: absolute;
    inset: 0;
    z-index: 2;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    min-height: 0;
    padding: 0;
    pointer-events: none;
    background: linear-gradient(180deg, rgba(0,0,0,0) 55%, rgba(0,0,0,0.24) 78%, rgba(0,0,0,0.52) 100%);
}

.banner-promo-label {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.9rem;
    border-radius: 999px;
    background: rgba(255,255,255,0.94);
    color: #B91C1C;
    font-weight: 700;
    font-size: 0.78rem;
    margin-bottom: 0.75rem;
}

.banner-promo-item h2 {
    margin: 0;
    font-size: clamp(1.75rem, 2.5vw, 3rem);
    line-height: 1.05;
    color: #fff;
}

.banner-promo-item p {
    margin: 0;
    color: rgba(255,255,255,0.92);
    font-size: 0.95rem;
    line-height: 1.6;
    max-width: 90%;
}

.banner-promo-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.75rem 1.1rem;
    border-radius: 999px;
    background: rgba(255,255,255,0.95);
    color: #B91C1C;
    font-weight: 700;
}

.banner-slider-dots {
    position: absolute;
    left: 50%;
    bottom: 10px;
    transform: translateX(-50%);
    z-index: 4;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.45rem;
    margin: 0;
}

.banner-slider-dot {
    width: 9px;
    height: 9px;
    border-radius: 50%;
    border: none;
    padding: 0;
    cursor: pointer;
    background: rgba(127, 29, 29, 0.28);
    transition: transform 0.2s ease, background 0.2s ease;
}

.banner-slider-dot.active {
    background: #B91C1C;
    transform: scale(1.15);
}

    .outlet-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.55);
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.25s ease, visibility 0.25s ease;
        z-index: 2100;
    }
    .outlet-modal-overlay.open {
        opacity: 1;
        visibility: visible;
    }
    .outlet-modal {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0.95);
        width: min(96vw, 520px);
        max-height: 90vh;
        overflow: hidden;
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 30px 90px rgba(0,0,0,0.22);
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.25s ease, transform 0.25s ease, visibility 0.25s ease;
        z-index: 2101;
    }
    .outlet-modal.open {
        opacity: 1;
        visibility: visible;
        transform: translate(-50%, -50%) scale(1);
    }
    .outlet-modal-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 1.4rem 1.5rem;
        border-bottom: 1px solid #f3f4f6;
    }
    .outlet-modal-head h3 {
        margin: 0;
        font-size: 1.2rem;
        color: #111827;
    }
    .outlet-modal-head p {
        margin: 0;
        color: #6b7280;
        font-size: 0.95rem;
    }
    .outlet-modal-close {
        width: 38px;
        height: 38px;
        border: none;
        border-radius: 50%;
        background: #f3f4f6;
        color: #374151;
        cursor: pointer;
        display: grid;
        place-items: center;
    }
    .outlet-modal-list {
        max-height: calc(90vh - 108px);
        overflow-y: auto;
        padding: 1rem 1.25rem 1.25rem;
        display: grid;
        gap: 0.65rem;
    }
    .outlet-choice {
        display: block;
        padding: 1rem 1.2rem;
        border-radius: 18px;
        background: #ffffff;
        border: 1px solid rgba(15, 23, 42, 0.12);
        color: #111827;
        text-decoration: none;
        font-weight: 700;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
        transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    }
    .outlet-choice:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        transform: translateY(-2px);
        box-shadow: 0 16px 35px rgba(15, 23, 42, 0.12);
    }

</style>

<?php $__env->startSection('content'); ?>


<?php if($banners->count()): ?>
    <div class="banner-promo-top">
        <div class="banner-promo-track" id="bannerPromoTrack">
            <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e($banner->url_tujuan ?: 'javascript:void(0)'); ?>" class="banner-promo-item" target="_blank">
                    <?php if($banner->is_video): ?>
                        <video class="banner-promo-bg" autoplay muted loop playsinline>
                            <source src="<?php echo e($banner->image_url); ?>">
                        </video>
                        <button type="button" class="banner-volume-toggle" aria-label="Toggle volume">🔈</button>
                    <?php else: ?>
                        <div class="banner-promo-bg" style="background-image: url('<?php echo e($banner->image_url); ?>');"></div>
                    <?php endif; ?>
                    <div class="banner-promo-copy"></div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php if($banners->count() > 1): ?>
            <div class="banner-slider-dots" id="bannerSliderDots" aria-label="Navigasi banner">
                <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button type="button" class="banner-slider-dot <?php echo e($loop->first ? 'active' : ''); ?>" data-slide-index="<?php echo e($loop->index); ?>" aria-label="Banner <?php echo e($loop->iteration); ?>"></button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const slider = document.querySelector('.banner-promo-top');
    const track = document.getElementById('bannerPromoTrack');
    const slides = track ? Array.from(track.querySelectorAll('.banner-promo-item')) : [];
    const dots = Array.from(document.querySelectorAll('.banner-slider-dot'));

    if (slider && track && slides.length > 1) {
        let currentIndex = 0;
        let autoTimer = null;
        const intervalMs = 4200;

        const setActiveDot = function(index) {
            dots.forEach(function(dot, dotIndex) {
                dot.classList.toggle('active', dotIndex === index);
            });
        };

        const goToSlide = function(index) {
            currentIndex = (index + slides.length) % slides.length;
            track.style.transform = 'translateX(-' + (currentIndex * 100) + '%)';
            setActiveDot(currentIndex);
        };

        const startAutoSlide = function() {
            if (autoTimer) clearInterval(autoTimer);
            autoTimer = setInterval(function() {
                goToSlide(currentIndex + 1);
            }, intervalMs);
        };

        dots.forEach(function(dot) {
            dot.addEventListener('click', function(event) {
                event.preventDefault();
                goToSlide(Number(dot.dataset.slideIndex || 0));
                startAutoSlide();
            });
        });

        slider.addEventListener('mouseenter', function() {
            if (autoTimer) clearInterval(autoTimer);
        });

        slider.addEventListener('mouseleave', function() {
            startAutoSlide();
        });

        slider.addEventListener('touchstart', function() {
            if (autoTimer) clearInterval(autoTimer);
        }, { passive: true });

        slider.addEventListener('touchend', function() {
            startAutoSlide();
        }, { passive: true });

        goToSlide(0);
        startAutoSlide();
    }

    document.querySelectorAll('.banner-promo-item').forEach(function(item) {
        const video = item.querySelector('video');
        const button = item.querySelector('.banner-volume-toggle');
        if (!video || !button) {
            return;
        }

        button.addEventListener('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            video.muted = !video.muted;
            button.textContent = video.muted ? '🔈' : '🔊';
        });
    });
});
</script>


<div class="promo-section">
  <div class="container">
    <div class="promo-grid">
      <a href="<?php echo e(route('products.pbf.gate')); ?>" class="promo-card promo-contact">
        <div class="promo-card-content">
          <img src="<?php echo e(asset('logo pt sumber indo farma tama.png')); ?>" alt="Sumberindo Farma" class="promo-goapotik-logo">
          <div class="promo-card-text">
            <h4>PBF</h4>
            <p>Jelajahi Katalog Produk PBF Terlengkap Kami</p>
          </div>
        </div>
      </a>
      <a href="<?php echo e(route('products.apotek', ['perusahaan' => 'Apotek Medistra Farma'])); ?>" class="promo-card promo-goapotik">
        <div class="promo-card-content">
          <img src="<?php echo e(asset('logo apotek medistra farma.png')); ?>" alt="Apotek Medistra Farma" class="promo-goapotik-logo">
          <div class="promo-card-text">
            <h4>Apotek Medistra Farma</h4>
            <p>Kunjungi toko kami di Apotek Medistra Farma</p>
          </div>
        </div>
      </a>
      <a href="javascript:void(0)" onclick="openAlfaOutletModal()" class="promo-card promo-pbf">
        <div class="promo-card-content">
          <img src="<?php echo e(asset('apotek alfa group logo.png')); ?>" alt="Apotek Alfa Group" class="promo-pbf-logo">
          <div class="promo-card-text">
            <h4>Apotek Alfa Group</h4>
            <p>Kunjungi toko kami diberbagai tempat.</p>
          </div>
        </div>
      </a>
    </div>
  </div>
</div>


<?php if(isset($promoProducts) && $promoProducts->count()): ?>
<style>
/* =============================================
   PROMO PRODUK — Simple & Elegant Background
   ============================================= */
.promo-products-section {
    padding: 3rem 0;
    background: linear-gradient(135deg, #B91C1C 0%, #991B1B 100%);
    position: relative;
    overflow: hidden;
    border-top: none;
    border-bottom: none;
}

.promo-products-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    gap: 0.75rem;
    flex-wrap: wrap;
    position: relative;
    z-index: 2;
}

.promo-products-header .sec-tag {
    font-size: 0.875rem;
    font-weight: 700;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 1px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.2);
    padding: 0.5rem 1rem;
    border-radius: 50px;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.promo-products-header .sec-title {
    font-size: 2rem;
    font-weight: 800;
    color: #fff;
    margin: 0;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    letter-spacing: -0.5px;
}

.promo-products-track-wrap {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: thin;
    scrollbar-color: rgba(255, 255, 255, 0.5) rgba(255, 255, 255, 0.1);
    margin: 0 -1rem;
    padding: 0.5rem 1rem;
    position: relative;
    z-index: 2;
}

.promo-products-track-wrap::-webkit-scrollbar {
    height: 8px;
}

.promo-products-track-wrap::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 4px;
}

.promo-products-track-wrap::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.5);
    border-radius: 4px;
}

.promo-products-track-wrap::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.8);
}

.promo-products-track {
    display: flex;
    gap: 1.2rem;
    width: max-content;
    padding: 0.5rem 0;
}

.promo-photo-card {
    width: 165px;
    height: 165px;
    border-radius: 18px;
    overflow: hidden;
    flex-shrink: 0;
    position: relative;
    cursor: pointer;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.18);
    transition: all 0.3s ease;
    text-decoration: none;
    display: block;
    background: #fff;
    border: 2px solid rgba(255, 255, 255, 0.4);
}

.promo-photo-card:hover {
    transform: translateY(-8px) scale(1.05);
    box-shadow: 0 16px 40px rgba(0, 0, 0, 0.25);
    border-color: rgba(255, 255, 255, 0.8);
}

.promo-photo-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.3s ease;
}

.promo-photo-card:hover img { transform: scale(1.08); }

.promo-photo-card::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(30, 136, 229, 0.3) 0%, rgba(56, 192, 155, 0.2) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
}

.promo-photo-card:hover::before { opacity: 1; }

.promo-photo-card::after {
    content: '★';
    position: absolute;
    top: 10px;
    right: 10px;
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, #fff100 0%, #ffb300 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(255, 179, 0, 0.4);
    font-size: 18px;
    font-weight: bold;
    color: #fff;
    opacity: 0;
    transition: opacity 0.3s ease;
    transform: scale(0);
}

.promo-photo-card:hover::after { 
    opacity: 1; 
    transform: scale(1);
}

@media (max-width: 768px) {
    .promo-products-section { padding: 2.5rem 0; }
    .promo-products-header .sec-title { font-size: 1.6rem; }
    .promo-photo-card { width: 145px; height: 145px; border-radius: 16px; }
    .promo-products-track { gap: 0.95rem; }
}

@media (max-width: 600px) {
    .promo-products-section { padding: 2rem 0; }
    .promo-photo-card { width: 130px; height: 130px; border-radius: 14px; }
    .promo-products-track { gap: 0.8rem; }
    .promo-products-header .sec-title { font-size: 1.4rem; }
    .promo-products-header .sec-tag { font-size: 0.75rem; padding: 0.4rem 0.8rem; }
}

@media (max-width: 400px) {
    .promo-photo-card { width: 115px; height: 115px; border-radius: 12px; }
    .promo-products-track { gap: 0.6rem; }
    .promo-photo-card::after { width: 28px; height: 28px; font-size: 14px; top: 6px; right: 6px; }
}
</style>

<section class="promo-products-section">
  <div class="container">
    <div class="promo-products-header">
      <div class="sec-head-left">
        <span class="sec-tag">🏷️ PENAWARAN EKSKLUSIF</span>
        <h2 class="sec-title">Promo Spesial Hari Ini</h2>
      </div>
    </div>

    <div class="promo-products-track-wrap">
      <div class="promo-products-track">
        <?php $__currentLoopData = $promoProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php if($promo->url_tujuan): ?>
            <a href="<?php echo e($promo->url_tujuan); ?>" class="promo-photo-card" title="<?php echo e($promo->judul); ?>" data-tooltip="<?php echo e($promo->judul); ?>">
          <?php else: ?>
            <span class="promo-photo-card" title="<?php echo e($promo->judul); ?>" data-tooltip="<?php echo e($promo->judul); ?>">
          <?php endif; ?>
            <img src="<?php echo e(url('storage/'.$promo->gambar)); ?>" alt="<?php echo e($promo->judul); ?>" loading="lazy">
          <?php if($promo->url_tujuan): ?>
            </a>
          <?php else: ?>
            </span>
          <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>


<style>
/* =============================================
   KENAPA PILIH KAMI — Modern Card Section
   ============================================= */
.why-cards-section {
    margin-top: 0;
    padding: 5rem 0 5.5rem;
    background: linear-gradient(160deg, #fef2f2 0%, #eef5ff 50%, #f6fbff 100%);
    position: relative;
    overflow: hidden;
}
.why-cards-section::before {
    content: '';
    position: absolute;
    top: -120px; left: -120px;
    width: 420px; height: 420px;
    background: radial-gradient(circle, rgba(220,38,38,.10) 0%, transparent 70%);
    pointer-events: none;
}
.why-cards-section::after {
    content: '';
    position: absolute;
    bottom: -100px; right: -80px;
    width: 360px; height: 360px;
    background: radial-gradient(circle, rgba(220,38,38,.09) 0%, transparent 70%);
    pointer-events: none;
}

/* Section heading */
.why-section-head {
    text-align: center;
    margin-bottom: 2.5rem;
}
.why-section-tag {
    display: inline-flex; align-items: center; gap: .45rem;
    background: linear-gradient(135deg, #B91C1C, #991B1B);
    color: #fff;
    padding: .45rem 1.2rem;
    border-radius: 999px;
    font-size: .8rem; font-weight: 700;
    letter-spacing: .04em;
    box-shadow: 0 6px 20px rgba(220,38,38,.3);
    margin-bottom: .85rem;
}
.why-section-title {
    font-size: clamp(1.5rem, 3vw, 2rem);
    font-weight: 900;
    color: #0f172a;
    margin: 0 0 .5rem;
    line-height: 1.2;
}
.why-section-sub {
    font-size: .95rem;
    color: #64748b;
    margin: 0;
}

/* Grid */
.why-cards-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1.5rem;
    position: relative;
    z-index: 1;
}

/* Card */
.why-card {
    background: #fff;
    border-radius: 20px;
    padding: 2.25rem 2rem;
    border: 1.5px solid rgba(148, 163, 184, 0.15);
    box-shadow: 0 4px 24px rgba(15,23,42,.06), 0 1px 4px rgba(15,23,42,.04);
    display: flex;
    flex-direction: column;
    gap: 0;
    transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
    position: relative;
    overflow: hidden;
}
/* Coloured top accent bar */
.why-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    border-radius: 20px 20px 0 0;
}
.why-card:nth-child(1)::before { background: linear-gradient(90deg, #B91C1C 0%, #ef4444 100%); }
.why-card:nth-child(2)::before { background: linear-gradient(90deg, #991B1B 0%, #ef4444 100%); }
.why-card:nth-child(3)::before { background: linear-gradient(90deg, #b91c1c 0%, #ef4444 100%); }

/* Hover lift */
.why-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 48px rgba(15,23,42,.12), 0 4px 12px rgba(15,23,42,.06);
    border-color: rgba(220,38,38,.25);
}

/* Icon circle */
.why-card-icon-wrap {
    width: 64px; height: 64px;
    border-radius: 18px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.65rem;
    margin-bottom: 1.25rem;
    flex-shrink: 0;
    transition: transform .3s ease;
}
.why-card:hover .why-card-icon-wrap { transform: scale(1.08) rotate(-4deg); }
.why-card:nth-child(1) .why-card-icon-wrap { background: linear-gradient(135deg, #fef2f2, #fee2e2); color: #991B1B; }
.why-card:nth-child(2) .why-card-icon-wrap { background: linear-gradient(135deg, #fef2f2, #fee2e2); color: #991B1B; }
.why-card:nth-child(3) .why-card-icon-wrap { background: linear-gradient(135deg, #fef2f2, #ffe0b2); color: #B91C1C; }

/* Title */
.why-card h4 {
    font-size: 1.1rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 .65rem;
    line-height: 1.3;
}

/* Body text */
.why-card p {
    font-size: .92rem;
    color: #64748b;
    line-height: 1.75;
    margin: 0 0 1.25rem;
    flex: 1;
}

/* Badge pill */
.why-card-badge {
    display: inline-flex; align-items: center; gap: .35rem;
    width: fit-content;
    font-size: .76rem; font-weight: 700;
    padding: .4rem .85rem;
    border-radius: 999px;
}
.why-card:nth-child(1) .why-card-badge { background: #fef2f2; color: #991B1B; }
.why-card:nth-child(2) .why-card-badge { background: #fef2f2; color: #991B1B; }
.why-card:nth-child(3) .why-card-badge { background: #fef2f2; color: #bf360c; }

/* ---- Responsive ---- */
@media (max-width: 900px) {
    .why-cards-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1.1rem; }
    .why-cards-section { padding: 3.5rem 0 4rem; }
}
@media (max-width: 600px) {
    .why-cards-section { padding: 2.5rem 0 3rem; }
    .why-section-head { margin-bottom: 1.75rem; }
    .why-cards-grid {
        grid-template-columns: 1fr;
        gap: .9rem;
    }
    .why-card {
        padding: 1.5rem 1.25rem;
        border-radius: 16px;
        flex-direction: row;
        align-items: flex-start;
        gap: 1rem;
    }
    .why-card-icon-wrap {
        width: 50px; height: 50px;
        border-radius: 14px;
        font-size: 1.3rem;
        margin-bottom: 0;
        flex-shrink: 0;
    }
    .why-card-content { flex: 1; }
    .why-card h4 { font-size: .98rem; margin-bottom: .4rem; }
    .why-card p { font-size: .84rem; line-height: 1.6; margin-bottom: .75rem; }
    .why-card-badge { font-size: .7rem; padding: .3rem .65rem; }
}
@media (max-width: 400px) {
    .why-card { padding: 1.2rem 1rem; }
    .why-card-icon-wrap { width: 44px; height: 44px; font-size: 1.15rem; }
}
</style>

<section class="why-cards-section">
  <div class="container">

    
    <div class="why-section-head">
      <div>
        <span class="why-section-tag"><i class="fa-solid fa-star"></i> Kenapa Pilih Kami?</span>
      </div>
      <h2 class="why-section-title">Keunggulan Sumberindo Farma Tama</h2>
      <p class="why-section-sub">Kami hadir sebagai mitra terpercaya untuk kebutuhan farmasi Anda</p>
    </div>

    <div class="why-cards-grid">

      
      <div class="why-card">
        <div class="why-card-icon-wrap"><i class="fa-solid fa-shield-halved"></i></div>
        <div class="why-card-content">
          <h4>Produk Original & Terjamin</h4>
          <p>Semua produk bersertifikat BPOM, berstandar GMP, dan dijamin keasliannya langsung dari pabrikan resmi terpercaya.</p>
          <span class="why-card-badge"><i class="fa-solid fa-circle-check"></i> Bersertifikat BPOM</span>
        </div>
      </div>

      
      <div class="why-card">
        <div class="why-card-icon-wrap"><i class="fa-solid fa-truck-fast"></i></div>
        <div class="why-card-content">
          <h4>Pengiriman Cepat & Aman</h4>
                    <p>Didukung sistem distribusi yang efisien dan mitra logistik terpercaya untuk memastikan pesanan tiba tepat waktu, aman, dan dalam kondisi terbaik.</p>
          <span class="why-card-badge"><i class="fa-solid fa-location-dot"></i> Seluruh Indonesia</span>
        </div>
      </div>

      
      <div class="why-card">
        <div class="why-card-icon-wrap"><i class="fa-solid fa-tag"></i></div>
        <div class="why-card-content">
          <h4>Harga Distributor Terbaik</h4>
          <p>Harga langsung dari distributor tanpa markup berlebih. Hemat lebih banyak dengan berbelanja langsung dari sumbernya.</p>
          <span class="why-card-badge"><i class="fa-solid fa-percent"></i> Harga Terjangkau</span>
        </div>
      </div>

    </div>
  </div>
</section>


<div class="cta-section">
  <div class="container">
    <div class="cta-box">
      <div>
        <h3>💬 Mau pesan via WhatsApp?</h3>
        <p>Tim kami siap bantu proses pesanan Anda dengan cepat & mudah.</p>
      </div>
      <a href="https://wa.me/6285248965590?text=Halo%20Sumberindo%20Farma%20Tama%2C%20saya%20ingin%20memesan%20produk." target="_blank" class="btn-wa">
        <i class="fa-brands fa-whatsapp" style="font-size:1.3rem;"></i> Chat WhatsApp
      </a>
    </div>
  </div>
</div>


<div class="about-strip">
  <div class="container">
    <div class="about-box">
      <img src="<?php echo e(asset('logo pt sumber indo farma tama.png')); ?>" alt="Sumberindo Farma Tama" class="about-logo">
      <div class="about-info">
        <h3>PT. SUMBERINDO FARMA TAMA — Distributor Farmasi Terpercaya</h3>
        <p>Sejak 2016 melayani kebutuhan medis masyarakat & praktisi kesehatan di seluruh Indonesia. Produk original, harga distributor, pengiriman cepat.</p>
        <a href="<?php echo e(route('about')); ?>" class="btn-about"><i class="fa-solid fa-circle-info"></i> Selengkapnya Tentang Kami</a>
      </div>
      <div class="about-stats">
        <div class="about-stat-item"><span class="n">15+</span><span class="l">Tahun Pengalaman</span></div>
        <div class="about-stat-item"><span class="n">100+</span><span class="l">Brand Partner</span></div>
        <div class="about-stat-item"><span class="n">50+</span><span class="l">Kota Jangkauan</span></div>
        <div class="about-stat-item"><span class="n">24/7</span><span class="l">Layanan Aktif</span></div>
      </div>
    </div>
  </div>
</div>

<section class="pbf-profile-section">
    <div class="container">
        <div class="pbf-profile-wrap">
            <div class="pbf-profile-head">
                <div>
                    <span class="pbf-profile-tag"><i class="fa-solid fa-building-shield"></i> Profil PBF</span>
                    <h3>PT. SUMBERINDO FARMA TAMA adalah Perusahaan Besar Farmasi (PBF)</h3>
                    <p>
                        PT. Sumberindo Farma Tama merupakan Pedagang Besar Farmasi (PBF) yang menyediakan layanan distribusi
                        farmasi profesional. Dengan mengedepankan kepatuhan terhadap regulasi, kualitas layanan, dan integritas
                        operasional, kami mendistribusikan obat dan alat kesehatan dari prinsipal kepada fasilitas pelayanan
                        kesehatan melalui sistem distribusi yang aman, efisien, dan dapat diandalkan.
                    </p>
                    <div class="pbf-keypoints">
                        <span><i class="fa-solid fa-circle-check"></i> Distributor Resmi</span>
                        <span><i class="fa-solid fa-warehouse"></i> Sistem Gudang Terkelola</span>
                        <span><i class="fa-solid fa-truck-fast"></i> Distribusi Terjadwal</span>
                        <span><i class="fa-solid fa-shield-heart"></i> Komitmen Mutu & Kepatuhan</span>
                    </div>
                </div>
            </div>

            <div class="pbf-gallery-grid">
                <div class="pbf-photo-template">
                    <img src="<?php echo e(asset('foto kantor utama SFT.jpg')); ?>" alt="Foto Kantor Utama Sumberindo Farma Tama">
                    <h4>Kantor Utama</h4>
                    <p>Fasad kantor utama PT. Sumberindo Farma Tama.</p>
                </div>
                <div class="pbf-photo-template">
                    <img src="<?php echo e(asset('foto kantor utama SFT (2).jpg')); ?>" alt="Foto Kantor Utama Sumberindo Farma Tama Sudut Lain">
                    <h4>Kantor Utama - Sudut Lain</h4>
                    <p>Tampilan area kantor dari sisi berbeda.</p>
                </div>
                <div class="pbf-photo-template">
                    <img src="<?php echo e(asset('foto gudang distribusi SFT.jpeg')); ?>" alt="Foto Gudang Distribusi Sumberindo Farma Tama">
                    <h4>Gudang Distribusi</h4>
                    <p>Gudang penyimpanan dan area distribusi farmasi.</p>
                </div>
                <div class="pbf-photo-template">
                    <img src="<?php echo e(asset('foto gudang distribusi SFT (2).jpeg')); ?>" alt="Foto Gudang Distribusi Area Penyimpanan">
                    <h4>Gudang Distribusi - Penyimpanan</h4>
                    <p>Area penyimpanan produk dengan tata kelola rapi.</p>
                </div>
                <div class="pbf-photo-template pbf-photo-template-featured">
                    <img src="<?php echo e(asset('STRUKTUR PT SFT.png')); ?>" alt="Struktur PT Sumberindo Farma Tama">
                    <h4>Tim Profesional</h4>
                </div>
                <div class="pbf-photo-template">
                    <img src="<?php echo e(asset('foto gudang distribusi SFT (3).jpeg')); ?>" alt="Foto Gudang Distribusi Area Loading">
                    <h4>Gudang Distribusi - Area Loading</h4>
                    <p>Dokumentasi area loading untuk proses keluar-masuk barang.</p>
                </div>
                <div class="pbf-photo-template">
                    <img src="<?php echo e(asset('BAGIAN PICKER.jpg')); ?>" alt="Foto Aktivitas Operasional Sumberindo Farma Tama">
                    <h4>Aktivitas Operasional - Picker</h4>
                    <p>Proses picking produk pada operasional harian.</p>
                </div>
                <div class="pbf-photo-template">
                    <img src="<?php echo e(asset('BAGIAN CHECKER.jpg')); ?>" alt="Foto Aktivitas Operasional Bagian Checker">
                    <h4>Aktivitas Operasional - Checker</h4>
                    <p>Proses pengecekan barang sebelum distribusi.</p>
                </div>
                <div class="pbf-photo-template">
                    <img src="<?php echo e(asset('MOBIL BOX.jpg')); ?>" alt="Foto Armada Pengiriman Sumberindo Farma Tama">
                    <h4>Armada Pengiriman - Mobil Box</h4>
                    <p>Armada box untuk distribusi produk farmasi.</p>
                </div>
                <div class="pbf-photo-template">
                    <img src="<?php echo e(asset('AKTIVITAS KARYAWAN SFT.jpg')); ?>" alt="Foto Aktivitas Karyawan Sumberindo Farma Tama">
                    <h4>Aktivitas Karyawan</h4>
                    <p>Dokumentasi kegiatan karyawan di lingkungan kerja SFT.</p>
                </div>
                <div class="pbf-photo-template">
                    <img src="<?php echo e(asset('MOBIL LUXIO HITAM.jpg')); ?>" alt="Foto Armada Pengiriman Mobil Luxio Hitam">
                    <h4>Armada Pengiriman - Luxio</h4>
                    <p>Kendaraan distribusi pendukung pengiriman harian.</p>
                </div>
                <div class="pbf-photo-template">
                    <img src="<?php echo e(asset('MOBIL TOSA.jpg')); ?>" alt="Foto Armada Pengiriman Mobil Tosa">
                    <h4>Armada Pengiriman - Tosa</h4>
                    <p>Armada operasional untuk rute distribusi tertentu.</p>
                </div>
            </div>

        </div>
    </div>
</section>

<div class="outlet-modal-overlay" id="outletModalOverlay" onclick="closeAlfaOutletModal()"></div>
<div class="outlet-modal" id="outletModal">
  <div class="outlet-modal-head">
    <div>
      <h3>Pilih Apotek Alfa</h3>
      <p>Pilih gerai yang ingin Anda kunjungi.</p>
    </div>
    <button type="button" class="outlet-modal-close" onclick="closeAlfaOutletModal()"><i class="fa-solid fa-xmark"></i></button>
  </div>
  <div class="outlet-modal-list">
    <a href="<?php echo e(route('products.apotek', ['perusahaan' => 'Alfa Sintang'])); ?>" class="outlet-choice">1. Apotek Alfa Sintang</a>
    <a href="<?php echo e(route('products.apotek', ['perusahaan' => 'Alfa Air Upas'])); ?>" class="outlet-choice">2. Apotek Alfa Air Upas</a>
    <a href="<?php echo e(route('products.apotek', ['perusahaan' => 'Alfa Kendawangan'])); ?>" class="outlet-choice">3. Apotek Alfa Kendawangan</a>
    <a href="<?php echo e(route('products.apotek', ['perusahaan' => 'Alfa Balai Berkuak'])); ?>" class="outlet-choice">4. Apotek Alfa Balai Berkuak</a>
    <a href="<?php echo e(route('products.apotek', ['perusahaan' => 'Alfa Nanga Tayap'])); ?>" class="outlet-choice">5. Apotek Alfa Nanga Tayap</a>
    <a href="<?php echo e(route('products.apotek', ['perusahaan' => 'Alfa Tumbang Titi'])); ?>" class="outlet-choice">6. Apotek Alfa Tumbang Titi</a>
    <a href="<?php echo e(route('products.apotek', ['perusahaan' => 'Alfa Sosok'])); ?>" class="outlet-choice">7. Apotek Alfa Sosok</a>
    <a href="<?php echo e(route('products.apotek', ['perusahaan' => 'Alfa Bodok'])); ?>" class="outlet-choice">8. Apotek Alfa Bodok</a>
    <a href="<?php echo e(route('products.apotek', ['perusahaan' => 'Alfa Kembayan'])); ?>" class="outlet-choice">9. Apotek Alfa Kembayan</a>
    <a href="<?php echo e(route('products.apotek', ['perusahaan' => 'Alfa Ambawang'])); ?>" class="outlet-choice">10. Apotek Alfa Ambawang</a>
    <a href="<?php echo e(route('products.apotek', ['perusahaan' => 'Alfa Jungkat'])); ?>" class="outlet-choice">11. Apotek Alfa Jungkat</a>
    <a href="<?php echo e(route('products.apotek', ['perusahaan' => 'Alfa Mempawah'])); ?>" class="outlet-choice">12. Apotek Alfa Mempawah</a>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function openAlfaOutletModal() {
  document.getElementById('outletModalOverlay').classList.add('open');
  document.getElementById('outletModal').classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closeAlfaOutletModal() {
  document.getElementById('outletModalOverlay').classList.remove('open');
  document.getElementById('outletModal').classList.remove('open');
  document.body.style.overflow = '';
}
</script>
<?php $__env->stopSection(); ?>






<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Ali Attaziri\sumberindofarma\resources\views/home.blade.php ENDPATH**/ ?>