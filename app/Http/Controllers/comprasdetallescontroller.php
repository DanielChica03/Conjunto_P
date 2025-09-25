<?php

namespace App\Http\Controllers;

use App\Models\compradetalles;
use Illuminate\Http\Request;

class comprasdetallescontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $compras = Compra::with('proveedor','detalles.producto')->latest()->get();
        return view('compras.index', compact('compras'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(compradetalles $compradetalles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(compradetalles $compradetalles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, compradetalles $compradetalles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(compradetalles $compradetalles)
    {
        //
    }
}
