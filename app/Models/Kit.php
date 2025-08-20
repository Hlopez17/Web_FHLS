<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kit extends Model
{
     // Nombre de la tabla 
    protected $table = 'Kit';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Idkit';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Nombre_kit',
        'Precio_kit'
    ]; 

    public function detallekit()
    {
        return $this->hasMany(DetalleKit::class, 'Idkit','Idkit');
    }

    public function detallefac()
    {
        return $this->hasMany(Detalle_Fac::class, 'Idkit','Idkit');
    }

    public function detallecot()
    {
        return $this->hasMany(Detalle_cot::class, 'Idkit','Idkit');
    }
    
    
}
