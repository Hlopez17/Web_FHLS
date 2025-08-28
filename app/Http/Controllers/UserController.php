<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
    * Ruta para despues colocar en el controlador 
    */
    public function index()
    {
        return Inertia::render('User/Index', [ // ← Cambiado a 'User/Index'
            'users' => User::all(), // ← También cambiar la clave
            'roles' => Rol::all() // Proporcionar los roles para cargarlos en el select
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
        /*
        if($request.hasFile("foto")){
            $path = Storage::putFile("users",$request->file("foto"));
            $request->request->add(["foto_perfil"=> $path]);
        }*/

        $validated = $request->validate([
            'name' => ['required','string','max:255'],
            'Apellido' => ['required','string','max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string','max:255','min:8','regex:/^(?=.*[a-zA-Z])(?=.*[0-9]).+$/'],
            'Telefono' => ['nullable', 'string', 'max:20','min:8', 'regex:/^[0-9\-\+\s\(\)]+$/'],
            'Idrol' => ['required'],
            'Estado' => ['required'],
            'Comision' => ['required', 'numeric', 'min:0'],
        ],[
                'name.string' => "El campo nombre solo pueden contener letras y espacios",
                'name.required' => "El campo nombre es obligatorio",
                'name.max' => "El campo nombre debe tener un máximo de 255 caracteres",

                'Apellido.string' => "El campo apellido solo pueden contener letras y espacios",
                'Apellido.required' => "El campo apellido es obligatorio",
                'Apellido.max' => "El campo apellido debe tener un máximo de 255 caracteres",

                'email.required' => "El campo email es obligatorio",
                'email.email' => 'Debe ser un correo válido.',
                'email.unique' => 'Ya existe un usuario con este correo.',
                'email.max' => "El campo email debe tener un máximo de 255 caracteres",

                'password.required' => "El campo contraseña es obligatorio",
                'password.string' => "El campo de",
                'password.max' => "El campo contraseña debe tener un máximo de 255 caracteres",
                'password.min' => "El campo contraseña debe tener como mínimo 8 caracteres",
                'password.regex'    => 'La contraseña debe contener al menos una letra y un número.',
                
                'Telefono.string' => 'El teléfono debe ser un texto válido.',
                'Telefono.min' => 'El campo teléfono debe tener como mínimo 8 caracteres',
                'Telefono.max' => 'El campo teléfono no puede tener más de 20 caracteres.',
                'Telefono.regex' => 'El campo teléfono solo puede contener números, espacios, guiones, paréntesis y +.',

                'Idrol.required' => "Seleccione el rol del usuario",
                'Estado.required' => "Seleccione el estado del usuario",

                'Comision.required' => "El campo comisión es obligatorio",
                'Comision.numeric' => 'El campo comisión debe ser un número.',
                'Comision.min' => 'El campo comisión debe ser mayor o igual que 0.',

            ]);

        $validated['password'] = bcrypt($validated['password']);
        User::create($validated);


        return redirect()->route("User.index")
        ->with('success','Usuario creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $user = User::findOrFail($id);

        /*
        if($request.hasFile("foto")){

            if($user->foto_pefil){
                Storage::delete($user->foto_perfil);
            }

            $path = Storage::putFile("users",$request->file("foto"));
            $request->request->add(["foto_perfil"=> $path]);
        }*/

            // Validación
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'Apellido' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $id . ',Idusuario'],
        'password' => ['nullable', 'string', 'max:255', 'min:8'], // nullable para poder dejar vacía
        'Telefono' => ['nullable', 'string', 'max:20', 'regex:/^[0-9\-\+\s\(\)]+$/'],
        'Idrol' => ['required'],
        'Estado' => ['required'],
        'Comision' => ['required', 'numeric', 'min:0'],
    ], [
        'name.string' => "El campo nombre solo puede contener letras y espacios",
        'name.required' => "El campo nombre es obligatorio",
        'name.max' => "El campo nombre debe tener un máximo de 255 caracteres",

        'Apellido.string' => "El campo apellido solo puede contener letras y espacios",
        'Apellido.required' => "El campo apellido es obligatorio",
        'Apellido.max' => "El campo apellido debe tener un máximo de 255 caracteres",

        'email.required' => "El campo email es obligatorio",
        'email.email' => 'Debe ser un correo válido.',
        'email.unique' => 'Ya existe un usuario con este correo.',
        'email.max' => "El campo email debe tener un máximo de 255 caracteres",

        'password.max' => "El campo contraseña debe tener un máximo de 255 caracteres",
        'password.min' => "El campo contraseña debe tener como mínimo 8 caracteres",

        'Telefono.string' => 'El teléfono debe ser un texto válido.',
        'Telefono.max' => 'El teléfono no puede tener más de 20 caracteres.',
        'Telefono.regex' => 'El teléfono solo puede contener números, espacios, guiones, paréntesis y +.',

        'Idrol.required' => "Seleccione el rol del usuario",
        'Estado.required' => "Seleccione el estado del usuario",

        'Comision.required' => "El campo comisión es obligatorio",
        'Comision.numeric' => 'El campo comisión debe ser un número.',
        'Comision.min' => 'El campo comisión debe ser mayor o igual que 0.',
    ]);

if (!empty($validated['password'])) {
    $validated['password'] = bcrypt($validated['password']);
} else {
    unset($validated['password']);
}

        $user->update($validated);

       return redirect()->route('usuarios.index')
                     ->with('success', 'Usuario actualizado correctamente ✏️');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('User.index')
        ->with('success', 'Usuario eliminado correctamente');
}


}
