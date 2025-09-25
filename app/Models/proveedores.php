<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class proveedores extends Model
{
    use HasFactory;

    protected $fillable = ["nombre_proveedor", "telefono", "email", "direccion"];
}
