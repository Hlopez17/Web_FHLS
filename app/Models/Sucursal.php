<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sucursal extends Model
{
  // Nombre de la tabla 
    protected $table = 'sucursals';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Idsucursal';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Nombre_Sucursal',
        'Direccion',
        'Gerente'
    ]; 

//    public function users()
//     {
//         return $this->belongsTo(User::class, 'Gerente', 'Idusuario');
//     }

    public function bodegas()
    {
       return $this->hasMany(Bodega::class, 'Idsucursal', 'Idsucursal');
    } 
}
