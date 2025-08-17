<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetalleKit extends Model
{
     // Nombre de la tabla 
    protected $table = 'Detallekit';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Id_detallekit';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Idkit',
        'Idproducto',
        'Cantidad'
    ]; 

     public function kit()
     {
        return $this->belongsTo(Kit::class, 'Idkit','Idkit');
     }
}
