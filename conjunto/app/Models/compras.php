<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\compradetalles;
use App\Models\Inventario;
use App\Models\proveedores;

class compras extends Model
{
    protected $fillable = ['proveedor_id', 'fecha', 'total', 'estado'];

    public function detalles()
    {
        return $this->hasMany(compradetalles::class, 'compra_id');
    }

    public function proveedor()
    {
        return $this->belongsTo(proveedores::class, 'proveedor_id', 'id');
    }

    // --- NUEVO: Actualización de inventario al cambiar estado de la compra ---
    protected static function booted()
    {
        static::updating(function ($compra) {
            $originalEstado = $compra->getOriginal('estado');
            $nuevoEstado = $compra->estado;
            // Si pasa de PENDIENTE a COMPLETADO, sumar al inventario
            if ($originalEstado === 'PENDIENTE' && $nuevoEstado === 'COMPLETADO') {
                foreach ($compra->detalles as $detalle) {
                    $inventario = Inventario::where('producto_id', $detalle->producto_id)->first();
                    if ($inventario) {
                        $inventario->cantidad += $detalle->cantidad;
                        $inventario->save();
                    }
                }
            }
            // Si pasa de COMPLETADO a CANCELADO, restar del inventario
            if ($originalEstado === 'COMPLETADO' && $nuevoEstado === 'CANCELADO') {
                foreach ($compra->detalles as $detalle) {
                    $inventario = Inventario::where('producto_id', $detalle->producto_id)->first();
                    if ($inventario) {
                        $inventario->cantidad -= $detalle->cantidad;
                        if ($inventario->cantidad < 0) $inventario->cantidad = 0;
                        $inventario->save();
                    }
                }
            }
        });
    }
    // --- FIN NUEVO ---
}
