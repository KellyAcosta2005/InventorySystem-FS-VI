<?php

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);

beforeEach(function () {
    /** @var TestCase $this */
    $this->seed(RolePermissionSeeder::class);
});

test('a freshly registered administrator can access products and movements', function () {
    /** @var TestCase $this */
    $this->post('/register', [
        'name' => 'Admin nuevo',
        'email' => 'admin-nuevo@example.com',
        'company_name' => 'Nueva Empresa',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertRedirect('/dashboard');

    $user = User::where('email', 'admin-nuevo@example.com')->first();

    $this->actingAs($user)
        ->get('/products')
        ->assertOk();

    $this->actingAs($user)
        ->get('/movements')
        ->assertOk();
});

test('an operator can access movements but not products', function () {
    /** @var TestCase $this */
    $user = autor('Operario');

    $this->actingAs($user)
        ->get('/movements')
        ->assertOk();

    $this->actingAs($user)
        ->get('/products')
        ->assertForbidden();
});
