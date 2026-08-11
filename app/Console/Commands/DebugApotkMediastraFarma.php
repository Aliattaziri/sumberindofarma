<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Medicine;

class DebugApotkMediastraFarma extends Command
{
    protected $signature = 'debug:apotek-medistra';
    protected $description = 'Debug Apotek Medistra Farma issue';

    public function handle()
    {
        $this->info("=== DEBUG APOTEK MEDISTRA FARMA ===");
        
        $this->info("\n1. USERS WITH APOTEK MEDISTRA FARMA OUTLET:");
        $users = User::where('outlet_name', 'Apotek Medistra Farma')->get();
        if ($users->isEmpty()) {
            $this->error("   No users found with outlet_name='Apotek Medistra Farma'");
        } else {
            foreach ($users as $user) {
                $this->info("   - ID: {$user->id}, Email: {$user->email}");
            }
        }
        
        $this->info("\n2. ALL USERS:");
        $allUsers = User::select('id', 'email', 'outlet_name')->get();
        foreach ($allUsers as $user) {
            $this->info("   - {$user->email} => {$user->outlet_name}");
        }
        
        $this->info("\n3. PRODUCTS WITH KATEGORI='Apotek Medistra Farma':");
        $count = Medicine::where('kategori', 'Apotek Medistra Farma')->count();
        $this->info("   Total: $count");
        
        if ($count > 0) {
            $samples = Medicine::where('kategori', 'Apotek Medistra Farma')->limit(5)->get(['id', 'nama_obat', 'kategori', 'kelompok']);
            foreach ($samples as $med) {
                $this->info("   - ID: {$med->id}, Nama: {$med->nama_obat}");
            }
        }
        
        $this->info("\n4. TESTING QUERY (nonPbf filter):");
        $count2 = Medicine::where('kategori', 'Apotek Medistra Farma')->nonPbf()->count();
        $this->info("   After nonPbf(): $count2");
        
        $this->info("\n5. TESTING PRODUCT VIEW QUERY:");
        $outletNames = ['Alfa Sintang', 'Alfa Air Upas', 'Alfa Kendawangan', 'Alfa Balai Berkuak',
                        'Alfa Nanga Tayap', 'Alfa Tumbang Titi', 'Alfa Sosok', 'Alfa Bodok',
                        'Alfa Kembayan', 'Alfa Ambawang', 'Alfa Jungkat', 'Alfa Mempawah',
                        'Apotek Medistra Farma'];
        $selectedOutlet = 'Apotek Medistra Farma';
        
        $query = Medicine::query()->where(function ($q) use ($selectedOutlet, $outletNames) {
            $q->where('kategori', $selectedOutlet)
              ->orWhereRaw('LOWER(kategori) = ?', [strtolower($selectedOutlet)]);
        })->nonPbf();
        
        $count3 = $query->count();
        $this->info("   Count: $count3");
        
        if ($count3 == 0) {
            $this->error("   WARNING: Query returns 0 products!");
            $this->info("   SQL: " . $query->toSql());
            $this->info("   Bindings: " . json_encode($query->getBindings()));
        }
        
        $this->info("\n=== END DEBUG ===");
    }
}
