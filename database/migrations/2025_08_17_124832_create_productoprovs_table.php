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
        Schema::create('productoprovs', function (Blueprint $table) {
            $table->id('Id');
            $table->unsignedBigInteger('Idproveedor');
            $table->foreign('Idproveedor')->references('Idproveedor')->on('proveedors');
            $table->unsignedBigInteger('Idproducto');
            $table->foreign('Idproducto')->references('Idproducto')->on('productos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productoprovs');
    }
};
