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
        Schema::create('productos', function (Blueprint $table) {
            $table->id('Idproducto');
            $table->unsignedBigInteger('Idsubcat');
            $table->foreign('Idsubcat')->references('Idsubcat')->on('subcategorias');
            $table->unsignedBigInteger('Id_Medida');
            $table->foreign('Id_Medida')->references('Id_Medida')->on('unidadmedidas');
            $table->string('Codigo_barra');
            $table->string('Nombre');
            $table->string('foto')->nullable(); // Guarda el path de la foto
            $table->decimal('Precio_costo', 10,2);
            $table->decimal('Precio_venta',10,2);
            $table->decimal('Precio_descuento',10,2);
            $table->decimal('Precio_Mayorista',10,2);
            $table->string('Estado');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
