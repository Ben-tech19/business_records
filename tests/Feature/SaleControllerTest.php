<?php

namespace Tests\Feature;

use App\Models\Good;
use App\Models\Sale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SaleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_sales_index_returns_view(): void
    {
        $response = $this->get('/sales');
        $response->assertStatus(200);
        $response->assertViewIs('sales.index');
    }

    public function test_sale_create_page_returns_view(): void
    {
        Good::factory()->create();
        
        $response = $this->get('/sales/create');
        $response->assertStatus(200);
        $response->assertViewIs('sales.create');
        $response->assertViewHas('goods');
    }

    public function test_sales_api_returns_json(): void
    {
        $good = Good::factory()->create();
        Sale::factory()->count(2)->for($good, 'good')->create();

        $response = $this->getJson('/sales');
        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }

    public function test_sale_api_show_returns_json(): void
    {
        $good = Good::factory()->create();
        $sale = Sale::factory()->create(['good_id' => $good->id]);

        $response = $this->getJson("/sales/{$sale->id}");
        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'good_id', 'quantity_sold', 'total_amount', 'profit']);
    }
}
