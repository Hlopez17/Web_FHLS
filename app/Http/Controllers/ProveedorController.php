<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Llama al archivo '.Vue' dentro de 'Page'
        return Inertia::render('Proveedor/Index', [
            'proveedors'=>Proveedor::all()
            //'Proveedor' => Proveedor::select('id', 'name', 'email', 'position', 'salary')->paginate(10), //recupera solo los campos necesarios y paginados
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
        'Razon_social' => [
            'required',
            'string',
            'max:255',
            'regex:/^[\pL\s]+$/u', // Solo letras y espacios
            'unique:proveedors,Razon_social',
        ],
        'Telefono'  => ['required','string','max:20','regex:/^[0-9\-\+\s\(\)]+$/'],
        'Direccion' => ['required','string','max:255'],
        'Correo'    => ['required','email','max:255','unique:proveedors,Correo'],
    ], [
        'Razon_social.regex'    => 'La Razón Social solo puede contener letras y espacios.',
        'Razon_social.required' => 'La Razón Social es obligatoria.',
        'Razon_social.unique'   => 'Ya existe un proveedor con esa Razón Social.',
        'Telefono.regex'        => 'El Teléfono solo puede contener números, espacios, guiones y paréntesis.',
        'Correo.email'          => 'El correo debe ser válido.',
        'Correo.unique'         => 'Ya existe un proveedor con ese correo.',
    ]);

    Proveedor::create($validated);

    return redirect()->route('Proveedor.index')
                     ->with('success', 'Proveedor creado correctamente ✅');
    }

    /**
     * Display the specified resource.
     */
    public function show(Proveedor $proveedor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proveedor $proveedor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proveedor $proveedor)
    {
    $validated = $request->validate([
        'Razon_social' => [
            'required',
            'string',
            'max:255',
            'regex:/^[\pL\s]+$/u', // ✅ Solo letras y espacios (Unicode)
            'unique:proveedors,Razon_social,' . $proveedor->Idproveedor . ',Idproveedor',
        ],
        'Telefono'  => [
            'required',
            'string',
            'max:20',
            'regex:/^[0-9]+$/', // ✅ Solo números (sin guiones ni símbolos)
        ],
        'Direccion' => ['required','string','max:255'],
        'Correo'    => [
            'required',
            'email',
            'max:255',
            'unique:proveedors,Correo,' . $proveedor->Idproveedor . ',Idproveedor',
        ],
        ], [
        'Razon_social.regex'    => 'La Razón Social solo puede contener letras y espacios.',
        'Razon_social.required' => 'La Razón Social es obligatoria.',
        'Razon_social.unique'   => 'Ya existe un proveedor con esa Razón Social.',

        'Telefono.regex'        => 'El Teléfono solo puede contener números.',
        'Telefono.required'     => 'El Teléfono es obligatorio.',

        'Direccion.required'    => 'La Dirección es obligatoria.',

        'Correo.email'          => 'El correo debe ser válido.',
        'Correo.unique'         => 'Ya existe un proveedor con ese correo.',
        'Correo.required'       => 'El Correo es obligatorio.',
    ]);

    $proveedor->update($validated);

    return redirect()->route('Proveedor.index')
                     ->with('success', 'Proveedor actualizado correctamente ✏️');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Proveedor $proveedor)
    {
    $proveedor->delete();

    return redirect()->route('Proveedor.index')
                     ->with('success', 'Proveedor eliminado correctamente 🗑️');
    }

}
