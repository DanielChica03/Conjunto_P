<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class compradetalles extends Model
{
    protected $fillable = ['compra_id', 'producto_id', 'cantidad', 'valor_unitario', 'subtotal'];

    public function compra()
    {
        return $this->belongsTo(compra::class);
    }

    public function producto()
    {
        return $this->belongsTo(producto::class, 'producto_id');
    }
}
