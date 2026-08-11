<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Medicine;

class DebugApotkQuery extends Command
{
    protected $signature = 'debug:apotek-query';
    protected $description = 'Debug Apotek Medistra Farma query comparison';

    public function handle()
    {
        $this->info("=== COMPARING ADMIN vs FRONTEND QUERY ===\n");
        
        $selectedOutlet = 'Apotek Medistra Farma';
        $outletNames = ['Alfa Sintang', 'Alfa Air Upas', 'Alfa Kendawangan', 'Alfa Balai Berkuak',
                        'Alfa Nanga Tayap', 'Alfa Tumbang Titi', 'Alfa Sosok', 'Alfa Bodok',
                        'Alfa Kembayan', 'Alfa Ambawang', 'Alfa Jungkat', 'Alfa Mempawah',
                        'Apotek Medistra Farma'];
        
        // ADMIN QUERY
        $this->info("1. ADMIN QUERY (AdminProdukController::index)");
        $adminQuery = Medicine::query()->where('kategori', $selectedOutlet);
        $adminCount = $adminQuery->count();
        $this->info("   Count: $adminCount");
        
        // FRONTEND QUERY (without nonPbf)
        $this->info("\n2. FRONTEND QUERY (without nonPbf)");
        $frontendQuery = Medicine::query()->where(function ($q) use ($selectedOutlet, $outletNames) {
            $q->where('kategori', $selectedOutlet)
              ->orWhereRaw('LOWER(kategori) = ?', [strtolower($selectedOutlet)])
              ->orWhere(function ($global) use ($outletNames) {
                  $global->where('kelompok', 'APOTEK')
                         ->where(function ($notOutlet) use ($outletNames) {
                             $notOutlet->whereNull('kategori')->orWhere('kategori', '');
                             foreach ($outletNames as $outlet) {
                                 $notOutlet->where('kategori', '!=', $outlet);
                             }
                         });
              });
        });
        $frontendCount = $frontendQuery->count();
        $this->info("   Count: $frontendCount");
        
        // FRONTEND QUERY (with nonPbf)
        $this->info("\n3. FRONTEND QUERY (with nonPbf)");
        $frontendNonPbfQuery = Medicine::query()->where(function ($q) use ($selectedOutlet, $outletNames) {
            $q->where('kategori', $selectedOutlet)
              ->orWhereRaw('LOWER(kategori) = ?', [strtolower($selectedOutlet)])
              ->orWhere(function ($global) use ($outletNames) {
                  $global->where('kelompok', 'APOTEK')
                         ->where(function ($notOutlet) use ($outletNames) {
                             $notOutlet->whereNull('kategori')->orWhere('kategori', '');
                             foreach ($outletNames as $outlet) {
                                 $notOutlet->where('kategori', '!=', $outlet);
                             }
                         });
              });
        })->nonPbf();
        $frontendNonPbfCount = $frontendNonPbfQuery->count();
        $this->info("   Count: $frontendNonPbfCount");
        
        // Check nonPbf scope effect
        $this->info("\n4. EFFECT OF nonPbf SCOPE");
        $nonPbfLost = $frontendCount - $frontendNonPbfCount;
        $this->info("   Products filtered by nonPbf: $nonPbfLost");
        
        // Check individual filters
        $this->info("\n5. INDIVIDUAL FILTER RESULTS");
        
        $filter1 = Medicine::where('kategori', $selectedOutlet)->count();
        $this->info("   kategori = 'Apotek Medistra Farma': $filter1");
        
        $filter2 = Medicine::whereRaw('LOWER(kategori) = ?', [strtolower($selectedOutlet)])->count();
        $this->info("   LOWER(kategori) = 'apotek medistra farma': $filter2");
        
        $filter3 = Medicine::where('kelompok', 'APOTEK')->count();
        $this->info("   kelompok = 'APOTEK': $filter3");
        
        // Sample data
        $this->info("\n6. SAMPLE DATA CHECK");
        $samples = Medicine::where('kategori', $selectedOutlet)->limit(3)->get(['id', 'nama_obat', 'kategori', 'kelompok']);
        foreach ($samples as $s) {
            $this->info("   - {$s->nama_obat} | kat={$s->kategori} | kelompok={$s->kelompok}");
        }
        
        $this->info("\n=== END DEBUG ===");
    }
}
