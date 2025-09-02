<?php

namespace App\Http\Controllers;

use App\Models\Unidadmedida;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UnidadmedidaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Inertia::render('Unidadmedida/Index', [ // Pagina que carga
            'unidadmedidas'=> Unidadmedida::all() // Tabla de la cual jala datos
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
    public function show(Unidadmedida $unidadmedida)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unidadmedida $unidadmedida)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unidadmedida $unidadmedida)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unidadmedida $unidadmedida)
    {
        //
    }
}
