<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Inertia::render('Roles/Index', [ // 
            'rols' => Rol::all() //  
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Roles/Crear');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'nombre' => 'required|string|max:255|unique:rols,nombre',
            'descripcion' => 'nullable|string|max:500',
        ]);

        // Crear el rol
        Rol::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('Rol.index')
            ->with('success', 'Rol creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Rol $rol)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rol $rol)
    {
        return Inertia::render('Roles/Edit', [
            'rol' => $rol
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rol $rol)
    {
        // Validación de datos
        $request->validate([
            'nombre' => 'required|string|max:255|unique:rols,nombre,' . $rol->Idrol . ',Idrol',
            'descripcion' => 'nullable|string|max:500',
        ]);

        // Actualizar el rol
        $rol->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('Rol.index')
            ->with('success', 'Rol actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rol $rol)
    {
        // Verificar si el rol tiene usuarios asociados
        if ($rol->users()->count() > 0) {
            return redirect()->route('Rol.index')
                ->with('error', 'No se puede eliminar el rol porque tiene usuarios asociados.');
        }

        $rol->delete();

        return redirect()->route('Rol.index')
            ->with('success', 'Rol eliminado correctamente.');
    }
}
