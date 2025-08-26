<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProveedorController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


//Proveedor
Route::middleware(['auth', 'verified'])->group(function(){
Route::get('/Proveedor', [ProveedorController::class, 'index'])->name('Proveedor.Index');});

// Ruta de Usuario
Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/User', [UserController::class, 'index'])->name('User.index');
// Route::get('/Proveedor/create', [ProveedorController::class, 'create'])->name('Proveedor.create');
// Route::post('/Proveedor', [ProveedorController::class, 'store'])->name('Proveedor.store');
// Route::get('/Proveedor/{employee}/edit', [ProveedorController::class, 'edit'])->name('Proveedor.edit');
// Route::put('/Proveedor/{employee}', [ProveedorController::class, 'update'])->name('Proveedor.update');
// Route::delete('/Proveedor/{employee}', [ProveedorController::class, 'destroy'])->name('Proveedor.destroy');
//prueba
});

















































































































































// Route::get('/Proveedor/create', [ProveedorController::class, 'create'])->name('Proveedor.create');
// Route::post('/Proveedor', [ProveedorController::class, 'store'])->name('Proveedor.store');
// Route::get('/Proveedor/{employee}/edit', [ProveedorController::class, 'edit'])->name('Proveedor.edit');
// Route::put('/Proveedor/{employee}', [ProveedorController::class, 'update'])->name('Proveedor.update');
// Route::delete('/Proveedor/{employee}', [ProveedorController::class, 'destroy'])->name('Proveedor.destroy');


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
