<?php

namespace App\Http\Controllers;

use App\Models\ventas;
use App\Models\usuarios;
use App\Models\ventasdetalle;
use App\Models\producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ventascontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuario = session('usuario');
        if ($usuario && strtoupper($usuario->tipo_usuario) === 'CLIENTE') {
            // Solo sus propias compras
            $ventas = \App\Models\ventas::with('detalles.producto')
                ->where('cliente_id', $usuario->cedula)
                ->latest()
                ->get();
            $esCliente = true;
        } else {
            // Admin y otros ven todas las ventas
            $ventas = \App\Models\ventas::with('cliente', 'detalles.producto')->latest()->get();
            $esCliente = false;
        }
        return view('ventas.index', compact('ventas', 'esCliente'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Solo usuarios que son clientes
        $usuarios = usuarios::where('tipo_usuario', 'cliente')->get();
        $productos = producto::all();
        return view('ventas.create', compact('usuarios', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente' => 'required|exists:usuarios,cedula',
            'fecha_venta' => 'required|date',
            'estado' => 'required|in:REALIZADA,PENDIENTE',
            'total' => 'required|numeric|min:0',
            'descuento' => 'nullable|numeric|min:0',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.valor_unitario' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $venta = ventas::create([
                'cliente_id' => $request->cliente,
                'fecha_venta' => $request->fecha_venta,
                'total' => $request->total,
                'estado' => $request->estado,
                'descuento' => $request->descuento,
            ]);

            foreach ($request->productos as $producto) {
                $subtotal = $producto['cantidad'] * $producto['valor_unitario'];
                ventasdetalle::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $producto['producto_id'],
                    'cantidad' => $producto['cantidad'],
                    'valor_unitario' => $producto['valor_unitario'],
                    'subtotal' => $subtotal,
                ]);

                // Descontar del inventario
                $inventario = \App\Models\inventario::where('producto_id', $producto['producto_id'])->first();
                if ($inventario) {
                    $inventario->cantidad -= $producto['cantidad'];
                    if ($inventario->cantidad < 0) {
                        throw new \Exception('No hay suficiente inventario para el producto ID: ' . $producto['producto_id']);
                    }
                    $inventario->save();
                }
            }
        });

        return redirect()->route('ventas.index')->with('success', 'Venta creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ventas $venta)
    {
        return view('venta.show', compact('venta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ventas $venta)
    {
    $usuarios = usuarios::where('tipo_usuario', 'CLIENTE')->get();
    $productos = producto::all();
    return view('ventas.edit', compact('venta', 'usuarios', 'productos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ventas $venta)
    {
        $request->validate([
            'cliente_id' => 'required|exists:usuarios,cedula',
            'fecha_venta' => 'required|date',
            'total' => 'required|numeric|min:0',
            'estado' => 'required|in:REALIZADA,PENDIENTE',
            'descuento' => 'nullable|numeric|min:0',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.valor_unitario' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $venta) {
            $venta->update([
                'cliente_id' => $request->cliente_id,
                'fecha_venta' => $request->fecha_venta,
                'total' => $request->total,
                'estado' => $request->estado,
                'descuento' => $request->descuento,
            ]);

            // Devolver inventario de los productos anteriores
            foreach ($venta->detalles as $detalle) {
                $inventario = \App\Models\inventario::where('producto_id', $detalle->producto_id)->first();
                if ($inventario) {
                    $inventario->cantidad += $detalle->cantidad;
                    $inventario->save();
                }
            }

            // Elimina los detalles anteriores
            $venta->detalles()->delete();

            // Inserta los nuevos detalles y descuenta inventario
            foreach ($request->productos as $producto) {
                $subtotal = $producto['cantidad'] * $producto['valor_unitario'];
                ventasdetalle::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $producto['producto_id'],
                    'cantidad' => $producto['cantidad'],
                    'valor_unitario' => $producto['valor_unitario'],
                    'subtotal' => $subtotal,
                ]);

                $inventario = \App\Models\inventario::where('producto_id', $producto['producto_id'])->first();
                if ($inventario) {
                    $inventario->cantidad -= $producto['cantidad'];
                    if ($inventario->cantidad < 0) {
                        throw new \Exception('No hay suficiente inventario para el producto ID: ' . $producto['producto_id']);
                    }
                    $inventario->save();
                }
            }
        });

        return redirect()->route('ventas.index')->with('success', 'Venta actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ventas $venta)
    {
        DB::transaction(function () use ($venta) {
            $venta->detalles()->delete();
            $venta->delete();
        });

        return redirect()->route('ventas.index')->with('success', 'Venta eliminada exitosamente.');
    }
}