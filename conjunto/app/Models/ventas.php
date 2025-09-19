<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ventas extends Model
{
    //
    protected $fillable = ['cliente_id', 'fecha_venta', 'total', 'estado', 'descuento'];

    public function detalles()
    {
        return $this->hasMany(ventadetalles::class, 'venta_id');
    }
    public function cliente()
    {
        return $this->belongsTo(clientes::class);
    }
}
