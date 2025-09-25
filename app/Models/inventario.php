<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $table = 'inventario';
    protected $primaryKey = 'id_item';   // clave primaria personalizada
    public $incrementing = true;         // autoincremental
    protected $keyType = 'int';          // tipo de dato

    protected $fillable = [
        'producto_id',
        'ubicacion',
        'cantidad',
        'especificaciones',
        'fecha_vencimiento',
        'estado',
    ];

    // Relación con producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id', 'id');
    }
}
