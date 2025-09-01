<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RolController;




Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

//dashboard
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

// Ruta de Usuario
Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/User', [UserController::class, 'index'])->name('User.index');
    Route::resource('usuarios', UserController::class);

});


//Productos
Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/Producto', [ProductoController::class, 'index'])->name('Producto.index');
    Route::get('/Producto/create', [ProductoController::class, 'create'])->name('Producto.create');
    Route::post('/Producto', [ProductoController::class, 'store'])->name('Producto.store');
    Route::get('/Producto/{producto}/edit', [ProductoController::class, 'edit'])->name('Producto.edit');
    Route::put('/Producto/{producto}', [ProductoController::class, 'update'])->name('Producto.update');
    Route::delete('/Producto/{producto}', [ProductoController::class, 'destroy'])->name('Producto.destroy');
});

// Ruta de Categorias
Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/Categoria', [CategoriaController::class, 'index'])->name('Categoria.index');
});

// Ruta de Roles
Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/Rol', [RolController::class, 'index'])->name('Rol.index');
    Route::resource('roles', RolController::class);

});

// Route::get('/Proveedor/create', [ProveedorController::class, 'create'])->name('Proveedor.create');
// Route::post('/Proveedor', [ProveedorController::class, 'store'])->name('Proveedor.store');
// Route::get('/Proveedor/{productos}/edit', [ProveedorController::class, 'edit'])->name('Proveedor.edit');
// Route::put('/Proveedor/{employee}', [ProveedorController::class, 'update'])->name('Proveedor.update');
// Route::delete('/Proveedor/{employee}', [ProveedorController::class, 'destroy'])->name('Proveedor.destroy');
//});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
