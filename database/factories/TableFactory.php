<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Table>
 */
class TableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $alphabet = range('A', 'Z');
        $index = $this->faker->numberBetween(0, 25); // Random index from A to Z
        $tableName = 'Table ' . $alphabet[$index];
        return [
            //
            'name' => $tableName,
        ];
    }
}
