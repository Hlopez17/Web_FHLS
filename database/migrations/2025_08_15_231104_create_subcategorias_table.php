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
        Schema::create('subcategorias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Idcategoria');
            $table->foreign('Idcategoria')->references('Idcategoria')->on('categorias');
            $table->string('Nombre_subcat');
            $table->timestamps();
        });
    }

          //  $table->foreign('codigo_producto')->references('codigo_producto')->on('productos');

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subcategorias');
    }
};
