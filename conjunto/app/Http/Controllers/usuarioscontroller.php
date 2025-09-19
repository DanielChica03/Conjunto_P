<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Views\Views;
use Illuminate\Validation\Rule;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //lista de usuarios
        $usuarios=Usuarios::all();
        // debe esxistir la vista
        return View("usuarios.index",compact("usuarios"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //formulario deonde estan los campos
        return view("usuarios.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Metodo cuando se le da click al boton guardar
        $validated = $request->validate([
        'cedula'           => 'required|numeric|unique:usuarios,cedula',
        'nombre'           => 'required|string|max:25',
        'apellido'         => 'required|string|max:25',
        'clave'            => 'required|string|max:25',
        'correo'           => 'required|email|max:60|unique:usuarios,correo',
        'telefono'         => 'required|numeric',
        'genero'           => 'nullable|in:MASCULINO,FEMENINO,OTRO',
        'fecha_nacimiento' => 'nullable|date',
        'tipo_usuario'     => 'required|in:ADMINISTRADOR,CAJERO,CLIENTE',
        'estado'           => 'nullable|in:ACTIVO,INACTIVO',
    ]);

    Usuarios::create($validated);

    return redirect()->route('usuarios.index')->with('success', 'Usuario registrado exitosamente');

    }

    /**
     * Display the specified resource.
     */
    public function show(Usuarios $usuario)
    {
        //mostrar los detalles de un producto 
        return view('usuarios.show',compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Usuarios $usuario)
    {
        //click el en boton de editar en el gridview
        return view('usuarios.edit',compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Usuarios $usuario)
{
    $validated = $request->validate([
        'cedula'           => [
            'required',
            'numeric',
            Rule::unique('usuarios', 'cedula')->ignore($usuario->cedula, 'cedula'),
        ],
        'nombre'           => 'required|string|max:25',
        'apellido'         => 'required|string|max:25',
        'correo'           => 'required|email|max:60',
        'telefono'         => 'required|numeric',
        'genero'           => 'nullable|in:MASCULINO,FEMENINO,OTRO',
        'fecha_nacimiento' => 'nullable|date',
        'estado'           => 'nullable|in:ACTIVO,INACTIVO',
    ]);

    // 🔹 Usar el modelo recibido por route model binding
    $usuario->update($validated);

    return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usuarios $usuario)
    {
        // eliminar
        $usuario->delete();

    return redirect()->route('usuarios.index')->with('success','Usuario eliminado exitosamente');
    }
}
