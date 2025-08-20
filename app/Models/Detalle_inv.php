<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Detalle_inv extends Model
{
     // Nombre de la tabla 
    protected $table = 'Detalle_inv';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Id_detalleinv';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Id_inventario',
        'Idproducto',
        'cantidad',
        'Min_stock'
    ]; 

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'Idproducto','Idproducto');
    }

    public function inventario()
    {
        return $this->belongsTo(Inventario::class, 'Id_inventario','Id_inventario');
    }
    
}
