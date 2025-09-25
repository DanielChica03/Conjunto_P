<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ventasdetalle extends Model
{
    protected $fillable = [
        'venta_id',
        'producto_id',
        'cantidad',
        'valor_unitario',
        'subtotal',
    ];

    public function venta()
    {
        return $this->belongsTo(ventas::class, 'venta_id');
    }

    public function producto()
    {
        return $this->belongsTo(producto::class, 'producto_id');
    }
}
