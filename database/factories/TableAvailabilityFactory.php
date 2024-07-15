<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TableAvailability>
 */
class TableAvailabilityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tableIds = \App\Models\Table::pluck('id')->toArray();
        $futureDate = $this->faker->dateTimeBetween('now', '+30 days')->format('Y-m-d');
        return [
            //
            'table_id' => $this->faker->randomElement($tableIds),
            'guest_name' => $this->faker->name,
            'pnum' => $this->faker->phoneNumber,
            'date' => $futureDate,
            // 'time_slot' => $this->faker->randomElement($timeSlots),
            'timeslot_id' => \App\Models\Timeslot::inRandomOrder()->first(),
        ];
    }
}
