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
            'picture_url' => 'https://yt3.ggpht.com/-0YGU25OjtDM/AAAAAAAAAAI/AAAAAAAAAAA/Vhjw8Wwnu2w/s900-c-k-no/photo.jpg',
            'password' => 'adminpass',
        ])->assignRole('admin');
        User::create([
            'name' => 'Lone Wolf',
            'email' => 'lonewolf@lone.wolf',
            'email_verified_at' => now(),
            'picture_url' => 'https://th.bing.com/th/id/OIP.z2IW-sFfdWLMJpPWVJ4llwHaG9?rs=1&pid=ImgDetMain',
            'password' => 'password',
        ])->assignRole('user');
        User::factory(10)->create();
    }
}
