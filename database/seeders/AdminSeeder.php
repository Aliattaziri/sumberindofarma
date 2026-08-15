<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            ['name' => 'pbf admin', 'email' => 'pbf@sumberindopontianak.com', 'password' => Hash::make('SumberfarmaPBF2026!'), 'role' => 'admin'],
            ];

        foreach ($admins as $admin) {
            User::updateOrCreate(
                ['email' => $admin['email']],
                $admin
            );
        }
    }
}

