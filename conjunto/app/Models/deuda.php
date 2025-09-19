<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class deuda extends Model
{

    protected $primaryKey = 'id_deuda';
    protected $fillable = ['id_venta', 'valor', 'plazo', 'saldo'];

    public function venta()
    {
        return $this->belongsTo(ventas::class, 'id_venta');
    }
}
