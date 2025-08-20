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
        Schema::create('abono_proveedors', function (Blueprint $table) {
            $table->id('Id_abonoprov');
            $table->unsignedBigInteger('Id_cuentapagar');
            $table->foreign('Id_cuentapagar')->references('Id_cuentapagar')->on('cuentas_pagars');
            $table->unsignedBigInteger('Id_tipopago');
            $table->foreign('Id_tipopago')->references('Id_tipopago')->on('tipo_pagos');
            $table->string('Referencia');
            $table->interger('Num_abono');
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
        Schema::dropIfExists('abono_proveedors');
    }
};
