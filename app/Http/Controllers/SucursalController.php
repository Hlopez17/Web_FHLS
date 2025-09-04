<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SucursalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Inertia::render('Sucursal/Index', [
            'sucursals' => Sucursal::with('bodegas')->get() // ← Cargar subcategorías relacionadas
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
            'Nombre_Sucursal' => ['required','string','max:255'],
            'Direccion' => ['string','max:255'],
            'Gerente' => ['nullable']
        ],[
            'Nombre_Sucursal.required' => "El campo nombre de sucursal es obligatorio",
            'Nombre_Sucursal.string' => "El campo nombre de sucursal debe ser una cadena de texto",
            'Nombre_Sucursal.max' => "El campo nombre de sucursal debe contener un máximo de 255 caracteres",

            'Direccion.string' => "El campo dirección debe ser una cadena de texto válida",
            'Direccion.max' => "El campo dirección debe contener un máximo de 255 caracteres",
        ]);

        Sucursal::create($validated);

        return redirect()->route('Sucursal.index')
            ->with('success', 'Sucursal creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sucursal $sucursal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sucursal $sucursal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $sucursal = Sucursal::findOrFail($id);

        $validated = $request->validate([
            'Nombre_Sucursal' => ['required','string','max:255'],
            'Direccion' => ['required','max:255'],
            'Gerente' => ['nullable']
                ],[
            'Nombre_Sucursal.required' => "El campo nombre de sucursal es obligatorio",
            'Nombre_Sucursal.string' => "El campo nombre de sucursal debe ser una cadena de texto",
            'Nombre_Sucursal.max' => "El campo nombre de sucursal debe contener un máximo de 255 caracteres",

            'Direccion.required' => "El campo dirección es obligatorio",
            'Direccion.max' => "El campo dirección debe contener un máximo de 255 caracteres",

        ]);

        $sucursal->update($validated);

        return redirect()->route('Sucursal.index')
            ->with('success', 'Sucursal actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $sucursal = Sucursal::findOrFail($id);
        $sucursal->delete();

    return redirect()->route('Sucursal.index')
        ->with('success', 'Sucursal eliminada correctamente');
    }
}
