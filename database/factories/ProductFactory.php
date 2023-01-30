<?php

namespace Database\Factories;

use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name(),
            'sub_category_id' => SubCategory::all()->random()->id,
            'status' => $this->faker->randomElement(['draft', 'published']),
            'vendor_id' => User::vendor()->get()->random()->id
        ];
    }
}
