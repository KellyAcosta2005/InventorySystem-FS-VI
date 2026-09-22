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

    $this->company = Company::factory()->create();
    $this->admin = autor('Administrador', $this->company);

    $entranceProduct = productFor($this->company, ['name' => 'Filtro Entrada']);
    $exitProduct = productFor($this->company, ['name' => 'Filtro Salida']);

    Movement::factory()->create(['product_id' => $entranceProduct->id, 'type' => 'entrada']);
    Movement::factory()->create(['product_id' => $exitProduct->id, 'type' => 'salida']);
});

test('filters the movement history by entrada', function () {
    /** @var TestCase $this */
    $response = $this->actingAs($this->admin)
        ->get('/movements?type=entrada')
        ->assertOk();

    $movements = $response->viewData('movements');

    expect($movements->total())->toBe(1)
        ->and($movements->first()->type)->toBe('entrada');
});

test('filters the movement history by salida', function () {
    /** @var TestCase $this */
    $response = $this->actingAs($this->admin)
        ->get('/movements?type=salida')
        ->assertOk();

    $movements = $response->viewData('movements');

    expect($movements->total())->toBe(1)
        ->and($movements->first()->type)->toBe('salida');
});
