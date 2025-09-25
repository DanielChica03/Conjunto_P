<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         Schema::create('usuarios', function (Blueprint $table) {
            $table->unsignedBigInteger('cedula')->primary(); // PK sin auto-incremento
            $table->string('nombre', 25);
            $table->string('apellido', 25);
            $table->string('clave', 25);
            $table->string('correo', 60);
            $table->unsignedInteger('telefono');
            $table->enum('genero', ['MASCULINO', 'FEMENINO', 'OTRO'])->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('tipo_usuario', ['ADMINISTRADOR', 'CAJERO', 'CLIENTE']);
            $table->enum('estado', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
