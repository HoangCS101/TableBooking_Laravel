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
        TableAvailability::factory(10)->create();
    }
}
