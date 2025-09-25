<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\compras;
use App\Models\producto;
use App\Models\Inventario;

class compradetalles extends Model
{
    protected $fillable = ['compra_id', 'producto_id', 'cantidad', 'valor_unitario', 'subtotal'];

    public function compra()
    {
        return $this->belongsTo(compras::class);
    }

    public function producto()
    {
        return $this->belongsTo(producto::class, 'producto_id');
    }

    // --- NUEVO: Manejo de inventario automático ---
    protected static function booted()
    {
        // Al crear un detalle de compra
        static::created(function ($detalle) {
            // Solo si la compra está COMPLETADA
            if ($detalle->compra && $detalle->compra->estado === 'COMPLETADO') {
                $inventario = Inventario::where('producto_id', $detalle->producto_id)->first();
                if ($inventario) {
                    $inventario->cantidad += $detalle->cantidad;
                    $inventario->save();
                } else {
                    // Si no existe, crea un registro básico (ajusta según tus necesidades)
                    Inventario::create([
                        'producto_id' => $detalle->producto_id,
                        'ubicacion' => 'BODEGA',
                        'cantidad' => $detalle->cantidad,
                        'especificaciones' => '',
                        'fecha_vencimiento' => now()->addYear(),
                        'estado' => 'DISPONIBLE',
                    ]);
                }
            }
        });

        // Al actualizar un detalle de compra
        static::updating(function ($detalle) {
            // Solo si la compra está COMPLETADA
            if ($detalle->compra && $detalle->compra->estado === 'COMPLETADO') {
                $original = $detalle->getOriginal();
                $diferencia = $detalle->cantidad - $original['cantidad'];
                $inventario = Inventario::where('producto_id', $detalle->producto_id)->first();
                if ($inventario) {
                    $inventario->cantidad += $diferencia;
                    if ($inventario->cantidad < 0) $inventario->cantidad = 0;
                    $inventario->save();
                }
            }
        });

        // Al "eliminar" (poner en 0) un detalle de compra
        static::updated(function ($detalle) {
            // Si la cantidad se puso en 0 y la compra está COMPLETADA
            if ($detalle->compra && $detalle->compra->estado === 'COMPLETADO' && $detalle->cantidad == 0) {
                $inventario = Inventario::where('producto_id', $detalle->producto_id)->first();
                if ($inventario) {
                    $inventario->cantidad = 0;
                    $inventario->save();
                }
            }
        });
    }
    // --- FIN NUEVO ---
}
