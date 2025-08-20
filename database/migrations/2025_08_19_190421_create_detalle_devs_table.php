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
    {//
        Schema::create('detalle_devs', function (Blueprint $table) {
            $table->id('Id_detalledev');
            $table->unsignedBigInteger('Id_devolucion');
            $table->foreign('Id_devolucion')->references('Id_devolucion')->on('devoluciones');
            $table->unsignedBigInteger('Id_detallefac');
            $table->foreign('Id_detallefac')->references('Id_detallefac')->on('detalle_facs');
            $table->decimal('Cantidad_dev',10,2);
            $table->decimal('Precio',10,2);
            $table->decimal('Subtotal_dev',10,2);
            $table->timestamps();

        //     'Id_devolucion',
        // 'Id_detallefac',
        // 'Cantidad_dev',
        // 'Precio',
        // 'Subtotal_dev'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_devs');
    }
};
