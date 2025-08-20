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
        Schema::create('cuentas_pagars', function (Blueprint $table) {
            $table->id('Id_cuentapagar');
            $table->unsignedBigInteger('Idrecepcion');
            $table->foreign('Idrecepcion')->references('Idrecepcion')->on('recepciones');
            $table->unsignedBigInteger('Idproveedor');
            $table->foreign('Idproveedor')->references('Idproveedor')->on('proveedors');
            $table->string('Estado');
            $table->date('Fecha_emision');
            $table->date('Fecha_vencimiento');
            $table->decimal('Saldo_pendiente',10,2);
            $table->decimal('Total', 10,2);
            $table->timestamps();

       
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuentas_pagars');
    }
};
