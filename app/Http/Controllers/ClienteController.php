<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::orderBy('Nombre')->get();

        return Inertia::render('Clientes/Index', [
            'clientes' => $clientes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Clientes/Crear');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'Cedula' => 'required|string|max:255|unique:Clientes,Cedula',
            'Nombre' => 'nullable|string|max:255',
            'Apellido' => 'nullable|string|max:255',
            'Telefono' => 'nullable|string|max:255|regex:/^[0-9\-]+$/',
            'Correo' => 'nullable|email|max:255',
            'Limitecredito' => 'nullable|numeric|min:0',
            'Saldocredito' => 'nullable|numeric|min:0',
        ], [
            'Cedula.unique' => 'La cédula ya existe en el sistema.',
            'Telefono.regex' => 'El teléfono solo puede contener números y guiones.',
            'Correo.email' => 'El correo electrónico debe tener un formato válido.',
            'Limitecredito.numeric' => 'El límite de crédito debe ser un valor numérico.',
            'Saldocredito.numeric' => 'El saldo de crédito debe ser un valor numérico.',
        ]);

        // Crear el rol
        Cliente::create([
            'Cedula' => $request->Cedula,
            'Nombre' => $request->Nombre,
            'Apellido' => $request->Apellido,
            'Telefono' => $request->Telefono,
            'Correo' => $request->Correo,
            'Limitecredito' => $request->Limitecredito,
            'Saldocredito' => $request->Saldocredito,
        ]);

        return redirect()->route('Cliente.index')
            ->with('success', 'Cliente creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        return Inertia::render('Clientes/Edit', [
            'cliente' => $cliente
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        // Validación de datos
        $request->validate([
            'Cedula' => 'required|string|max:255|unique:Clientes,Cedula,' . $cliente->Idcliente . ',Idcliente',
            'Nombre' => 'nullable|string|max:255',
            'Apellido' => 'nullable|string|max:255',
            'Telefono' => 'nullable|string|max:255|regex:/^[0-9\-]+$/',
            'Correo' => 'nullable|email|max:255',
            'Limitecredito' => 'nullable|numeric|min:0',
            'Saldocredito' => 'nullable|numeric|min:0',
        ], [
            'Cedula.unique' => 'La cédula ya existe en el sistema.',
            'Telefono.regex' => 'El teléfono solo puede contener números y guiones.',
            'Correo.email' => 'El correo electrónico debe tener un formato válido.',
            'Limitecredito.numeric' => 'El límite de crédito debe ser un valor numérico.',
            'Saldocredito.numeric' => 'El saldo de crédito debe ser un valor numérico.',
        ]);

        // Actualizar el rol
        $cliente->update([
            'Cedula' => $request->Cedula,
            'Nombre' => $request->Nombre,
            'Apellido' => $request->Apellido,
            'Telefono' => $request->Telefono,
            'Correo' => $request->Correo,
            'Limitecredito' => $request->Limitecredito,
            'Saldocredito' => $request->Saldocredito,
        ]);

        return redirect()->route('Cliente.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
public function destroy(Cliente $cliente)
{
    if ($cliente->cotizacion()->count() > 0 ||
        $cliente->factura()->count() > 0 ||
        $cliente->cuentascobrar()->count() > 0) {
        return redirect()->route('Cliente.index')
            ->with('error', 'No se puede eliminar el cliente porque tiene registros asociados.');
    }

    $cliente->delete();
    return redirect()->route('Cliente.index')
        ->with('success', 'Cliente eliminado correctamente.');
}
}
