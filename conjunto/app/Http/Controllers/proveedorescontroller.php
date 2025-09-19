<?php

namespace App\Http\Controllers;

use App\Models\proveedores;
use Illuminate\Http\Request;

class proveedorescontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores=proveedores::all();
        return view("proveedores.index",compact("proveedores"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("proveedores.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_proveedor' => 'required|string|max:50',
            'telefono' => 'required|numeric',
            'email' => 'required|email|max:100|unique:proveedores,email',
            'direccion' => 'required|string|max:100',
        ]);

        proveedores::create($request->all());
        return redirect()->route('proveedores.index')->with('success', 'Proveedor creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(proveedores $proveedor)
    {
        return view("proveedores.show", compact("proveedor"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(proveedores $proveedor)
    {
        return view("proveedores.edit", compact("proveedor"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, proveedores $proveedor)
    {
        $request->validate([
            'nombre_proveedor' => 'required|string|max:50',
            'telefono' => 'required|numeric',
            'email' => 'required|email|max:100|unique:proveedores,email,' . $proveedor->id,
            'direccion' => 'required|string|max:100',
        ]);

        $proveedor->update($request->all());
        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(proveedores $proveedor)
    {
        $proveedor->delete();
        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado exitosamente.');
    }
}
