<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bodega extends Model
{
     // Nombre de la tabla 
    protected $table = 'bodegas';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Idbodega';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Nombre_bodega',
        'Direccion',
        'Idsucursal'
    ]; 

//    public function Detmov()
//     {
//         return $this->hasMany(User::class, 'Gerente', 'Idusuario');
//     }

     public function inventario()
    {
        return $this->hasMany(Inventario::class, 'Idbodega','Idbodega');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'Idsucursal', 'Idsucursal');
    }

    public function detallemov()
    {
        return $this->hasMany(Detalle_Mov::class, 'Idbodega','Idbodega');
    }
}
