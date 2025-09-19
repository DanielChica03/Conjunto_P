<?php

namespace App\Http\Controllers;

use App\Models\pagos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class pagoscontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pagos = pagos::with('deuda.venta')->latest()->get();
        return view('pagos.index', compact('pagos'));
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
        $request->validate([
            'id_deuda' => 'required|exists:deudas,id_deuda',
            'abono' => 'required|numeric|min:1',
            'fecha' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            $deuda = \App\Models\deuda::findOrFail($request->id_deuda);
            $nuevoSaldo = $deuda->saldo - $request->abono;
            $deuda->saldo = $nuevoSaldo;
            $deuda->save();

            pagos::create($request->all());

            // Si la deuda queda saldada, cambiar estado de la venta
            if ($deuda->saldo <= 0) {
                $deuda->venta->estado = 'REALIZADA';
                $deuda->venta->save();
            }
        });
        return redirect()->route('pagos.index')->with('success', 'Pago registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(pagos $pagos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(pagos $pagos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, pagos $pagos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(pagos $pagos)
    {
        //
    }
}
