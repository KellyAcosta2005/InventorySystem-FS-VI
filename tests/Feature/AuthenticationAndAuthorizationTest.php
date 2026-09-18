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

test('public registration assigns the operator role', function () {
    /** @var TestCase $this */
    $response = $this->post('/register', [
        'name' => 'Operador nuevo',
        'email' => 'operador@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertRedirect('/dashboard');
    expect(User::where('email', 'operador@example.com')->first()?->hasRole('operario'))
        ->toBeTrue();
});

test('an operator can access movements but not products', function () {
    /** @var TestCase $this */
    $user = User::factory()->create();
    $user->assignRole('operario');

    $this->actingAs($user)
        ->get('/movements')
        ->assertOk();

    $this->actingAs($user)
        ->get('/products')
        ->assertForbidden();
});
