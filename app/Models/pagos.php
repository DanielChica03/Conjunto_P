<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pagos extends Model
{
    protected $primaryKey = 'id_pago';
    protected $fillable = ['id_deuda', 'abono', 'fecha'];

    public function deuda()
    {
        return $this->belongsTo(deuda::class, 'id_deuda');
    }
}
