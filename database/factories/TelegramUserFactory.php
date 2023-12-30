<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TelegramUser>
 */
class TelegramUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'telegram_id' => fake()->numberBetween(1000, 10000),
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'display_name' => fake()->name,
            'username' => fake()->userName,
            'dob' => fake()->date,
            'gender' => fake()->randomElement(['male', 'female', 'others']),
        ];
    }
}
