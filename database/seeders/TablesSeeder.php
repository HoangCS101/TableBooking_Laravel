<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Table;
use Database\Factories\TableFactory;

class TablesSeeder extends Seeder
{
    public function run()
    {
        Table::factory(10)->create();
    }
}
