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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id('Idcliente');
            $table->string('Cedula')->nullable();
            $table->string('Nombre');
            $table->string('Apellido');
            $table->string('Telefono')->nullable();
            $table->string('Correo')->nullable();
            $table->decimal('Limitecredito', 10, 2)->nullable();
            $table->decimal('Saldocredito', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
