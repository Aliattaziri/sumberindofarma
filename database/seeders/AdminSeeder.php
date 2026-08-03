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
            ['name' => 'admin utama', 'email' => 'sumberindofarmatama1@sumberindopontianak.com', 'password' => Hash::make('sumberindo999'), 'role' => 'admin'],
            ['name' => 'pbf admin', 'email' => 'pbf@sumberindopontianak.com', 'password' => Hash::make('SumberfarmaPBF2026!'), 'role' => 'admin'],
            ['name' => 'alfa sintang', 'email' => 'alfa.sintang@sumberindopontianak.com', 'password' => Hash::make('sumberfarma100'), 'role' => 'admin'],
            ['name' => 'alfa airupas', 'email' => 'alfa.airupas@sumberindopontianak.com', 'password' => Hash::make('sumberfarma101'), 'role' => 'admin'],
            ['name' => 'alfa kendawangan', 'email' => 'alfa.kendawangan@sumberindopontianak.com', 'password' => Hash::make('sumberfarma102'), 'role' => 'admin'],
            ['name' => 'alfa balaiberkuak', 'email' => 'alfa.balaiberkuak@sumberindopontianak.com', 'password' => Hash::make('sumberfarma103'), 'role' => 'admin'],
            ['name' => 'alfa nangatayap', 'email' => 'alfa.nangatayap@sumberindopontianak.com', 'password' => Hash::make('sumberfarma104'), 'role' => 'admin'],
            ['name' => 'alfa tumbangtiti', 'email' => 'alfa.tumbangtiti@sumberindopontianak.com', 'password' => Hash::make('sumberfarma105'), 'role' => 'admin'],
            ['name' => 'alfa sosok', 'email' => 'alfa.sosok@sumberindopontianak.com', 'password' => Hash::make('sumberfarma106'), 'role' => 'admin'],
            ['name' => 'alfa bodok', 'email' => 'alfa.bodok@sumberindopontianak.com', 'password' => Hash::make('sumberfarma107'), 'role' => 'admin'],
            ['name' => 'alfa kembayan', 'email' => 'alfa.kembayan@sumberindopontianak.com', 'password' => Hash::make('sumberfarma108'), 'role' => 'admin'],
            ['name' => 'alfa ambawang', 'email' => 'alfa.ambawang@sumberindopontianak.com', 'password' => Hash::make('sumberfarma109'), 'role' => 'admin'],
            ['name' => 'alfa jungkat', 'email' => 'alfa.jungkat@sumberindopontianak.com', 'password' => Hash::make('sumberfarma110'), 'role' => 'admin'],
            ['name' => 'alfa mempawah', 'email' => 'alfa.mempawah@sumberindopontianak.com', 'password' => Hash::make('sumberfarma111'), 'role' => 'admin'],
            ['name' => 'apotek medistrafarma', 'email' => 'apotek.medistrafarma@sumberindopontianak.com', 'password' => Hash::make('sumberfarma113'), 'role' => 'admin'],
        ];

        foreach ($admins as $admin) {
            User::updateOrCreate(
                ['email' => $admin['email']],
                $admin
            );
        }
    }
}

