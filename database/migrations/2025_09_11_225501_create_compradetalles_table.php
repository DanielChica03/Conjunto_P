<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compradetalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compra_id')->constrained('compras')->onDelete('cascade');
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->integer('cantidad');
            $table->decimal('valor_unitario', 10, 2);
            $table->decimal('subtotal', 10, 2); // cantidad * valor_unitario
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compradetalles');
    }
};
