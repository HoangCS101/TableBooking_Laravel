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
        // $timeSlots = [
        //     '07:30 AM - 09:00 AM',
        //     '09:00 AM - 10:30 AM',
        //     '10:30 AM - 12:00 PM',
        //     '12:00 PM - 01:30 PM',
        //     '01:30 PM - 03:00 PM',
        //     '03:00 PM - 04:30 PM',
        //     '04:30 PM - 06:00 PM',
        //     '06:00 PM - 07:30 PM',
        //     '07:30 PM - 09:00 PM',
        //     '09:00 PM - 10:30 PM',
        // ];
        
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
