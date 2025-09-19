<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\compradetalles;

class compras extends Model
{
    protected $fillable = ['proveedor_id', 'fecha', 'total', 'estado'];

    public function detalles()
    {
        return $this->hasMany(compradetalles::class, 'compra_id');
    }

    public function proveedor()
    {
        return $this->belongsTo(proveedores::class);
    }
}
