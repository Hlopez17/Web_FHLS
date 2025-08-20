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
        Schema::create('detalle_kits', function (Blueprint $table) {
            $table->id('Id_detallekit');
            $table->unsignedBigInteger('Idkit');
            $table->foreign('Idkit')->references('Idkit')->on('kits');
            $table->unsignedBigInteger('Idproducto');
            $table->foreign('Idproducto')->references('Idproducto')->on('productos');
            $table->decimal('Cantidad', 10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_kits');
    }
};
