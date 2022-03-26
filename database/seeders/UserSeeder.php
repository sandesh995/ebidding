<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name'      => 'Admin',
            'email'     => 'admin@admin.com',
            'password'  => bcrypt('password'),
            'role'      => 'Admin',
            'email_verified_at' => now(),
        ]);

        $user = User::create([
            'name'      => 'User',
            'email'     => 'user@user.com',
            'password'  => bcrypt('password'),
            'role'      => 'User',
            'email_verified_at' => now(),
        ]);
        $user->balances()->create(['amount' => 50_000, 'title' => 'Initial Top-Up']);

        // User 2
        $user = User::create([
            'name'      => 'Hari',
            'email'     => 'hari@user.com',
            'password'  => bcrypt('password'),
            'role'      => 'User',
            'email_verified_at' => now(),
        ]);
        $user->balances()->create(['amount' => 30_000, 'title' => 'Initial Top-Up']);

        // User 3
        $user = User::create([
            'name'      => 'Sita',
            'email'     => 'sita@user.com',
            'password'  => bcrypt('password'),
            'role'      => 'User',
            'email_verified_at' => now(),
        ]);
        $user->balances()->create(['amount' => 60_000, 'title' => 'Initial Top-Up']);

        // User 4
        $user = User::create([
            'name'      => 'Sandesh',
            'email'     => 'sandesh@user.com',
            'password'  => bcrypt('password'),
            'role'      => 'User',
            'email_verified_at' => now(),
        ]);
        $user->balances()->create(['amount' => 1_50_000, 'title' => 'Initial Top-Up']);
    }
}
