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
        // Solo deudas con saldo mayor a 0
        $deudas = \App\Models\deuda::where('saldo', '>', 0)->with('venta')->get();
        return view('pagos.create', compact('deudas'));
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
    public function destroy(pagos $pago)
    {
        DB::transaction(function () use ($pago) {
            $deuda = $pago->deuda;
            // Al eliminar el pago, se suma el abono al saldo de la deuda
            $deuda->saldo += $pago->abono;
            $deuda->save();

            $pago->delete();

            // Si la deuda ya no está saldada, poner la venta como PENDIENTE
            if ($deuda->saldo > 0) {
                $deuda->venta->estado = 'PENDIENTE';
                $deuda->venta->save();
            }
        });
        return redirect()->route('pagos.index')->with('success', 'Pago eliminado correctamente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(pagos $pago)
    {
        $deudas = \App\Models\deuda::where('saldo', '>', 0)->with('venta')->get();
        return view('pagos.edit', compact('pago', 'deudas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, pagos $pago)
    {
        $request->validate([
            'id_deuda' => 'required|exists:deudas,id_deuda',
            'abono' => 'required|numeric|min:1',
            'fecha' => 'required|date',
        ]);

        DB::transaction(function () use ($request, $pago) {
            $deuda = \App\Models\deuda::findOrFail($request->id_deuda);
            // Recalcular saldo: sumar el abono anterior y restar el nuevo abono
            $nuevoSaldo = $deuda->saldo + $pago->abono - $request->abono;
            $deuda->saldo = $nuevoSaldo;
            $deuda->save();

            $pago->update($request->all());

            // Si la deuda queda saldada, cambiar estado de la venta
            if ($deuda->saldo <= 0) {
                $deuda->venta->estado = 'REALIZADA';
                $deuda->venta->save();
            }
        });
        return redirect()->route('pagos.index')->with('success', 'Pago actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
}
