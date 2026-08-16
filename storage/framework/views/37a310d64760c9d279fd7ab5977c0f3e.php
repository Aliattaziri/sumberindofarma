<?php $__env->startSection('title', 'Hubungi Kami - Sumberindo Farma Tama'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .contact-header {
        background: linear-gradient(135deg, #7F1D1D 0%, #991B1B 50%, #B91C1C 100%);
        padding: 4rem 0;
        position: relative;
        overflow: hidden;
    }
    .contact-header::before {
        content: '';
        position: absolute;
        top: -80px; right: -80px;
        width: 350px; height: 350px;
        background: radial-gradient(circle, rgba(220,38,38,0.18) 0%, transparent 70%);
        border-radius: 50%;
    }
    .contact-header .header-deco-icon {
        position: absolute;
        color: rgba(255,255,255,0.08);
        pointer-events: none;
        animation: headerIconFloat 6s ease-in-out infinite;
    }
    .contact-header .header-deco-icon-1 { bottom: 10px; right: 12%; font-size: 4rem; animation-delay: 0s; }
    .contact-header .header-deco-icon-2 { top: 15px;   right: 28%; font-size: 3rem; animation-delay: 2s; }
    .contact-header .header-deco-icon-3 { bottom: 20px; right: 40%; font-size: 2.5rem; animation-delay: 4s; }
    @keyframes headerIconFloat {
        0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.08; }
        50%       { transform: translateY(-12px) rotate(8deg); opacity: 0.14; }
    }
    .contact-header h1 { font-size: clamp(2rem,4vw,3rem); font-weight: 800; color: white; margin-bottom: 0.5rem; position: relative; }
    .contact-header p  { color: rgba(255,255,255,0.8); font-size: 1rem; position: relative; }
    .breadcrumb-custom { display: flex; gap: 0.5rem; align-items: center; margin-bottom: 1rem; position: relative; }
    .breadcrumb-custom a { color: rgba(255,255,255,0.7); text-decoration: none; font-size: 0.9rem; }
    .breadcrumb-custom a:hover { color: white; }
    .breadcrumb-custom span { color: rgba(255,255,255,0.5); font-size: 0.9rem; }
    .breadcrumb-custom .current { color: #a5d65a; font-size: 0.9rem; font-weight: 600; }

    .contact-main { background: #f8faff; padding: 3rem 0 5rem; }

    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1.6fr;
        gap: 2rem;
        align-items: start;
    }

    /* Info Cards */
    .info-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        border: 1px solid #e5e7eb;
    }

    .info-item {
        display: flex;
        gap: 1rem;
        align-items: flex-start;
        padding: 1.1rem 0;
        border-bottom: 1px solid #f3f4f6;
    }
    .info-item:last-child { border-bottom: none; padding-bottom: 0; }
    .info-item:first-child { padding-top: 0; }

    .info-icon {
        width: 42px; height: 42px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; flex-shrink: 0;
    }
    .icon-blue   { background: #fef2f2; color: #B91C1C; }
    .icon-green  { background: #fff5f5; color: #ef4444; }
    .icon-orange { background: #fef2f2; color: #ef4444; }
    .icon-purple { background: #fef2f2; color: #B91C1C; }

        .info-text h4 { font-size: 0.9rem; font-weight: 700; color: #374151; margin-bottom: 0.25rem; }
    .info-text p, .info-text a { font-size: 0.85rem; color: #6b7280; margin: 0; line-height: 1.7; text-decoration: none; }
    .info-text a:hover { color: #B91C1C; }

    .social-row { display: flex; gap: 0.6rem; margin-top: 1.25rem; flex-wrap: wrap; }
    .social-btn {
        width: 40px; height: 40px; border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        color: white; text-decoration: none; font-size: 1rem;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .social-btn img {
        width: 16px; height: 16px; object-fit: contain; display: block;
    }
    .social-btn:hover { transform: translateY(-3px); box-shadow: 0 6px 16px rgba(0,0,0,0.2); color: white; }

    /* Form Card */
    .form-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        border: 1px solid #e5e7eb;
    }

    .form-card h3 { font-size: 1.2rem; font-weight: 700; color: #1f2937; margin-bottom: 1.5rem; }

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem; }

    .form-group { margin-bottom: 1rem; }
    .form-group label { display: block; font-size: 0.85rem; font-weight: 600; color: #374151; margin-bottom: 0.35rem; }
    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%; padding: 0.65rem 0.9rem;
        border: 1.5px solid #e5e7eb; border-radius: 10px;
        font-size: 0.9rem; color: #374151; background: #f9fafb;
        transition: all 0.2s; outline: none; font-family: inherit;
    }
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: #B91C1C; background: white;
        box-shadow: 0 0 0 3px rgba(220,38,38,0.1);
    }
    .form-group textarea { resize: vertical; min-height: 130px; }

    .btn-send {
        width: 100%; padding: 0.85rem;
        background: linear-gradient(135deg, #25D366, #1f8f4a);
        color: white; border: none; border-radius: 10px;
        font-size: 1rem; font-weight: 700; cursor: pointer;
        display: flex; align-items: center; justify-content: center; gap: 0.6rem;
        transition: all 0.3s;
    }
    .btn-send:hover { background: linear-gradient(135deg, #1f8f4a, #188a3a); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(37,211,102,0.35); }

    /* Dokumen Card */
    .doc-card {
        background: white;
        border-radius: 16px;
        padding: 1.75rem;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        border: 1px solid #e5e7eb;
        margin-bottom: 1.25rem;
    }
    .doc-card-title {
        font-size: 1rem; font-weight: 700; color: #1f2937;
        margin-bottom: 1.1rem; display: flex; align-items: center; gap: 0.5rem;
    }
    .doc-type {
        border-radius: 12px;
        padding: 1rem 1.1rem;
        margin-bottom: 0.75rem;
        border: 1px solid transparent;
    }
    .doc-type:last-child { margin-bottom: 0; }
    .doc-type-blue   { background: #fef2f2; border-color: #fecaca; }
    .doc-type-green  { background: #fef2f2; border-color: #fecaca; }
    .doc-type-orange { background: #fff5f5; border-color: #fecaca; }
    .doc-type-header {
        display: flex; align-items: center; gap: 0.5rem;
        font-size: 0.875rem; font-weight: 700; margin-bottom: 0.55rem;
    }
    .doc-type-blue   .doc-type-header { color: #991B1B; }
    .doc-type-green  .doc-type-header { color: #991B1B; }
    .doc-type-orange .doc-type-header { color: #991B1B; }
    .doc-type-icon {
        width: 28px; height: 28px; border-radius: 7px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.8rem; flex-shrink: 0;
    }
    .doc-type-blue   .doc-type-icon { background: #fef2f2; color: #991B1B; }
    .doc-type-green  .doc-type-icon { background: #fef2f2; color: #991B1B; }
    .doc-type-orange .doc-type-icon { background: #fff5f5; color: #991B1B; }
    .doc-list {
        list-style: none; padding: 0; margin: 0;
        display: flex; flex-wrap: wrap; gap: 0.4rem;
    }
    .doc-list li {
        font-size: 0.78rem; font-weight: 600; padding: 0.25rem 0.65rem;
        border-radius: 20px;
    }
    .doc-type-blue   .doc-list li { background: #fef2f2; color: #991B1B; }
    .doc-type-green  .doc-list li { background: #fee2e2; color: #166534; }
    .doc-type-orange .doc-list li { background: #fee2e2; color: #B91C1C; }

    /* Map */
    .map-section { margin-top: 2.5rem; }
    .map-section h3 { font-size: 1.1rem; font-weight: 700; color: #1f2937; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem; }
    .map-wrap { border-radius: 16px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.08); border: 1px solid #e5e7eb; }

    @media (max-width: 768px) {
        .contact-main { padding: 1.75rem 0 3rem; }
        .contact-grid { grid-template-columns: 1fr; gap: 1.25rem; }
        .form-row { grid-template-columns: 1fr; gap: 0; }
        .form-card { padding: 1.25rem; }
        .info-card { padding: 1.25rem; }
        .social-row { gap: 0.5rem; }
        .social-btn { width: 38px; height: 38px; }
        .info-text p, .info-text a { font-size: 0.8rem; }
        .info-text h4 { font-size: 0.82rem; }
    }

    @media (max-width: 480px) {
        .form-group textarea { min-height: 100px; }
        .map-wrap iframe { height: 240px; }
        .social-row { gap: 0.45rem; }
        .social-btn { width: 36px; height: 36px; font-size: 0.8rem; }
        .info-text p, .info-text a { font-size: 0.78rem; line-height: 1.5; word-break: break-word; }
        .info-text h4 { font-size: 0.8rem; }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="contact-header">
    <div class="container">
        <div class="breadcrumb-custom">
            <a href="<?php echo e(route('home')); ?>"><i class="fa-solid fa-house"></i> Home</a>
            <span>/</span>
            <span class="current">Hubungi Kami</span>
        </div>
        <h1><i class="fa-solid fa-headset"></i> Hubungi Kami</h1>
        <p>Kami siap membantu Anda — hubungi melalui WhatsApp, telepon, atau email</p>
    </div>
    <i class="fa-solid fa-headset header-deco-icon header-deco-icon-1"></i>
    <i class="fa-solid fa-phone header-deco-icon header-deco-icon-2"></i>
    <i class="fa-solid fa-envelope header-deco-icon header-deco-icon-3"></i>
</div>

<div class="contact-main">
    <div class="container">
        <div class="contact-grid">

            
            <div>

                
                <div class="doc-card">
                    <div class="doc-card-title">
                        <i class="fa-solid fa-file-shield" style="color:#B91C1C;"></i>
                        Persyaratan Dokumen Pemesanan
                    </div>

                    
                    <div class="doc-type doc-type-blue">
                        <div class="doc-type-header">
                            <div class="doc-type-icon"><i class="fa-solid fa-hospital"></i></div>
                            Apotek / RS / Klinik
                        </div>
                        <ul class="doc-list">
                            <li>NIB</li>
                            <li>Sertifikat Standar</li>
                            <li>SIPA + KTP APJ</li>
                            <li>NPWP Sarana</li>
                            <li>KTP Pemilik</li>
                        </ul>
                    </div>

                    
                    <div class="doc-type doc-type-orange">
                        <div class="doc-type-header">
                            <div class="doc-type-icon"><i class="fa-solid fa-store"></i></div>
                            Toko Obat
                        </div>
                        <ul class="doc-list">
                            <li>NIB</li>
                            <li>NPWP Sarana</li>
                            <li>KTP Pemilik</li>
                            <li>SIPTTK PJ + KTP PJ</li>
                        </ul>
                    </div>

                    
                    <div class="doc-type doc-type-green">
                        <div class="doc-type-header">
                            <div class="doc-type-icon"><i class="fa-solid fa-warehouse"></i></div>
                            PBF
                        </div>
                        <ul class="doc-list">
                            <li>NIB</li>
                            <li>Sertifikat Standar</li>
                            <li>Sertifikat CDOB/CDAKB</li>
                            <li>STR APJ + KTP</li>
                            <li>KTP Pemilik</li>
                            <li>NPWP PBF</li>
                        </ul>
                    </div>
                </div>

                
                <div class="info-card">
                    <div class="info-item">
                        <div class="info-icon icon-blue"><i class="fa-solid fa-location-dot"></i></div>
                        <div class="info-text">
                            <h4>Alamat</h4>
                            <p>Komp. Pergudangan Ocean 88 C2-3<br>
                               Jl. Adisucipto<br>
                               Arang Limbung<br>
                               Kec. Sungai Raya<br>
                               Kab. Kubu Raya<br>
                               Kalimantan Barat</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon icon-green"><i class="fa-brands fa-whatsapp"></i></div>
                        <div class="info-text">
                            <h4>WhatsApp</h4>
                            <a href="https://wa.me/6285248965590" target="_blank">+62 852-4896-5590</a>
                            <p style="margin-top:0.2rem;font-size:0.8rem;">Klik untuk chat langsung</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon icon-orange"><i class="fa-solid fa-phone"></i></div>
                        <div class="info-text">
                            <h4>Telepon</h4>
                            <a href="tel:+6285248965590">+62 852-4896-5590</a>
                            <p style="margin-top:0.2rem;font-size:0.8rem;">Sen–Jum 08:00–18:00 · Sab–Min 09:00–17:00</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon icon-purple"><i class="fa-solid fa-envelope"></i></div>
                        <div class="info-text">
                            <h4>Email</h4>
                            <a href="mailto:pt.sumberindofarmatama@sumberindopontianak.com">pt.sumberindofarmatama@sumberindopontianak.com</a>
                        </div>
                    </div>
                </div>

                <div style="margin-top:1.25rem; background:white; border-radius:16px; padding:1.5rem; box-shadow:0 2px 12px rgba(0,0,0,0.06); border:1px solid #e5e7eb;">
                    <h4 style="font-size:0.9rem;font-weight:700;color:#374151;margin-bottom:0.75rem;"><i class="fa-solid fa-share-nodes" style="color:#B91C1C;margin-right:0.4rem;"></i> Ikuti Kami</h4>
                    <div class="social-row">
                        <a href="https://www.instagram.com/sumberindofarma?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" class="social-btn" style="background:linear-gradient(135deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888);" title="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <a href="https://wa.me/6285248965590" target="_blank" class="social-btn" style="background:#25D366;" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                        <a href="https://www.tiktok.com/@ptsumberindofarmatama" target="_blank" class="social-btn" style="background:#000000;display:flex;align-items:center;justify-content:center;" title="TikTok"><div style="width:18px;height:18px;background:white;border-radius:6px;display:flex;align-items:center;justify-content:center;"><img src="<?php echo e(asset('logo tiktok.avif')); ?>" alt="TikTok" style="width:14px;height:14px;object-fit:contain;"></div></a>
                        <a href="#" class="social-btn" style="background:#EE3131;display:flex;align-items:center;justify-content:center;" title="Shopee"><div style="width:18px;height:18px;background:white;border-radius:6px;display:flex;align-items:center;justify-content:center;"><img src="<?php echo e(asset('logoshopee.jpeg')); ?>" alt="Shopee" style="width:14px;height:14px;object-fit:contain;"></div></a>
                    </div>
                </div>

            </div>

            
            <div>
                <div class="form-card">
                    <h3><i class="fa-solid fa-paper-plane" style="color:#B91C1C;margin-right:0.5rem;"></i> Kirim Pesan via WhatsApp</h3>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="nama">Nama Lengkap *</label>
                            <input type="text" id="nama" placeholder="Nama Anda">
                        </div>
                        <div class="form-group">
                            <label for="telepon">Nomor Telepon</label>
                            <input type="tel" id="telepon" placeholder="08xx-xxxx-xxxx">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="subjek">Subjek *</label>
                        <select id="subjek">
                            <option value="">-- Pilih subjek --</option>
                            <option value="Pertanyaan Pemesanan">Pertanyaan Pemesanan</option>
                            <option value="Pertanyaan Produk">Pertanyaan Produk</option>
                            <option value="Masalah Pengiriman">Masalah Pengiriman</option>
                            <option value="Kerjasama">Kerjasama</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="pesan">Pesan *</label>
                        <textarea id="pesan" placeholder="Tuliskan pesan Anda di sini..."></textarea>
                    </div>

                    <p id="formError" style="color:#ef4444;font-size:0.85rem;margin-bottom:0.75rem;display:none;">
                        <i class="fa-solid fa-circle-exclamation"></i> Nama, subjek, dan pesan wajib diisi.
                    </p>

                    <button class="btn-send" onclick="kirimWA()">
                        <i class="fa-brands fa-whatsapp" style="font-size:1.2rem;"></i> Kirim via WhatsApp
                    </button>
                </div>

                
                <div class="map-section">
                    <h3><i class="fa-solid fa-map-location-dot" style="color:#B91C1C;"></i> Lokasi Kami</h3>
                    <p style="margin-bottom:0.75rem; font-size:0.95rem; color:#4b5563;">Gunakan rute langsung ke lokasi kami dengan Google Maps.</p>
                    <a href="https://www.google.com/maps/dir/?api=1&destination=VCX4+XV+Sungai+Raya,+Kabupaten+Kubu+Raya,+Kalimantan+Barat" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;gap:0.5rem;margin-bottom:0.9rem;padding:0.75rem 1rem;background:#ef4444;color:#fff;border-radius:999px;text-decoration:none;font-weight:700;box-shadow:0 12px 32px rgba(239,68,68,0.18);">
                        <i class="fa-brands fa-google" style="font-size:1rem;"></i>
                        Buka Rute di Maps
                    </a>
                    <div class="map-wrap">
                        <iframe
                            src="https://maps.google.com/maps?q=VCX4%2BXV%20Sungai%20Raya%2C%20Kabupaten%20Kubu%20Raya%2C%20Kalimantan%20Barat&output=embed"
                            width="100%" height="320" style="border:0;display:block;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function kirimWA() {
    const nama   = document.getElementById('nama').value.trim();
    const telp   = document.getElementById('telepon').value.trim();
    const subjek = document.getElementById('subjek').value;
    const pesan  = document.getElementById('pesan').value.trim();
    const errEl  = document.getElementById('formError');

    if (!nama || !subjek || !pesan) {
        errEl.style.display = 'block';
        return;
    }
    errEl.style.display = 'none';

    const teks =
`Halo Sumberindo Farma Tama!

👤 *Nama*    : ${nama}
📱 *Telepon* : ${telp || '-'}
📌 *Subjek*  : ${subjek}

💬 *Pesan*:
${pesan}`;

    window.open('https://wa.me/6285248965590?text=' + encodeURIComponent(teks), '_blank');
}
</script>
<?php $__env->stopSection(); ?>






<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Ali Attaziri\sumberindofarma\resources\views/contact.blade.php ENDPATH**/ ?>