<?php

namespace App\Http\Controllers;

use App\Models\deuda;
use Illuminate\Http\Request;

class deudacontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deudas = deuda::with('venta')->latest()->get();
        return view('deudas.index', compact('deudas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Solo ventas pendientes
        $ventas = \App\Models\ventas::where('estado', 'PENDIENTE')->get();
        return view('deudas.create', compact('ventas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_venta' => 'required|exists:ventas,id',
            'valor' => 'required|numeric|min:0',
            'plazo' => 'required|date',
            'saldo' => 'required|numeric|min:0',
        ]);
        deuda::create($request->all());
        return redirect()->route('deudas.index')->with('success', 'Deuda creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(deuda $deuda)
    {
        return view('deudas.show', compact('deuda'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(deuda $deuda)
    {
        $ventas = \App\Models\ventas::where('estado', 'PENDIENTE')->get();
        return view('deudas.edit', compact('deuda', 'ventas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, deuda $deuda)
    {
        $request->validate([
            'id_venta' => 'required|exists:ventas,id',
            'valor' => 'required|numeric|min:0',
            'plazo' => 'required|date',
            'saldo' => 'required|numeric|min:0',
        ]);
        $deuda->update($request->all());
        return redirect()->route('deudas.index')->with('success', 'Deuda actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(deuda $deuda)
    {
        $deuda->delete();
        return redirect()->route('deudas.index')->with('success', 'Deuda eliminada exitosamente.');
    }
}
