<?php

use App\Models\Company;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);

beforeEach(function () {
    /** @var TestCase $this */
    $this->seed(RolePermissionSeeder::class);

    $this->company = Company::factory()->create();
    $this->actingAs(autor('Administrador', $this->company));

    productFor($this->company, ['name' => 'Refrigerador', 'sku' => 'SKU-1001', 'category' => 'LineaBlanca']);
    productFor($this->company, ['name' => 'Licuadora', 'sku' => 'SKU-2002', 'category' => 'Pequeños']);

    $foreignCompany = Company::factory()->create();
    productFor($foreignCompany, ['name' => 'Aire Acondicionado', 'sku' => 'SKU-9001', 'category' => 'Clima']);
});

test('filters products by name', function () {
    /** @var TestCase $this */
    $this->get('/products?search=Refrigerador')
        ->assertOk()
        ->assertSee('Refrigerador')
        ->assertDontSee('Licuadora');
});

test('filters products by sku', function () {
    /** @var TestCase $this */
    $this->get('/products?search=SKU-2002')
        ->assertOk()
        ->assertSee('Licuadora')
        ->assertDontSee('Refrigerador');
});

test('filters products by category', function () {
    /** @var TestCase $this */
    $this->get('/products?search=LineaBlanca')
        ->assertOk()
        ->assertSee('Refrigerador')
        ->assertDontSee('Licuadora');
});

test('does not list products from other companies', function () {
    /** @var TestCase $this */
    $this->get('/products')
        ->assertOk()
        ->assertDontSee('Aire Acondicionado');
});
