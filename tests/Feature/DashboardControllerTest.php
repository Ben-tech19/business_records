<?php

namespace Tests\Feature;

use App\Models\Good;
use App\Models\Sale;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_returns_view(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('home');
    }

    public function test_dashboard_displays_correct_stats(): void
    {
        $suppliers = Supplier::factory()->count(3)->create();
        $supplier = $suppliers->first();
        Good::factory()->count(5)->create(['supplier_id' => $supplier->id]);
        $good = Good::first();
        Sale::factory()->count(4)->for($good, 'good')->create();

        $response = $this->get('/');

        $response->assertViewHas('totalSuppliers');
        $response->assertViewHas('totalGoods');
        $response->assertViewHas('totalSales');
    }

    public function test_dashboard_calculates_total_revenue(): void
    {
        $good = Good::factory()->create([
            'selling_price' => 100.00,
            'buying_price' => 50.00,
        ]);
        Sale::factory()->count(2)->for($good, 'good')->create(['total_amount' => 100.00]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewHas('totalRevenue');
    }

    public function test_dashboard_displays_recent_sales(): void
    {
        $good = Good::factory()->create();
        Sale::factory()->count(3)->for($good, 'good')->create();

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewHas('recentSales');
    }

    public function test_dashboard_empty_state(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewHas('totalSuppliers', 0);
        $response->assertViewHas('totalGoods', 0);
        $response->assertViewHas('totalSales', 0);
    }
}
