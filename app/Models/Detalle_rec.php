<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Detalle_rec extends Model
{
      // Nombre de la tabla 
    protected $table = 'Detalle_rec';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Id_detallerec';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Idrecepcion',
        'Idproducto',
        'Idbodega',
        'Cantidad',
        'Precio_costo',
        'Importe'
    ]; 

    public function recepcion()
    {
        return $this->belongsTo(Recepciones::class, 'Idrecepcion','Idrecepcion');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'Idproducto','Idproducto');
    }

    public function bodega()
    {
        return $this->belongsTo(Bodega::class, 'Idbodega','Idbodega');
    }

   
}
