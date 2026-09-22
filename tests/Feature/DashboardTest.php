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
});

test('the dashboard counts only products of the authenticated company', function () {
    /** @var TestCase $this */
    $admin = autor('Administrador', $this->company);
    $otherCompany = Company::factory()->create();

    productFor($this->company, ['stock' => 3]);
    productFor($this->company, ['stock' => 12]);
    productFor($this->company, ['stock' => 5]);
    productFor($otherCompany, ['stock' => 999]);

    $this->actingAs($admin)
        ->get('/dashboard')
        ->assertOk()
        ->assertViewHas('productCount', 3)
        ->assertViewHas('totalStock', 20)
        ->assertViewHas('lowStockCount', 2);
});

test('blocks operators from accessing the dashboard', function () {
    /** @var TestCase $this */
    $operator = autor('Operario', $this->company);

    $this->actingAs($operator)
        ->get('/dashboard')
        ->assertForbidden();
});
