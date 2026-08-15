<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class SinglePbfUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * This will remove all users except the PBF account, and create/update the PBF account.
     */
    public function run()
    {
        $email = 'pbf@sumberindopontianak.com';

        // Delete all users except the PBF email
        DB::table('users')->where('email', '!=', $email)->delete();

        // Create or update the PBF user
        $password = 'Pbf@12345'; // Please change after login

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'PBF Admin',
                'username' => 'pbf',
                'password' => $password,
                'role' => 'admin',
            ]
        );

        $this->command->info("Ensured single PBF user exists: {$email} (password: {$password})");
    }
}
