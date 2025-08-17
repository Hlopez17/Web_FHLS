<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
     // Nombre de la tabla 
    protected $table = 'Productos';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Idproducto';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Idsubcat',
        'Id_Medida',
        'Cantidad',
        'Codigo_barra',
        'Nombre',
        'Precio_costo',
        'Precio_venta',
        'Precio_descuento',
        'Precio_Mayorista',
        'Estado'
    ]; 

     public function unidadmedida()
     {
        return $this->belongsTo(Unidadmedida::class, 'Id_Medida','Id_Medida');
     }
}
