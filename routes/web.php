<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\ProductController;
use App\Models\Movement;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $companyId = auth()->user()->company_id;

        return view('dashboard', [
            'productCount' => Product::where('company_id', $companyId)->count(),
            'totalStock' => Product::where('company_id', $companyId)->sum('stock'),
            'lowStockCount' => Product::where('company_id', $companyId)->where('stock', '<=', 5)->count(),
            'stockByCategory' => Product::query()
                ->where('company_id', $companyId)
                ->selectRaw('category, SUM(stock) as total_stock')
                ->groupBy('category')
                ->orderBy('category')
                ->get(),
            'recentMovements' => Movement::with('product')
                ->whereHas('product', fn ($query) => $query->where('company_id', $companyId))
                ->latest('moved_at')
                ->limit(10)
                ->get(),
        ]);
    })->name('dashboard')->middleware('can:manage products');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('products', ProductController::class)
        ->except('show')
        ->middleware('can:manage products');
    Route::resource('movements', MovementController::class)
        ->only(['index', 'store'])
        ->middleware('can:register movements');

    Route::middleware('can:manage operators')->group(function () {
        Route::get('/operators', [OperatorController::class, 'index'])->name('operators.index');
        Route::post('/operators', [OperatorController::class, 'store'])->name('operators.store');
        Route::delete('/operators/{user}', [OperatorController::class, 'destroy'])->name('operators.destroy');
    });
});
