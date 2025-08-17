<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Proveedor extends Model
{
     // Nombre de la tabla 
    protected $table = 'Proveedor';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Idproveedor';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Razon_social',
        'Telefono',
        'Direccion',
        'Correo'
    ]; 

    public function productoprov()
    {
        return $this->hasMany(DetalleKit::class, 'Idkit','Idkit');
    }
}
