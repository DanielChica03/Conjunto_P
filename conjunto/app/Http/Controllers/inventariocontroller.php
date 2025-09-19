<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Producto;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    /**
     * Mostrar lista de inventarios.
     */
    public function index()
    {
        $inventarios = Inventario::with('producto')->get(); // eager loading para productos
        return view('inventario.index', compact('inventarios'));
    }

    /**
     * Mostrar formulario para crear nuevo inventario.
     */
    public function create()
    {
        $productos = Producto::all(); // para seleccionar producto en un select
        return view('inventario.create', compact('productos'));
    }

    /**
     * Guardar un nuevo inventario en BD.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'producto_id'      => 'required|exists:productos,id',
            'ubicacion'        => 'required|string|max:40',
            'cantidad'         => 'required|integer|min:1',
            'especificaciones' => 'required|string|max:50',
            'fecha_vencimiento'=> 'required|date',
            'estado'           => 'required|in:DISPONIBLE,NO DISPONIBLE',
        ]);

        Inventario::create($validated);

        return redirect()->route('inventario.index')->with('success', 'Item creado exitosamente');
    }

    /**
     * Mostrar un inventario específico.
     */
    public function show(Inventario $inventario)
    {
        return view('inventario.show', compact('inventario'));
    }

    /**
     * Mostrar formulario para editar inventario.
     */
    public function edit(Inventario $inventario)
    {
        $productos = Producto::all();
        return view('inventario.edit', compact('inventario', 'productos'));
    }

    /**
     * Actualizar inventario.
     */
    public function update(Request $request, Inventario $inventario)
    {
        $validated = $request->validate([
            'producto_id'      => 'required|exists:productos,id',
            'ubicacion'        => 'required|string|max:40',
            'cantidad'         => 'required|integer|min:1',
            'especificaciones' => 'required|string|max:50',
            'fecha_vencimiento'=> 'required|date',
            'estado'           => 'required|in:DISPONIBLE,NO DISPONIBLE',
        ]);

        $inventario->update($validated);

        return redirect()->route('inventario.index')->with('success', 'Item actualizado exitosamente');
    }

    /**
     * Eliminar un inventario.
     */
    public function destroy(Inventario $inventario)
    {
        $inventario->delete();
        return redirect()->route('inventario.index')->with('success', 'Item eliminado exitosamente');
    }
}
