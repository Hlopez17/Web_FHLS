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
        Schema::create('detalle_recs', function (Blueprint $table) {
            $table->id('Id_detallerecep');
            $table->unsignedBigInteger('Idrecepcion');
            $table->foreign('Idrecepcion')->references('Idrecepcion')->on('recepciones');
            $table->unsignedBigInteger('Idproducto');
            $table->foreign('Idproducto')->references('Idproducto')->on('productos');
            $table->unsignedBigInteger('Id_tipopago');
            $table->foreign('Id_tipopago')->references('Id_tipopago')->on('tipo_pagos');
            $table->decimal('Cantidad',10,2);
            $table->decimal('Precio_costo',10,2);
            $table->decimal('Importe', 10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_recs');
    }
};
