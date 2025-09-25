<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    use HasFactory;

    protected $table = 'usuarios';   // Nombre de la tabla
    protected $primaryKey = 'cedula'; // Le dices a Laravel cuál es la PK

    public $incrementing = false;    // Si la cédula no es autoincremental
    protected $keyType = 'string';   // O 'int' según el tipo de dato de tu cedula

    protected $fillable=["cedula","nombre","apellido","clave","correo","telefono","genero","fecha_nacimiento","tipo_usuario","estado"];
}
