<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Detalle_cot extends Model
{
      // Nombre de la tabla 
    protected $table = 'Detalle_cot';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Id_detallecot';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Id_Cotizacion',
        'Idproducto',
        'Idkit',
        'Cantidad',
        'Precio',
        'Descuento',
        'Tipo_precio',
        'Importe'
    ]; 

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class, 'Id_Cotizacion','Id_Cotizacion');
    }

    public function kit()
    {
        return $this->belongsTo(Kit::class, 'Idkit','Idkit');
    }
    
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'Idproducto','Idproducto');
    }

    

}
