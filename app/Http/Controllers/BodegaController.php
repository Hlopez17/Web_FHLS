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
        $validated = $request->validate([
            'Nombre_bodega' => ['required','string','max:255'],
            'Direccion' => ['string','max:255'],
            'Idsucursal' => ['required']
        ],[
            'Nombre_bodega.required' => "El campo nombre de bodega es obligatorio",
            'Nombre_bodega.string' => "El campo nombre de bodega debe ser una cadena de texto",
            'Nombre_bodega.max' => "El campo nombre de bodega debe contener un máximo de 255 caracteres",

            'Direccion.string' => "El campo dirección debe ser una cadena de texto válida",
            'Direccion.max' => "El campo dirección debe contener un máximo de 255 caracteres",

            'Idsucursal.required' => "El campo sucursal es obligatorio"
        ]);

        Bodega::create($validated);

        return redirect()->route('Bodega.index')
            ->with('success', 'Bodega creada exitosamente');
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
    public function update(Request $request, string $id)
    {
         $bodega = Bodega::findOrFail($id);

        $validated = $request->validate([
            'Nombre_bodega' => ['required','string','max:255'],
            'Direccion' => ['string','max:255'],
            'Idsucursal' => ['required']
        ],[
            'Nombre_bodega.required' => "El campo nombre de bodega es obligatorio",
            'Nombre_bodega.string' => "El campo nombre de bodega debe ser una cadena de texto",
            'Nombre_bodega.max' => "El campo nombre de bodega debe contener un máximo de 255 caracteres",

            'Direccion.string' => "El campo dirección debe ser una cadena de texto válida",
            'Direccion.max' => "El campo dirección debe contener un máximo de 255 caracteres",

            'Idsucursal.required' => "El campo sucursal es obligatorio"
        ]);

         $bodega->update($validated);

        return redirect()->route('Bodega.index')
            ->with('success', 'Bodega creada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
    $bodega = Bodega::findOrFail($id);
    $bodega->delete();

    return redirect()->route('Bodega.index')
        ->with('success', 'Bodega eliminada correctamente');
    }
}
