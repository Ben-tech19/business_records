<?php

namespace Database\Factories;

use App\Models\Good;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    public function definition(): array
    {
        $good = Good::factory()->create();
        $quantitySold = $this->faker->numberBetween(1, 10);
        $totalAmount = $quantitySold * $good->selling_price;
        $profit = $quantitySold * ($good->selling_price - $good->buying_price);

        return [
            'good_id' => $good->id,
            'quantity_sold' => $quantitySold,
            'sale_date' => $this->faker->dateTime(),
            'total_amount' => $totalAmount,
            'profit' => $profit,
        ];
    }
}
