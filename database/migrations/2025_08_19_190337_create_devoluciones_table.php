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
        Schema::create('devoluciones', function (Blueprint $table) {
            $table->id('Id_devolucion');
            $table->unsignedBigInteger('IdFactura');
            $table->foreign('IdFactura')->references('IdFactura')->on('facturas');
            $table->unsignedBigInteger('Idusuario');
            $table->foreign('Idusuario')->references('Idusuario')->on('users');
            $table->datetime('Fecha_dev');
            $table->decimal('Total_devuelto',10,2);
            $table->timestamps();

        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devoluciones');
    }
};
