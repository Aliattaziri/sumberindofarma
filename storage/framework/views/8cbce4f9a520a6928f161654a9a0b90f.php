

<?php $__env->startSection('title', 'Mitra Kami'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    /* Reduce top padding so the hero card sits closer to the fixed navbar */
    .mitra-hero { padding: calc(0.2rem + var(--navbar-height, 65px)) 0 1rem; margin-top: -18px; }
    @media (max-width: 768px) {
        .mitra-hero { padding: calc(0.4rem + var(--navbar-height, 65px)) 0 0.9rem; margin-top: -10px; }
    }
    .mitra-list-wrap { background: #fff; border-radius: 14px; padding: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.04); }
    .mitra-grid { display:grid; grid-template-columns: repeat(5, minmax(110px, 1fr)); gap:1rem; align-items:center; justify-items:center; }
    .mitra-card { background:transparent;border-radius:8px;padding:0.5rem;display:flex;align-items:center;justify-content:center;min-height:90px; transition:transform 0.18s ease, box-shadow 0.18s ease; }
    .mitra-card a { display:flex;align-items:center;justify-content:center;width:100%;height:100%;text-decoration:none;cursor:pointer; }
    .mitra-card img { max-width:100%; max-height:68px; object-fit:contain; display:block; }
    .mitra-card:hover { transform: translateY(-6px); }
    .mitra-card a:hover img { filter: brightness(0.9); }
    @media (min-width:1200px) {
        .mitra-grid { gap:1.2rem; }
    }
    @media (max-width:1024px) {
        .mitra-grid { grid-template-columns: repeat(4, minmax(100px, 1fr)); gap:0.9rem; }
    }
    @media (max-width:768px) {
        .mitra-grid { grid-template-columns: repeat(3, minmax(90px, 1fr)); gap:0.8rem; }
    }
    @media (max-width:480px) {
        .mitra-grid { grid-template-columns: repeat(2, minmax(80px, 1fr)); gap:0.7rem; }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="mitra-hero">
    <div class="container">
        <div style="background:linear-gradient(135deg,#991B1B,#B91C1C);color:white;padding:2rem;border-radius:18px;">
            <div style="display:flex;gap:1rem;align-items:center;">
                <img src="<?php echo e(asset('logo pt sumber indo farma tama.png')); ?>" alt="Sumberindo" style="height:84px;border-radius:12px;background:white;padding:0.5rem;" />
                <div>
                    <h1 style="margin:0;font-size:2rem;font-weight:800;">Mitra Kami</h1>
                    <p style="margin:0.4rem 0 0;color:rgba(255,255,255,0.9);">Daftar mitra yang mempercayakan distribusi produknya kepada PT Sumberindo Farma Tama. Sebagai perusahaan distribusi (PBF) yang dipercaya para principal dan mitra, kami menghadirkan produk berkualitas dan layanan andal untuk menjangkau apotek serta distributor di seluruh wilayah.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container" style="padding:1.5rem 0 4rem;">
    <?php
        use App\Models\Medicine;
        use Illuminate\Support\Str;

        // Files from storage/principellogos (PRIMARY SOURCE)
        $principalsDir = storage_path('principellogos');
        $principalFiles = [];
        $seenPaths = []; // Track paths to avoid duplicates
        
        if (is_dir($principalsDir)) {
            foreach (scandir($principalsDir) as $it) {
                if (in_array($it, ['.', '..'])) continue;
                $path = 'storage/principellogos/' . $it;
                $seenPaths[$it] = true; // Mark as seen
                
                // Try to find link from database for this file
                $dbEntry = Medicine::whereNotNull('gambar')
                            ->where('harga', 0)
                            ->where('stok', 0)
                            ->where('terjual', 0)
                            ->where('gambar', 'like', '%' . $it)
                            ->first();
                
                $principalFiles[] = [
                    'type' => 'public', 
                    'path' => $path, 
                    'label' => pathinfo($it, PATHINFO_FILENAME),
                    'link' => $dbEntry?->brand ?? null, // Include link if found in DB
                ];
            }
        }

        // Get additional principal logos from database (with brand links)
        // Only include if: 1) image is from principellogos folder, 2) filename not already in file list
        $dbLogos = Medicine::whereNotNull('gambar')
                    ->where('harga', 0)
                    ->where('stok', 0)
                    ->where('terjual', 0)
                    ->where('gambar', 'like', 'principellogos/%')
                    ->get();
        foreach ($dbLogos as $m) {
            // Extract filename from path (e.g., "principellogos/1234_file.png" -> "1234_file.png")
            $filename = basename($m->gambar);
            
            // Skip if this file was already added from the folder scan
            if (isset($seenPaths[$filename])) {
                continue;
            }
            
            $principalFiles[] = [
                'type' => 'db',
                'path' => $m->gambar,
                'label' => $m->nama_obat ?? 'logo',
                'link' => $m->brand ?? null,
            ];
        }
    ?>

    <?php if(count($principalFiles) > 0): ?>
        <div class="mitra-list-wrap">
            <div class="mitra-grid">
            <?php $__currentLoopData = $principalFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="mitra-card">
                    <?php
                        $link = isset($pf['link']) && $pf['link'] ? $pf['link'] : null;
                    ?>
                    <?php if($pf['type'] === 'public'): ?>
                        <?php if($link): ?>
                            <a href="<?php echo e($link); ?>" target="_blank" rel="noopener noreferrer" style="display:flex;align-items:center;justify-content:center;">
                                <img src="<?php echo e(asset($pf['path'])); ?>" alt="<?php echo e($pf['label']); ?>">
                            </a>
                        <?php else: ?>
                            <img src="<?php echo e(asset($pf['path'])); ?>" alt="<?php echo e($pf['label']); ?>">
                        <?php endif; ?>
                    <?php else: ?>
                        <?php
                            // DB-stored image path may be like 'banners/xxx.png' or 'principellogos/xxx.png'
                            $parts = explode('/', $pf['path'], 2);
                            $folder = $parts[0] ?? null;
                            $filename = $parts[1] ?? $parts[0] ?? '';
                            $url = $folder ? url('/storage/' . $folder . '/' . $filename) : asset($pf['path']);
                        ?>
                        <?php if($link): ?>
                            <a href="<?php echo e($link); ?>" target="_blank" rel="noopener noreferrer" style="display:flex;align-items:center;justify-content:center;">
                                <img src="<?php echo e($url); ?>" alt="<?php echo e($pf['label']); ?>">
                            </a>
                        <?php else: ?>
                            <img src="<?php echo e($url); ?>" alt="<?php echo e($pf['label']); ?>">
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php else: ?>
        <div class="empty-state" style="text-align:center;padding:3rem;border-radius:12px;border:1px solid #e6e6e6;background:#fff;">
            <i class="fa-solid fa-handshake" style="font-size:2.2rem;color:#d1d5db;"></i>
            <h3 style="margin-top:0.75rem;color:#1f2937;">Belum ada mitra terdaftar</h3>
            <p style="color:#6b7280;">Silakan unggah logo mitra melalui admin → Principal Logos atau Admin → Principle Logo.</p>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Ali Attaziri\sumberindofarma\resources\views/mitra/index.blade.php ENDPATH**/ ?>