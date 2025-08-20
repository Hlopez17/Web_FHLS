<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Productoprov extends Model
{
     // Nombre de la tabla 
    protected $table = 'Producto_prov';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Id';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Idproveedor',
        'Idproducto'
    ]; 

    public function Proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'Idproveedor','Idproveedor');
    }

     public function Producto()
    {
        return $this->belongsTo(Producto::class, 'Idproducto','Idproducto');
    }
}
