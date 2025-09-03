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
            'unidadmedidas' => Unidadmedida::all() // Tabla de la cual jala datos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Unidadmedida/Index', [ //
            'medida' => Unidadmedida::all() //
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validacion
        $request->validate([
            'Nombre_Medida' => 'required|string|max:250|unique:unidadmedidas,Nombre_Medida'
        ]);

        //Crear la unidad medida
        Unidadmedida::create([
            'Nombre_Medida' => $request->Nombre_Medida,
        ]);

        return redirect()->route('Unidadmedida.index')
            ->with('success', 'Unidad Medida Creada correctamente');
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
        return Inertia::render('Unidadmedida/Edit', [
            'medida' => $unidadmedida
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Unidadmedida $unidadmedida)
    {

        //Validar datos
        $request->validate([
            'Nombre_Medida' => 'required|string|max:250|unique:unidadmedidas,Nombre_Medida,' . $unidadmedida->Id_Medida . ',Id_Medida',
        ]);

        //Actualizar la Medida
        $unidadmedida->update([
            'Nombre_Medida' => $request->Nombre_Medida,
        ]);

        return redirect()->route('Unidadmedida.index')
            ->with('success', 'Unidad Medida actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unidadmedida $unidadmedida)
    {
        if ($unidadmedida->producto()->count() > 0) {
            return redirect()->route('Unidadmedida.index')
                ->with('error', 'No se puede eliminar la unidad medida');
        }

        $unidadmedida->delete();

        return redirect()->route('Unidadmedida.index')
            ->with('success', 'Unidad Medida eliminada correctamente');
    }
}
