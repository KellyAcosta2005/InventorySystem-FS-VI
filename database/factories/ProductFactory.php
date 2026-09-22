<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
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
        return [
            'name' => fake()->words(2, true),
            'description' => fake()->sentence(),
            'sku' => fake()->unique()->numerify('SKU-####'),
            'category' => fake()->word(),
            'stock' => fake()->numberBetween(0, 100),
            'company_id' => Company::factory(),
        ];
    }
}
