<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Good;

class GoodSeeder extends Seeder
{
    public function run()
    {
        Good::create([
            'name' => 'Product 1',
            'category' => 'Category A',
            'buying_price' => 50,
            'selling_price' => 70,
            'stock_quantity' => 100,
            'supplier_id' => 1
        ]);

        Good::create([
            'name' => 'Product 2',
            'category' => 'Category B',
            'buying_price' => 30,
            'selling_price' => 45,
            'stock_quantity' => 200,
            'supplier_id' => 2
        ]);

        Good::create([
            'name' => 'Product 3',
            'category' => 'Category C',
            'buying_price' => 20,
            'selling_price' => 35,
            'stock_quantity' => 150,
            'supplier_id' => 3
        ]);
    }
}
