<?php

namespace App\Http\Controllers;

use App\Models\ventasdetalle;
use Illuminate\Http\Request;

class ventasdetallescontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $detalles = ventasdetalle::with('venta', 'producto')->get();
        return view('ventasdetalles.index', compact('detalles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Aquí puedes pasar ventas y productos si lo necesitas
        return view('ventasdetalles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'venta_id' => 'required|exists:ventas,id',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'valor_unitario' => 'required|numeric|min:0',
        ]);

        $subtotal = $request->cantidad * $request->valor_unitario;

        ventasdetalle::create([
            'venta_id' => $request->venta_id,
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad,
            'valor_unitario' => $request->valor_unitario,
            'subtotal' => $subtotal,
        ]);

        return redirect()->route('ventasdetalles.index')->with('success', 'Detalle de venta creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ventasdetalle $ventasdetalle)
    {
        return view('ventasdetalles.show', compact('ventasdetalle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ventasdetalle $ventasdetalle)
    {
        return view('ventasdetalles.edit', compact('ventasdetalle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ventasdetalle $ventasdetalle)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1',
            'valor_unitario' => 'required|numeric|min:0',
        ]);

        $ventasdetalle->update([
            'cantidad' => $request->cantidad,
            'valor_unitario' => $request->valor_unitario,
            'subtotal' => $request->cantidad * $request->valor_unitario,
        ]);

        return redirect()->route('ventasdetalles.index')->with('success', 'Detalle de venta actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ventasdetalle $ventasdetalle)
    {
        $ventasdetalle->delete();
        return redirect()->route('ventasdetalles.index')->with('success', 'Detalle de venta eliminado correctamente.');
    }
}
