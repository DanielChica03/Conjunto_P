<?php

namespace App\Http\Controllers;

use App\Models\producto;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Views\Views;
use Illuminate\Validation\Rule;

class productoscontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Lista de productos
        $productos=producto::all();
        //debe existir la vista
        return View("productos.index",compact("productos"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Formulario para crear un nuevo producto
        return view("productos.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validar los datos
        $validated = $request->validate([
            'nombre_producto'     => 'required|string|max:30',
            'descripcion_producto' => 'required|string|max:100',
            'valor_unitario'      => 'required|numeric',
            'unidad_medida'      => 'required|string|max:10',
            'estado_producto'     => 'nullable|in:ACTIVO,INACTIVO',
        ]);

        producto::create($validated);

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(producto $producto)
    {
        return view('productos.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, producto $producto)
    {
        //Validar los datos
        $validated = $request->validate([
            'nombre_producto'     => 'required|string|max:30',
            'descripcion_producto' => 'required|string|max:100',
            'valor_unitario'      => 'required|numeric',
            'unidad_medida'      => 'required|string|max:10',
            'estado_producto'     => 'nullable|in:ACTIVO,INACTIVO',
        ]);

        $producto->update($validated);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(producto $producto)
    {
        //Eliminar
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente');
    }
}
