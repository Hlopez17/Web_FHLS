<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Detalle_Mov extends Model
{
     // Nombre de la tabla 
    protected $table = 'Detalle_Mov';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Id_detallemov';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Id_movimiento',
        'Idproducto',
        'Idbodega',
        'Cantidad',
        'Importe'
    ]; 

    public function bodega()
    {
        return $this->belongsTo(Bodega::class, 'Idbodega','Idbodega');
    }

    public function movimiento()
    {
        return $this->belongsTo(Movimiento::class, 'Id_movimiento','Id_movimiento');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'Idproducto','Idproducto');
    }
}
