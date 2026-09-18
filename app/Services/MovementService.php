<?php

namespace App\Services;

use App\Models\Movement;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MovementService
{
    public function register(array $data): Movement
    {
        $data['moved_at'] = Carbon::parse($data['moved_at'], config('app.timezone'));

        return DB::transaction(function () use ($data) {
            $product = Product::query()
                ->lockForUpdate()
                ->findOrFail($data['product_id']);

            if ($data['type'] === 'salida' && $product->stock < $data['quantity']) {
                throw ValidationException::withMessages([
                    'quantity' => "Stock insuficiente. Disponible: {$product->stock}.",
                ]);
            }

            $data['type'] === 'entrada'
                ? $product->increment('stock', $data['quantity'])
                : $product->decrement('stock', $data['quantity']);

            return Movement::create($data);
        }, attempts: 3);
    }
}
