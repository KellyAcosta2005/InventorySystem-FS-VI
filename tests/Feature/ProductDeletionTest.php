<?php

use App\Models\Company;
use App\Models\Movement;
use App\Models\Product;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);

beforeEach(function () {
    /** @var TestCase $this */
    $this->seed(RolePermissionSeeder::class);

    $this->company = Company::factory()->create();
    $this->admin = autor('Administrador', $this->company);
});

test('allows deleting a product without movements', function () {
    /** @var TestCase $this */
    $product = productFor($this->company);

    $this->actingAs($this->admin)
        ->delete("/products/{$product->id}")
        ->assertRedirect(route('products.index'));

    expect(Product::find($product->id))->toBeNull();
});

test('blocks deleting a product that has registered movements', function () {
    /** @var TestCase $this */
    $product = productFor($this->company);

    Movement::factory()->create(['product_id' => $product->id]);

    $this->actingAs($this->admin)
        ->delete("/products/{$product->id}")
        ->assertStatus(422);

    expect(Product::find($product->id))->not->toBeNull();
});
