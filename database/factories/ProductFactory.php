<?php

namespace Database\Factories;

use App\Models\Brand;
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
    public function definition(): array
    {
        $brand = rand(1, 100) <= 80
            ? Brand::factory()->create()->id
            : Brand::inRandomOrder()->first()->id ?? Brand::factory()->create()->id;

        return [
            'name' => fake()->words(rand(1, 4), true),
            'description' => fake()->text(),
            'price' => fake()->randomFloat(2, 1, 3000),
            'stock' => fake()->numberBetween(0, 100),
            'brand_id' => $brand,
        ];
    }
}
