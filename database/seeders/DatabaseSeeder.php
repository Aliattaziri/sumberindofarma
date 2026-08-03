<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed admin users
        $this->call(AdminSeeder::class);

        // IMPORTANT:
        // Do not seed demo medicines by default, especially on hosting/production.
        // Run MedicineSeeder manually only when you explicitly need sample data.
        // $this->call(MedicineSeeder::class);

        // Seed news
        $this->call(NewsSeeder::class);
    }
}
