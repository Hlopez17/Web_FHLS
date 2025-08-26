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
        Schema::create('abono_clientes', function (Blueprint $table) {
            $table->id('Id_abonocliente');
            $table->unsignedBigInteger('Id_cuentacobrar');
            $table->foreign('Id_cuentacobrar')->references('Id_cuentacobrar')->on('cuentas_cobrars');
            $table->unsignedBigInteger('Idusuario');
            $table->foreign('Idusuario')->references('Idusuario')->on('users');
            $table->unsignedBigInteger('Id_tipopago');
            $table->foreign('Id_tipopago')->references('Id_tipopago')->on('tipo_pagos');
            $table->string('Referencia');
            $table->integer('Num_abono'); // Corregido: interger -> integer
            $table->date('Fecha');
            $table->decimal('Monto_abono', 10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abono_clientes');
    }
};