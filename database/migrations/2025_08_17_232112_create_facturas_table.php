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
        Schema::create('facturas', function (Blueprint $table) {
            $table->id('IdFactura');
            $table->unsignedBigInteger('Id_tipoentrega');
            $table->foreign('Id_tipoentrega')->references('Id_tipoentrega')->on('tipo_entregas');
            $table->unsignedBigInteger('Id_tipopago');
            $table->foreign('Id_tipopago')->references('Id_tipopago')->on('tipo_pagos');
            $table->unsignedBigInteger('Idusuario');
            $table->foreign('Idusuario')->references('Idusuario')->on('users');
            $table->unsignedBigInteger('Idcliente');
            $table->foreign('Idcliente')->references('Idcliente')->on('clientes');
            $table->string('Estado');
            $table->datetime('Fecha');
            $table->decimal('Subtotal', 10,2);
            $table->decimal('Descuento', 10,2);
            $table->decimal('Total', 10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
