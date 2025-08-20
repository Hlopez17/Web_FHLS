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
        Schema::create('cotizacions', function (Blueprint $table) {
            $table->id('Id_Cotizacion');
            $table->unsignedBigInteger('Idcliente');
            $table->foreign('Idcliente')->references('Idcliente')->on('clientes');
            $table->unsignedBigInteger('Idusuario');
            $table->foreign('Idusuario')->references('Idusuario')->on('users');
            $table->string('Estado')->nullable();
            $table->datetime('Fecha');
            $table->decimal('subtotal', 10,2);
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
        Schema::dropIfExists('cotizacions');
    }
};
