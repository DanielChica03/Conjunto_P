<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class producto extends Model
{
    use HasFactory;

    protected $fillable=["nombre_producto","descripcion_producto","valor_unitario","unidad_medida","estado_producto"];
}
