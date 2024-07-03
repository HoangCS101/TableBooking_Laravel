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
        static $alphabet = range('A', 'Z'); // Static array of letters A to Z
        static $links = [
            'https://www.homestratosphere.com/wp-content/uploads/2014/12/rectangletable1-2048x1414.jpeg',
            'https://static.rigg.uk/Files/casestudies/bistrotpierretables/sz/w960/bistrolargeroundrestauranttablewoodtopmetalbase.jpg',
            'https://www.homestratosphere.com/wp-content/uploads/2014/12/rectangletable2.jpeg',
            'https://www.homestratosphere.com/wp-content/uploads/2014/12/squaretable-870x870.jpg',
            'https://www.homestratosphere.com/wp-content/uploads/2014/12/roundtable.jpeg'
        ];
        static $des = [
            'Real nice table for VIP',
            'Nothing fancy here',
            'Might get food explotano'
        ];
        $description = $des[array_rand($des)];
        // Get the first letter from the alphabet array and remove it
        $tableName = 'Table ' . array_shift($alphabet);
        $tableurl = array_shift($links);
        return [
            'name' => $tableName,
            'description' => $description,
            'picture_url' => $tableurl,
        ];
    }
}
