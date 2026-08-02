<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'Customer'],
            [
                'name'     => 'Customer',
                'username' => 'Customer',
                'email'    => 'customer@sumberindofarmatama.com',
                'password' => Hash::make('Sumberindo Farma Tama'),
                'role'     => 'user',
            ]
        );
    }
}

