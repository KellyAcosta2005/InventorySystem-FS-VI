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

test('a guest hitting the root is redirected to the dashboard', function () {
    $this->get('/')->assertRedirect('/dashboard');
});

test('an administrator hitting the root is redirected to the dashboard', function () {
    $admin = autor('Administrador', $this->company);

    $this->actingAs($admin)
        ->get('/')
        ->assertRedirect(route('dashboard'));
});

test('an operator hitting the root is redirected to the movements index', function () {
    $operator = autor('Operario', $this->company);

    $this->actingAs($operator)
        ->get('/')
        ->assertRedirect(route('movements.index'));
});
