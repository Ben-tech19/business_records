<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class GoodFactory extends Factory
{
    public function definition(): array
    {
        $buyingPrice = $this->faker->randomFloat(2, 5, 50);
        $sellingPrice = $buyingPrice * $this->faker->randomFloat(2, 1.1, 2.0);

        return [
            'name' => $this->faker->word() . ' ' . $this->faker->word(),
            'category' => $this->faker->word(),
            'buying_price' => $buyingPrice,
            'selling_price' => $sellingPrice,
            'stock_quantity' => $this->faker->numberBetween(10, 500),
            'supplier_id' => Supplier::factory(),
        ];
    }
}
