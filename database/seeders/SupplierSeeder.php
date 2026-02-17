<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        Supplier::create(['name' => 'Supplier A', 'contact' => 'contactA@example.com']);
        Supplier::create(['name' => 'Supplier B', 'contact' => 'contactB@example.com']);
        Supplier::create(['name' => 'Supplier C', 'contact' => 'contactC@example.com']);
    }
}


