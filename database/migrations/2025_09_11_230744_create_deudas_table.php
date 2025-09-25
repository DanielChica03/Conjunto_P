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
        Schema::create('deudas', function (Blueprint $table) {
            $table->id('id_deuda');
            $table->unsignedBigInteger('id_venta');
            $table->unsignedBigInteger('valor');
            $table->date('plazo');
            $table->unsignedBigInteger('saldo');
            $table->timestamps();
            $table->foreign('id_venta')->references('id')->on('ventas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deudas');
    }
};
