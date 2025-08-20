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
          Schema::create('detalle_movs', function (Blueprint $table) {
            $table->id('Id_detallemov');
            $table->unsignedBigInteger('Id_movimiento');
            $table->foreign('Id_movimiento')->references('Id_movimiento')->on('movimientos');
            $table->unsignedBigInteger('Idproducto');
            $table->foreign('Idproducto')->references('Idproducto')->on('productos');
            $table->string('Motivo');
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
        Schema::dropIfExists('detalle__movs');
    }
};
