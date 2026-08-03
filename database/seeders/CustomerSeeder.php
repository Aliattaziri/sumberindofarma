<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        // Customer seed dinonaktifkan. Jika ada data lama, bersihkan.
        User::where('username', 'Customer')
            ->orWhere('email', 'customer@sumberindopontianak.com')
            ->orWhere('email', 'customer@sumberindofarmatama.com')
            ->delete();
    }
}
