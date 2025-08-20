<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Detalle_dev extends Model
{
      // Nombre de la tabla 
    protected $table = 'Detalle_dev';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Id_detalledev';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Id_devolucion',
        'Id_detallefac',
        'Cantidad_dev',
        'Precio',
        'Subtotal_dev'
    ]; 

    public function devoluciones()
    {
        return $this->belongsTo(Devoluciones::class, 'Id_devolucion','Id_devolucion');
    }

    public function detallefact()
    {
        return $this->belongsTo(Detalle_Fac::class, 'Id_detallefac','Id_detallefac');
    }
    
}
