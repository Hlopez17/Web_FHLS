<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Subcategoria;
use App\Models\Unidadmedida;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $productos = Producto::with(['subcategoria.categoria'])->get();

        $subcategorias = Subcategoria::with('categoria')->get(['Idsubcat', 'Nombre_subcat', 'Idcategoria']);
        $categorias = Categoria::all(['Idcategoria', 'Nombre_cat']);
        $unidadmedidas= Unidadmedida::all(['Id_Medida','Nombre_Medida']);

        return Inertia::render('Productos/Index', [
            'productos' => $productos,
            'subcategorias' => $subcategorias,
            'categorias' => $categorias,
            'unidadmedidas'=>$unidadmedidas,
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
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        //
    }
}
