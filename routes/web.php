<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\ProductController;
use App\Models\Movement;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard', [
            'productCount' => Product::count(),
            'totalStock' => Product::sum('stock'),
            'lowStockCount' => Product::where('stock', '<=', 5)->count(),
            'stockByCategory' => Product::query()
                ->selectRaw('category, SUM(stock) as total_stock')
                ->groupBy('category')
                ->orderBy('category')
                ->get(),
            'recentMovements' => Movement::with('product')
                ->latest('moved_at')
                ->limit(10)
                ->get(),
        ]);
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('products', ProductController::class)
        ->except('show')
        ->middleware('can:manage products');
    Route::resource('movements', MovementController::class)
        ->only(['index', 'store'])
        ->middleware('can:register movements');
});
