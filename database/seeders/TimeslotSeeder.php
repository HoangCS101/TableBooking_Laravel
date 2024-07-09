<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Timeslot;

class TimeslotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timeslots = [
            '07:30 AM - 09:00 AM',
            '09:00 AM - 10:30 AM',
            '10:30 AM - 12:00 PM',
            '12:00 PM - 01:30 PM',
            '01:30 PM - 03:00 PM',
            '03:00 PM - 04:30 PM',
            '04:30 PM - 06:00 PM',
            '06:00 PM - 07:30 PM',
            '07:30 PM - 09:00 PM',
            '09:00 PM - 10:30 PM',
        ];
        $price = ['50000','100000'];
    
        foreach ($timeslots as $slot) {
            Timeslot::create([
                'slot_name' => $slot,
                'price' => $price[array_rand($price)],
            ]);
        }
    }
}
