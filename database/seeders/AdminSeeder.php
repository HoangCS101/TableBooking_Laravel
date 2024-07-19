<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@ad.min',
            'email_verified_at' => now(),
            'password' => 'adminpass',
        ])->assignRole('admin');
        User::create([
            'name' => 'random',
            'email' => 'random@ran.dom',
            'email_verified_at' => now(),
            'password' => 'password',
        ])->assignRole('user');
        User::factory(10)->create();
    }
}
