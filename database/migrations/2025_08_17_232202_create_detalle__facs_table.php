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
        Schema::create('detalle_facs', function (Blueprint $table) {
            $table->id('Id_detallefac');
            $table->unsignedBigInteger('IdFactura');
            $table->foreign('IdFactura')->references('IdFactura')->on('facturas');
            $table->unsignedBigInteger('Idproducto');
            $table->foreign('Idproducto')->references('Idproducto')->on('productos');
            $table->unsignedBigInteger('Idbodega');
            $table->foreign('Idbodega')->references('Idbodega')->on('bodegas');
            $table->unsignedBigInteger('Idkit');
            $table->foreign('Idkit')->references('Idkit')->on('kits');
            $table->decimal('Cantidad',10,2);
            $table->decimal('Descuento',10,2);
            $table->decimal('Precio', 10,2);
            $table->decimal('Importe', 10,2);
            $table->string('Devolucion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle__facs');
    }
};
