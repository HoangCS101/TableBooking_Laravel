<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Message;
use App\Models\Chat;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(TimeslotSeeder::class);
        $chat = Chat::create();
        Message::create([
            'sender_id' => '1',
            'message' => 'Yo Bud',
            'chat_id' => $chat->id,
        ]);
        $this->call(TablesSeeder::class);
        $this->call(TableAvailabilitySeeder::class);
    }
}
