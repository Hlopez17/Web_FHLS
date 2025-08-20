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
        Schema::create('detalle_cots', function (Blueprint $table) {
            $table->id('Id_detallecot');
            $table->unsignedBigInteger('Id_Cotizacion');
            $table->foreign('Id_Cotizacion')->references('Id_Cotizacion')->on('cotizacions');
            $table->unsignedBigInteger('Idproducto');
            $table->foreign('Idproducto')->references('Idproducto')->on('productos');
            $table->unsignedBigInteger('Idkit');
            $table->foreign('Idkit')->references('Idkit')->on('kits');
            $table->decimal('Cantidad',10,2);
            $table->decimal('Precio',10,2);
            $table->decimal('Descuento', 10,2);
            $table->string('Tipo_precio');
            $table->decimal('Importe', 10,2);
            $table->timestamps();
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_cots');
    }
};
