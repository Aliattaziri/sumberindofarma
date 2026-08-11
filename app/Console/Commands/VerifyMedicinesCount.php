<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Medicine;

class VerifyMedicinesCount extends Command
{
    protected $signature = 'medicines:count';
    protected $description = 'Show total medicines in database';

    public function handle()
    {
        $count = Medicine::count();
        $this->info("Total produk di database: $count");
        
        if ($count === 0) {
            $this->info("✅ Database kosong.");
        } else {
            $this->warn("⚠️  Database masih berisi $count produk.");
        }
    }
}
