<?php

namespace Tests\Feature;

use App\Models\Good;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GoodControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_goods_index_returns_view(): void
    {
        $response = $this->get('/goods');
        $response->assertStatus(200);
        $response->assertViewIs('goods.index');
    }

    public function test_goods_index_displays_all_goods(): void
    {
        Supplier::factory()->create();
        Good::factory()->count(3)->create();

        $response = $this->get('/goods');
        $response->assertStatus(200);
        $response->assertViewHas('goods');
        $goods = $response->viewData('goods');
        $this->assertCount(3, $goods);
    }

    public function test_good_create_page_returns_view(): void
    {
        Supplier::factory()->create();
        
        $response = $this->get('/goods/create');
        $response->assertStatus(200);
        $response->assertViewIs('goods.create');
        $response->assertViewHas('suppliers');
    }

    public function test_good_show_page_returns_view(): void
    {
        $supplier = Supplier::factory()->create();
        $good = Good::factory()->create(['supplier_id' => $supplier->id]);

        $response = $this->get("/goods/{$good->id}");
        $response->assertStatus(200);
        $response->assertViewIs('goods.show');
        $response->assertViewHas('good', $good);
    }

    public function test_good_edit_page_returns_view(): void
    {
        $supplier = Supplier::factory()->create();
        $good = Good::factory()->create(['supplier_id' => $supplier->id]);

        $response = $this->get("/goods/{$good->id}/edit");
        $response->assertStatus(200);
        $response->assertViewIs('goods.edit');
    }

    public function test_goods_api_returns_json(): void
    {
        Supplier::factory()->create();
        Good::factory()->count(2)->create();

        $response = $this->getJson('/goods');
        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }

    public function test_good_api_show_returns_json(): void
    {
        $supplier = Supplier::factory()->create();
        $good = Good::factory()->create(['supplier_id' => $supplier->id]);

        $response = $this->getJson("/goods/{$good->id}");
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => $good->name]);
    }
}
