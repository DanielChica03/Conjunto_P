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
        Schema::create('inventario', function (Blueprint $table) {
            $table->tinyIncrements('id_item'); 
            $table->unsignedBigInteger('producto_id');
            $table->string('ubicacion', 40);
            $table->unsignedSmallInteger('cantidad');
            $table->string('especificaciones', 50);
            $table->date('fecha_vencimiento');
            $table->enum('estado', ['DISPONIBLE', 'NO DISPONIBLE'])->default('DISPONIBLE');

            $table->timestamps();

            $table->foreign('producto_id')
                  ->references('id')
                  ->on('productos')
                  ->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventario');
    }
};
