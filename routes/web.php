<?php

use App\Http\Controllers\MovementController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Ruta para la vista del Dashboard (asigna el nombre 'dashboard' que usa la plantilla base)
Route::get('/dashboard', function () {
    return view('welcome');
})->name('dashboard');

// Redirección de la raíz del sitio hacia /dashboard
Route::redirect('/', '/dashboard');

// Recurso de Productos
Route::resource('products', ProductController::class)->except('show');

// Recurso de Movimientos (versión optimizada)
Route::resource('movements', MovementController::class)->only(['index', 'store']);