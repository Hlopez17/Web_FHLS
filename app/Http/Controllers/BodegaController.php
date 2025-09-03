<?php

namespace App\Http\Controllers;

use App\Models\Bodega;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BodegaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Inertia::render('Bodega/Index', [
            'bodegas' => Bodega::all(),
            'sucursals' => Sucursal::all() // ← Agregar las categorías aquí
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Bodega $bodega)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bodega $bodega)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bodega $bodega)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bodega $bodega)
    {
        //
    }
}
