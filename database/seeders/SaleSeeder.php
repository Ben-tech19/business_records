<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sale;

class SaleSeeder extends Seeder
{
    public function run()
    {
        Sale::create(['good_id' => 1, 'quantity_sold' => 10]);
        Sale::create(['good_id' => 2, 'quantity_sold' => 15]);
        Sale::create(['good_id' => 3, 'quantity_sold' => 5]);
    }
}
