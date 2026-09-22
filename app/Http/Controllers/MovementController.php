<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovementRequest;
use App\Models\Movement;
use App\Models\Product;
use App\Services\MovementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MovementController extends Controller
{
    public function index(Request $request): View
    {
        $companyId = auth()->user()->company_id;

        $movements = Movement::with('product')
            ->whereHas('product', fn ($query) => $query->where('company_id', $companyId))
            ->when($request->filled('type'), fn ($query) => $query->where('type', $request->string('type'))
            )
            ->when($request->filled('product_id'), fn ($query) => $query->where('product_id', $request->integer('product_id'))
            )
            ->latest('moved_at')
            ->paginate(15)
            ->withQueryString();

        return view('movements.index', [
            'movements' => $movements,
            'products' => Product::where('company_id', $companyId)->orderBy('name')->get(),
        ]);
    }

    public function store(StoreMovementRequest $request, MovementService $service): RedirectResponse
    {
        $service->register($request->validated(), auth()->user()->company_id);

        return to_route('movements.index')->with('status', 'Movimiento registrado');
    }
}
