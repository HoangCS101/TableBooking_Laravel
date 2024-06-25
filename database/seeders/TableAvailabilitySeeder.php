<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Table;
use App\Models\TableAvailability;

class TableAvailabilitySeeder extends Seeder
{
    public function run()
    {
        // Example data for table_availabilities
        $availabilities = [
            [
                'table_id' => 1,
                'date' => '2024-06-30',
                'start_time' => '14:00:00',
                'end_time' => '17:00:00',
                'guest_name' => 'John Doe',
                'pnum' => '555-1234',
            ],
            [
                'table_id' => 2,
                'date' => '2024-07-01',
                'start_time' => '16:30:00',
                'end_time' => '17:30:00',
                'guest_name' => 'Jane Smith',
                'pnum' => '555-5678',
            ],
            // Add more availabilities as needed
        ];

        // Insert data into table_availabilities table
        foreach ($availabilities as $data) {
            // Make sure table_id exists in the 'tables' table
            if (Table::find($data['table_id'])) {
                TableAvailability::create($data);
            }
        }
    }
}
