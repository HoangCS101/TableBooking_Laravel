<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Table;

class TablesSeeder extends Seeder
{
    public function run()
    {
        // Sample data for tables
        $tables = [
            ['name' => 'Table A'],
            ['name' => 'Table B'],
            ['name' => 'Table C'],
            // Add more tables as needed
        ];

        // Insert data into tables table
        foreach ($tables as $tableData) {
            Table::create($tableData);
        }
    }
}
