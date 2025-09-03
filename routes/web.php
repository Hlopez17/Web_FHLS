<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\SubcategoriaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UnidadmedidaController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// Dashboard
Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Proveedor
Route::middleware(['auth', 'verified'])->group(function () {
    // Listar proveedores
    Route::get('/Proveedor', [ProveedorController::class, 'index'])->name('Proveedor.index');
    // Crear proveedor
    Route::post('/proveedores', [ProveedorController::class, 'store'])->name('Proveedor.store');
    // Actualizar proveedor
    Route::put('/proveedores/{proveedor}', [ProveedorController::class, 'update'])->name('Proveedor.update');
    // Eliminar proveedor
    Route::delete('/proveedores/{proveedor}', [ProveedorController::class, 'destroy'])->name('Proveedor.destroy');
});

// Usuario
Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/User', [UserController::class, 'index'])->name('User.index');
    Route::resource('usuarios', UserController::class);
});

// Productos
Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/Producto', [ProductoController::class, 'index'])->name('Producto.index');
    Route::get('/Producto/create', [ProductoController::class, 'create'])->name('Producto.create');
    Route::post('/Producto', [ProductoController::class, 'store'])->name('Producto.store');
    Route::get('/Producto/{producto}/edit', [ProductoController::class, 'edit'])->name('Producto.edit');
    Route::put('/Producto/{producto}', [ProductoController::class, 'update'])->name('Producto.update');
    Route::delete('/Producto/{producto}', [ProductoController::class, 'destroy'])->name('Producto.destroy');
});

// Categorías
Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/Categoria', [CategoriaController::class, 'index'])->name('Categoria.index');
});

// Subcategorías
Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/Subcategoria', [SubcategoriaController::class, 'index'])->name('Subcategoria.index');
});

// Roles
Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/Rol', [RolController::class, 'index'])->name('Rol.index');
    Route::get('/Rol/create', [RolController::class, 'create'])->name('Rol.create');
    Route::post('/Rol', [RolController::class, 'store'])->name('Rol.store');
    Route::get('/Rol/{rol}/edit', [RolController::class, 'edit'])->name('Rol.edit');
    Route::put('/Rol/{rol}', [RolController::class, 'update'])->name('Rol.update');
    Route::delete('/Rol/{rol}', [RolController::class, 'destroy'])->name('Rol.destroy');
});

// Medidas
Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/Unidadmedida', [UnidadmedidaController::class, 'index'])->name('Unidadmedida.index');
    Route::get('/Unidadmedida/create', [UnidadmedidaController::class, 'create'])->name('Unidadmedida.create');
    Route::post('/Unidadmedida', [UnidadmedidaController::class, 'store'])->name('Unidadmedida.store');
    Route::get('/Unidadmedida/{unidadmedida}/edit', [UnidadmedidaController::class, 'edit'])->name('Unidadmedida.edit');
    Route::put('/Unidadmedida/{unidadmedida}', [UnidadmedidaController::class, 'update'])->name('Unidadmedida.update');
    Route::delete('/Unidadmedida/{unidadmedida}', [UnidadmedidaController::class, 'destroy'])->name('Unidadmedida.destroy');
});

// Extra
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
