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
        Schema::create('detalle_invs', function (Blueprint $table) {
            $table->id('Id_detalleinv');
            $table->unsignedBigInteger('Id_inventario');
            $table->foreign('Id_inventario')->references('Id_inventario')->on('inventarios');
            $table->unsignedBigInteger('Idproducto');
            $table->foreign('Idproducto')->references('Idproducto')->on('productos');
            $table->decimal('Cantidad', 10,2);
            $table->Interger('Min_stock');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_invs');
    }
};
