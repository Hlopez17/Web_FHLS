<?php

namespace App\Http\Controllers;

use App\Models\Subcategoria;
use App\Models\Categoria; // ← Importar el modelo Categoria
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubcategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Subcategoria/Index', [
            'subcategorias' => Subcategoria::all(),
            'categorias' => Categoria::all() // ← Agregar las categorías aquí
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
        'Nombre_subcat' => [
            'required',
            'string',
            'max:255',
            'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/u',
            'unique:subcategorias,Nombre_subcat',
        ],
        'Idcategoria' => 'required|integer|exists:categorias,Idcategoria',
    ]);

    Subcategoria::create($validated);

    return redirect()->route('Subcategoria.index')
        ->with('success', 'Subcategoría creada exitosamente');
    }


    /**
     * Display the specified resource.
     */
    public function show(Subcategoria $subcategoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subcategoria $subcategoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subcategoria $subcategoria)
    {
    $validated = $request->validate([
        'Nombre_subcat' => [
            'required',
            'string',
            'max:255',
            'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/u',
            'unique:subcategorias,Nombre_subcat,' . $subcategoria->Idsubcat . ',Idsubcat',
        ],
        'Idcategoria' => 'required|integer|exists:categorias,Idcategoria',
    ]);

    $subcategoria->update($validated);

    return redirect()->route('Subcategoria.index')
        ->with('success', 'Subcategoría actualizada exitosamente');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategoria $subcategoria)
    {
        $subcategoria->delete();

        return redirect()->route('Subcategoria.index')
            ->with('success', 'Subcategoría eliminada exitosamente');
    }
}