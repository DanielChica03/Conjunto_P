<?php

namespace App\Http\Controllers;

use App\Models\compras;
use App\Models\proveedores;
use App\Models\producto;
use App\Models\compradetalles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  

class comprascontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compras = compras::with('proveedor','detalles.producto')->latest()->get();
        return view('compras.index', compact('compras'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $proveedores = proveedores::all();
        $productos = producto::all();

        return view('compras.create', compact('proveedores', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha' => 'required|date',
            'estado' => 'required',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.valor_unitario' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $compra = compras::create([
                'proveedor_id' => $request->proveedor_id,
                'fecha' => $request->fecha,
                'total' => $request->total,
                'estado' => $request->estado,
            ]);

            foreach ($request->productos as $producto) {
                $subtotal = $producto['cantidad'] * $producto['valor_unitario'];
                compradetalles::create([
                    'compra_id' => $compra->id,
                    'producto_id' => $producto['producto_id'],
                    'cantidad' => $producto['cantidad'],
                    'valor_unitario' => $producto['valor_unitario'],
                    'subtotal' => $subtotal,
                ]);
            }
        });

        return redirect()->route('compras.index')->with('success', 'Compra creada con éxito');
    }


    /**
     * Display the specified resource.
     */
    public function show(compras $compras)
    {
        return view('compras.show', compact('compras'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(compras $compra)
    {
        $proveedores = proveedores::all();
        $productos = producto::all();
        return view('compras.edit', compact('compra', 'proveedores', 'productos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, compras $compra)
    {
        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha' => 'required|date',
            'total' => 'required|numeric',
            'estado' => 'required|string',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.valor_unitario' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $compra) {
            // Actualiza la compra principal
            $compra->update([
                'proveedor_id' => $request->proveedor_id,
                'fecha' => $request->fecha,
                'total' => $request->total,
                'estado' => $request->estado,
            ]);

            // Obtén los IDs de productos enviados en el formulario
            $productosForm = collect($request->productos);
            $productosIdsForm = $productosForm->pluck('producto_id')->map(fn($id) => (int)$id)->toArray();

            // Actualiza o crea los detalles
            foreach ($productosForm as $producto) {
                $detalle = $compra->detalles()->where('producto_id', $producto['producto_id'])->first();
                $subtotal = $producto['cantidad'] * $producto['valor_unitario'];

                if ($detalle) {
                    // Actualiza el detalle existente
                    $detalle->update([
                        'cantidad' => $producto['cantidad'],
                        'valor_unitario' => $producto['valor_unitario'],
                        'subtotal' => $subtotal,
                    ]);
                } else {
                    // Crea un nuevo detalle
                    compradetalles::create([
                        'compra_id' => $compra->id,
                        'producto_id' => $producto['producto_id'],
                        'cantidad' => $producto['cantidad'],
                        'valor_unitario' => $producto['valor_unitario'],
                        'subtotal' => $subtotal,
                    ]);
                }
            }

            // Opcional: pon en 0 los detalles que ya no están en el formulario
            $compra->detalles()
                ->whereNotIn('producto_id', $productosIdsForm)
                ->update(['cantidad' => 0, 'subtotal' => 0]);
        });

        return redirect()->route('compras.index')->with('success', 'Compra actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(compras $compra)
    {
        DB::transaction(function () use ($compra) {
            // Actualiza cada detalle para disparar el trigger (sin cambiar la cantidad)
            foreach ($compra->detalles as $detalle) {
                $detalle->update([
                    'cantidad' => $detalle->cantidad, // No cambia, pero dispara el trigger
                    'subtotal' => $detalle->cantidad * $detalle->valor_unitario,
                ]);
            }
            // Cambia el estado de la compra a CANCELADO
            $compra->update(['estado' => 'CANCELADO']);
        });

        return redirect()->route('compras.index')->with('success', 'Compra cancelada exitosamente.');
    }
}
