<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Medicine;
use Illuminate\Support\Facades\Auth;

class TestApotkAdminAccess extends Command
{
    protected $signature = 'test:apotek-admin-access';
    protected $description = 'Test Apotek Medistra Farma admin access';

    public function handle()
    {
        $this->info("=== TEST APOTEK MEDISTRA FARMA ADMIN ACCESS ===\n");
        
        // Find user
        $user = User::where('email', 'apotek.medistrafarma@sumberindopontianak.com')->first();
        
        if (!$user) {
            $this->error("ERROR: User dengan email='apotek.medistrafarma@sumberindopontianak.com' tidak ditemukan!");
            return 1;
        }
        
        $this->info("✓ User ditemukan:");
        $this->info("  Email: {$user->email}");
        $this->info("  Outlet: {$user->outlet_name}");
        $this->info("  Is Super Admin: " . ($user->isSuperAdmin() ? 'YES' : 'NO'));
        
        // Simulate user login
        Auth::loginUsingId($user->id);
        $this->info("\n✓ User login simulation berhasil");
        
        // Test admin query (same as AdminProdukController index)
        $baseQuery = Medicine::query();
        $outlet = Auth::user()?->outlet_name;
        
        $this->info("\n  Filtered Query:");
        $this->info("  - Outlet: $outlet");
        
        if ($outlet) {
            $baseQuery->where('kategori', $outlet);
        }
        
        $total = $baseQuery->count();
        $this->info("  - Total Produk: $total");
        
        if ($total > 0) {
            $this->info("\n✓ SUKSES: Admin dapat melihat $total produk!");
            
            $samples = (clone $baseQuery)->limit(3)->get(['id', 'nama_obat']);
            $this->info("\n  Sample Produk:");
            foreach ($samples as $med) {
                $this->info("  - {$med->nama_obat}");
            }
        } else {
            $this->error("\n✗ ERROR: Admin tidak dapat melihat produk!");
        }
        
        // Test frontend query (same as ProductController apotek)
        $this->info("\n\n=== TEST FRONTEND QUERY ===");
        $outletNames = ['Alfa Sintang', 'Alfa Air Upas', 'Alfa Kendawangan', 'Alfa Balai Berkuak',
                        'Alfa Nanga Tayap', 'Alfa Tumbang Titi', 'Alfa Sosok', 'Alfa Bodok',
                        'Alfa Kembayan', 'Alfa Ambawang', 'Alfa Jungkat', 'Alfa Mempawah',
                        'Apotek Medistra Farma'];
        $selectedOutlet = 'Apotek Medistra Farma';
        
        $query = Medicine::query()->where(function ($q) use ($selectedOutlet, $outletNames) {
            $q->where('kategori', $selectedOutlet)
              ->orWhereRaw('LOWER(kategori) = ?', [strtolower($selectedOutlet)]);
        })->nonPbf();
        
        $count = $query->count();
        $this->info("  Produk untuk halaman publik: $count");
        
        if ($count > 0) {
            $this->info("✓ SUKSES: Halaman publik dapat menampilkan $count produk!");
        } else {
            $this->error("✗ ERROR: Halaman publik tidak menampilkan produk!");
        }
        
        $this->info("\n=== END TEST ===\n");
        return 0;
    }
}
