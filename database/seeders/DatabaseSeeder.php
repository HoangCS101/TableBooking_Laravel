<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Timeslot;
use App\Models\User;
use App\Models\Message;
use App\Models\Chat;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // Role::create(['name' => 'Admin']);
        // Role::create(['name' => 'User']);
        // User::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@ad.min',
        //     'role_id' => '1',
        //     'password' => 'adminpass',
        // ]);
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
        $this->call([
            ChatRoomSeeder::class
        ]);
    }
}
