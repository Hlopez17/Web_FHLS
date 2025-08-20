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
        Schema::create('recepciones', function (Blueprint $table) {
            $table->id('Idrecepcion');
            $table->unsignedBigInteger('Idproveedor');
            $table->foreign('Idproveedor')->references('Idproveedor')->on('proveedors');
            $table->unsignedBigInteger('Idusuario');
            $table->foreign('Idusuario')->references('Idusuario')->on('users');
            $table->unsignedBigInteger('Id_tipopago');
            $table->foreign('Id_tipopago')->references('Id_tipopago')->on('tipo_pagos');
            $table->string('Num_Factura');
            $table->datetime('Fecha');
            $table->string('Estado');
            $table->decimal('Subtotal', 10,2);
            $table->decimal('IVA',10,2)->nullable();
            $table->decimal('Descuento', 10,2)->nullable();
            $table->decimal('Total', 10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recepciones');
    }
};
