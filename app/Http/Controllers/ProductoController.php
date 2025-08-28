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
        $unidadmedidas = Unidadmedida::all(['Id_Medida', 'Nombre_Medida']);

        return Inertia::render('Productos/Index', [
            'productos' => $productos,
            'subcategorias' => $subcategorias,
            'categorias' => $categorias,
            'unidadmedidas' => $unidadmedidas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subcategorias = Subcategoria::with('categoria')->get(['Idsubcat', 'Nombre_subcat', 'Idcategoria']);
        $categorias = Categoria::all(['Idcategoria', 'Nombre_cat']);
        $unidadmedidas = Unidadmedida::all(['Id_Medida', 'Nombre_Medida']);

        return Inertia::render('Productos/crear', [
            'subcategorias' => $subcategorias,
            'categorias' => $categorias,
            'unidadmedidas' => $unidadmedidas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'Idsubcat' => 'required|exists:Subcategorias,Idsubcat',
            'Id_Medida' => 'required|exists:Unidadmedidas,Id_Medida',
            'Codigo_barra' => 'nullable|string|max:100',
            'Nombre' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'Precio_costo' => 'required|numeric|min:0',
            'Precio_venta' => 'required|numeric|min:0',
            'Precio_descuento' => 'nullable|numeric|min:0',
            'Precio_Mayorista' => 'nullable|numeric|min:0',
            'Estado' => 'required|in:0,1',
        ]);

        // Manejo de la imagen (si existe)
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('productos', 'public');
        }

        // Crear el producto
        $producto = Producto::create([
            'Idsubcat' => $request->Idsubcat,
            'Id_Medida' => $request->Id_Medida,
            'Codigo_barra' => $request->Codigo_barra,
            'Nombre' => $request->Nombre,
            'foto' => $fotoPath,
            'Precio_costo' => $request->Precio_costo,
            'Precio_venta' => $request->Precio_venta,
            'Precio_descuento' => $request->Precio_descuento,
            'Precio_Mayorista' => $request->Precio_Mayorista,
            'Estado' => $request->Estado,
        ]);

        return redirect()->route('Productos.index')
            ->with('success', 'Producto creado correctamente.');
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
        $request->validate([
            'Idsubcat' => 'required|exists:Subcategorias,Idsubcat',
            'Id_Medida' => 'required|exists:Unidadmedidas,Id_Medida',
            'Codigo_barra' => 'nullable|string|max:100',
            'Nombre' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'Precio_costo' => 'required|numeric|min:0',
            'Precio_venta' => 'required|numeric|min:0',
            'Precio_descuento' => 'nullable|numeric|min:0',
            'Precio_Mayorista' => 'nullable|numeric|min:0',
            'Estado' => 'required|in:activo,inactivo',
        ]);

        // Si sube nueva foto
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('productos', 'public');
            $producto->foto = $fotoPath;
        }

        // Actualizar el producto
        $producto->update([
            'Idsubcat' => $request->Idsubcat,
            'Id_Medida' => $request->Id_Medida,
            'Codigo_barra' => $request->Codigo_barra,
            'Nombre' => $request->Nombre,
            'Precio_costo' => $request->Precio_costo,
            'Precio_venta' => $request->Precio_venta,
            'Precio_descuento' => $request->Precio_descuento,
            'Precio_Mayorista' => $request->Precio_Mayorista,
            'Estado' => $request->Estado,
        ]);

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}
