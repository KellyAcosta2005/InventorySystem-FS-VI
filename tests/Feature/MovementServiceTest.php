<?php

use App\Models\Company;
use App\Models\Movement;
use App\Models\Product;
use App\Models\User;
use App\Services\MovementService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

uses(RefreshDatabase::class);

function register(User $user, array $data): Movement
{
    return app(MovementService::class)->register($user, $data);
}

test('registers an entrada movement and increments the product stock', function () {
    $company = Company::factory()->create();
    $user = User::factory()->for($company)->create();
    $product = Product::factory()->for($company)->create(['stock' => 10]);

    $movement = register($user, [
        'product_id' => $product->id,
        'type' => 'entrada',
        'quantity' => 5,
        'supplier' => 'Proveedor A',
        'moved_at' => now()->toDateTimeString(),
    ]);

    expect($movement)->toBeInstanceOf(Movement::class)
        ->and($movement->product_id)->toBe($product->id)
        ->and($movement->quantity)->toBe(5)
        ->and($product->fresh()->stock)->toBe(15);
});

test('registers a salida movement and decrements the product stock', function () {
    $company = Company::factory()->create();
    $user = User::factory()->for($company)->create();
    $product = Product::factory()->for($company)->create(['stock' => 10]);

    $movement = register($user, [
        'product_id' => $product->id,
        'type' => 'salida',
        'quantity' => 4,
        'reason' => 'Venta local',
        'moved_at' => now()->toDateTimeString(),
    ]);

    expect($movement)->toBeInstanceOf(Movement::class)
        ->and($movement->type)->toBe('salida')
        ->and($movement->quantity)->toBe(4)
        ->and($product->fresh()->stock)->toBe(6);
});

test('registers a movement linked to the user company', function () {
    $company = Company::factory()->create();
    $user = User::factory()->for($company)->create();
    $product = Product::factory()->for($company)->create(['stock' => 3]);

    $movement = register($user, [
        'product_id' => $product->id,
        'type' => 'salida',
        'quantity' => 2,
        'reason' => 'Uso interno',
        'moved_at' => now()->toDateTimeString(),
    ]);

    expect($movement->product->company_id)->toBe($user->company_id)
        ->and(Movement::count())->toBe(1);
});

test('rejects a salida movement when stock is insufficient', function () {
    $company = Company::factory()->create();
    $user = User::factory()->for($company)->create();
    $product = Product::factory()->for($company)->create(['stock' => 2]);

    expect(fn () => register($user, [
        'product_id' => $product->id,
        'type' => 'salida',
        'quantity' => 5,
        'reason' => 'Venta local',
        'moved_at' => now()->toDateTimeString(),
    ]))->toThrow(ValidationException::class);

    expect($product->fresh()->stock)->toBe(2)
        ->and(Movement::count())->toBe(0);
});
