<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = ['Electronics', 'Kitchen', 'Fitness', 'Furniture', 'Beauty', 'Gaming'];
        $adjectives = ['Wireless', 'Smart', 'Portable', 'Rechargeable', 'Ergonomic', 'Waterproof'];
        $products = ['Headphones', 'Blender', 'Treadmill', 'Desk', 'Skincare Set', 'Gaming Mouse'];

        return [
            'name' => $this->faker->randomElement($adjectives) . ' ' .
                  $this->faker->randomElement($products) . ' (' .
                  $this->faker->randomElement($categories) . ')',
            'sku' => $this->faker->unique()->bothify('SKU-######'),
            'price' => $this->faker->randomFloat(2, 10, 500),
        ];
    }
}
