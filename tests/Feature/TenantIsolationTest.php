<?php

use App\Models\Company;
use App\Models\Movement;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);

beforeEach(function () {
    /** @var TestCase $this */
    $this->seed(RolePermissionSeeder::class);

    $this->companyA = Company::factory()->create();
    $this->companyB = Company::factory()->create();

    $this->adminA = autor('Administrador', $this->companyA);
});

test('products are only visible to their own company', function () {
    /** @var TestCase $this */
    $productA = productFor($this->companyA, ['name' => 'Torre A']);
    $productB = productFor($this->companyB, ['name' => 'Torre B']);

    $this->actingAs($this->adminA)
        ->get('/products')
        ->assertOk()
        ->assertSee('Torre A')
        ->assertDontSee('Torre B');
});

test('a user cannot edit a product of another company', function () {
    /** @var TestCase $this */
    $productB = productFor($this->companyB, ['name' => 'Torre B']);

    $this->actingAs($this->adminA)
        ->get("/products/{$productB->id}/edit")
        ->assertNotFound();
});

test('movements are isolated to their product’s company', function () {
    /** @var TestCase $this */
    $productA = productFor($this->companyA, ['name' => 'Aislado A']);
    $productB = productFor($this->companyB, ['name' => 'Aislado B']);

    Movement::factory()->create(['product_id' => $productA->id, 'quantity' => 5]);
    Movement::factory()->create(['product_id' => $productB->id, 'quantity' => 9]);

    $this->actingAs($this->adminA)
        ->get('/movements')
        ->assertOk()
        ->assertSee('Aislado A')
        ->assertDontSee('Aislado B');
});

test('a user cannot register a movement for a product of another company', function () {
    /** @var TestCase $this */
    $productB = productFor($this->companyB);

    $this->actingAs($this->adminA)
        ->post('/movements', [
            'product_id' => $productB->id,
            'type' => 'entrada',
            'quantity' => 1,
            'supplier' => 'Proveedor',
            'moved_at' => now()->toDateTimeString(),
        ])
        ->assertSessionHasErrors('product_id');
});
