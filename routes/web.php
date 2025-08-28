<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProductoController;


Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


//Proveedor
Route::middleware(['auth', 'verified'])->group(function(){
Route::get('/Proveedor', [ProveedorController::class, 'index'])->name('Proveedor.Index');});

// Usuario
Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/User', [UserController::class, 'index'])->name('User.index');
// Route::get('/Proveedor/create', [ProveedorController::class, 'create'])->name('Proveedor.create');
// Route::post('/Proveedor', [ProveedorController::class, 'store'])->name('Proveedor.store');
// Route::get('/Proveedor/{employee}/edit', [ProveedorController::class, 'edit'])->name('Proveedor.edit');
// Route::put('/Proveedor/{employee}', [ProveedorController::class, 'update'])->name('Proveedor.update');
// Route::delete('/Proveedor/{employee}', [ProveedorController::class, 'destroy'])->name('Proveedor.destroy');
//prueba
});

// Productos
Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/Producto', [ProductoController::class, 'index'])->name('Productos.Index');

    // Rutas necesarias para crear/editar/eliminar
    Route::get('/Producto/create', [ProductoController::class, 'create'])->name('Productos.create');
    Route::post('/Producto', [ProductoController::class, 'store'])->name('Productos.store');
    Route::get('/Producto/{producto}/edit', [ProductoController::class, 'edit'])->name('Productos.edit');
    Route::put('/Producto/{producto}', [ProductoController::class, 'update'])->name('Productos.update');
    Route::delete('/Producto/{producto}', [ProductoController::class, 'destroy'])->name('Productos.destroy');
});

// Route::get('/Proveedor/create', [ProveedorController::class, 'create'])->name('Proveedor.create');
// Route::post('/Proveedor', [ProveedorController::class, 'store'])->name('Proveedor.store');
// Route::get('/Proveedor/{productos}/edit', [ProveedorController::class, 'edit'])->name('Proveedor.edit');
// Route::put('/Proveedor/{employee}', [ProveedorController::class, 'update'])->name('Proveedor.update');
// Route::delete('/Proveedor/{employee}', [ProveedorController::class, 'destroy'])->name('Proveedor.destroy');


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
