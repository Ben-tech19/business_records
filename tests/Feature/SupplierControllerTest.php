<?php

namespace Tests\Feature;

use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupplierControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_suppliers_index_returns_view(): void
    {
        $response = $this->get('/suppliers');
        $response->assertStatus(200);
        $response->assertViewIs('suppliers.index');
    }

    public function test_suppliers_index_displays_all_suppliers(): void
    {
        Supplier::factory()->count(3)->create();

        $response = $this->get('/suppliers');
        $response->assertStatus(200);
        $response->assertViewHas('suppliers');
        $suppliers = $response->viewData('suppliers');
        $this->assertCount(3, $suppliers);
    }

    public function test_supplier_create_page_returns_view(): void
    {
        $response = $this->get('/suppliers/create');
        $response->assertStatus(200);
        $response->assertViewIs('suppliers.create');
    }

    public function test_supplier_show_page_returns_view(): void
    {
        $supplier = Supplier::factory()->create();

        $response = $this->get("/suppliers/{$supplier->id}");
        $response->assertStatus(200);
        $response->assertViewIs('suppliers.show');
        $response->assertViewHas('supplier', $supplier);
    }

    public function test_supplier_edit_page_returns_view(): void
    {
        $supplier = Supplier::factory()->create();

        $response = $this->get("/suppliers/{$supplier->id}/edit");
        $response->assertStatus(200);
        $response->assertViewIs('suppliers.edit');
    }

    public function test_suppliers_api_returns_json(): void
    {
        Supplier::factory()->count(2)->create();

        $response = $this->getJson('/suppliers');
        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }

    public function test_supplier_api_show_returns_json(): void
    {
        $supplier = Supplier::factory()->create();

        $response = $this->getJson("/suppliers/{$supplier->id}");
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => $supplier->name]);
    }
}
