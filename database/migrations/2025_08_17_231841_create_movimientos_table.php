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
          Schema::create('movimientos', function (Blueprint $table) {
            $table->id('Id_movimiento');
            $table->unsignedBigInteger('Idusuario');
            $table->foreign('Idusuario')->references('Idusuario')->on('users');
            $table->unsignedBigInteger('Idcliente');
            $table->foreign('Idcliente')->references('Idcliente')->on('Cliente');
            $table->string('Motivo')->nullable();
            $table->string('Tipo_mov');
            $table->decimal('Total_Mov', 10,2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Movimientos');
    }
};
