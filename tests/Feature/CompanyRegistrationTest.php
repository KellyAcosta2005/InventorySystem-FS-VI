<?php

use App\Models\Company;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(RefreshDatabase::class);

beforeEach(function () {
    /** @var TestCase $this */
    $this->seed(RolePermissionSeeder::class);
});

test('registration creates a company with its first administrator', function () {
    /** @var TestCase $this */
    $response = $this->post('/register', [
        'name' => 'Ana Gómez',
        'email' => 'ana@tienda.com',
        'company_name' => 'Tienda de Ana',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertRedirect('/dashboard');

    $user = User::where('email', 'ana@tienda.com')->first();

    expect($user)->not->toBeNull()
        ->and($user->hasRole('Administrador'))->toBeTrue()
        ->and($user->company->name)->toBe('Tienda de Ana');

    expect(Company::where('name', 'Tienda de Ana')->count())->toBe(1);
});

test('registration requires the company, name, email and password', function () {
    /** @var TestCase $this */
    $this->post('/register', [])
        ->assertSessionHasErrors(['company_name', 'name', 'email', 'password']);
});

test('registration rejects an email that is already registered', function () {
    /** @var TestCase $this */
    User::factory()->create(['email' => 'ocupado@example.com']);

    $this->post('/register', [
        'name' => 'Otra Persona',
        'email' => 'ocupado@example.com',
        'company_name' => 'Otra Empresa',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertSessionHasErrors('email');
});
