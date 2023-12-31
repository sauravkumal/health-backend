<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Record>
 */
class RecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'sleep_hours' => fake()->numberBetween(4, 8),
            'exercise_duration' => fake()->numberBetween(3, 6),
            'water_intake' => fake()->numberBetween(1, 3),
            'date' => fake()->date,
        ];
    }
}
