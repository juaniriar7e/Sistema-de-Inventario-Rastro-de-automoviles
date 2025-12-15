<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('email', 'admin@admin.com')->exists()) {
            User::create([
                'name'      => 'admin',
                'email'     => 'admin@admin.com',
                'password'  => Hash::make('root2514'),
                'role'      => 'admin',
                'is_active' => true,
            ]);
        }
    }
}

