<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@verify.com'],
            [
                'name'     => 'Admin VERIFY',
                'password' => bcrypt('admin123'),
                'role'     => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'user@verify.com'],
            [
                'name'     => 'Demo User',
                'password' => bcrypt('user123'),
                'role'     => 'user',
            ]
        );
    }
}
