<?php

use App\Livewire\Login;
use App\Models\Company;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

uses(RefreshDatabase::class);

beforeEach(function () {
    /** @var TestCase $this */
    $this->seed(RolePermissionSeeder::class);

    $this->session([]);

    $this->company = Company::factory()->create();
});

test('renders the login page with the livewire component', function () {
    $this->get('/login')
        ->assertOk()
        ->assertSeeLivewire('login');
});

test('logs in an administrator and redirects to the dashboard', function () {
    $admin = autor('Administrador', $this->company);

    Livewire::test(Login::class)
        ->set('email', $admin->email)
        ->set('password', 'password')
        ->call('login')
        ->assertHasNoErrors()
        ->assertRedirect(route('dashboard'));

    $this->assertAuthenticatedAs($admin);
});

test('logs in an operator and redirects to the movements index', function () {
    $operator = autor('Operario', $this->company);

    Livewire::test(Login::class)
        ->set('email', $operator->email)
        ->set('password', 'password')
        ->call('login')
        ->assertHasNoErrors()
        ->assertRedirect(route('movements.index'));

    $this->assertAuthenticatedAs($operator);
});

test('shows an error with invalid credentials', function () {
    $admin = autor('Administrador', $this->company);

    Livewire::test(Login::class)
        ->set('email', $admin->email)
        ->set('password', 'incorrecta')
        ->call('login')
        ->assertHasErrors(['email' => 'Las credenciales proporcionadas no son válidas.']);

    $this->assertGuest();
});

test('requires email and password', function () {
    Livewire::test(Login::class)
        ->set('email', '')
        ->set('password', '')
        ->call('login')
        ->assertHasErrors(['email' => 'required', 'password' => 'required']);

    $this->assertGuest();

    expect(User::count())->toBe(0);
});
