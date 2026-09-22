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

    $this->company = Company::factory()->create();
    $this->admin = autor('Administrador', $this->company);

    $this->actingAs($this->admin);
});

test('an administrator can create an operator in their company', function () {
    /** @var TestCase $this */
    $this->post('/operators', [
        'name' => 'Oscar Operario',
        'email' => 'oscar@tienda.com',
        'password' => 'password',
    ])->assertRedirect();

    $operator = User::where('email', 'oscar@tienda.com')->first();

    expect($operator)->not->toBeNull()
        ->and($operator->company_id)->toBe($this->company->id)
        ->and($operator->hasRole('Operario'))->toBeTrue();
});

test('administrators only see operators of their own company', function () {
    /** @var TestCase $this */
    $foreignCompany = Company::factory()->create();
    $foreignOperator = autor('Operario', $foreignCompany);

    $this->get('/operators')
        ->assertOk()
        ->assertDontSee($foreignOperator->email);
});

test('an operator cannot access operator management', function () {
    /** @var TestCase $this */
    $operator = autor('Operario', $this->company);

    $this->actingAs($operator)
        ->get('/operators')
        ->assertForbidden();
});

test('an administrator can delete an operator of their company', function () {
    /** @var TestCase $this */
    $operator = autor('Operario', $this->company);

    $this->delete("/operators/{$operator->id}")->assertRedirect();

    expect(User::find($operator->id))->toBeNull();
});

test('an administrator cannot delete an operator of another company', function () {
    /** @var TestCase $this */
    $foreignCompany = Company::factory()->create();
    $foreignOperator = autor('Operario', $foreignCompany);

    $this->delete("/operators/{$foreignOperator->id}")->assertForbidden();

    expect(User::find($foreignOperator->id))->not->toBeNull();
});

test('an administrator cannot delete themselves', function () {
    /** @var TestCase $this */
    $this->delete("/operators/{$this->admin->id}")->assertForbidden();

    expect(User::find($this->admin->id))->not->toBeNull();
});
