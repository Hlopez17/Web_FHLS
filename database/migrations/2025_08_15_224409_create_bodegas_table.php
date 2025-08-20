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
        Schema::create('bodegas', function (Blueprint $table) {
            $table->id('Idbodega');
            $table->string('Nombre_bodega');
            $table->string('Direccion')->nullable();
            $table->unsignedBigInteger('Idsucursal');
            $table->foreign('Idsucursal')->references('Idsucursal')->on('sucursals');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bodegas');
    }
};
