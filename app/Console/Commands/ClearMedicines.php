<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Medicine;
use Illuminate\Support\Facades\DB;

class ClearMedicines extends Command
{
    protected $signature = 'medicines:clear {--force : Skip confirmation}';
    protected $description = 'Clear all medicines from database';

    public function handle()
    {
        if (!$this->option('force')) {
            $this->warn('⚠️  WARNING: Ini akan MENGHAPUS SEMUA produk dari database!');
            $count = Medicine::count();
            $this->info("Total produk yang akan dihapus: $count");
            
            if (!$this->confirm('Lanjutkan penghapusan?')) {
                $this->info('Dibatalkan.');
                return 1;
            }
        }

        try {
            $count = Medicine::count();
            
            // Truncate the table
            DB::table('medicines')->truncate();
            
            $this->info("✅ Berhasil menghapus $count produk dari database.");
            $this->info("Database medicines sekarang kosong.");
            return 0;
        } catch (\Exception $e) {
            $this->error("❌ Error: " . $e->getMessage());
            return 1;
        }
    }
}
