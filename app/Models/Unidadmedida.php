<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unidadmedida extends Model
{
     //
      // Nombre de la tabla 
    protected $table = 'Unidad_medida';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Id_Medida';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Nombre_Medida'
    ]; 

   public function producto()
    {
        return $this->hasMany(Producto::class, 'Id_Medida', 'Id_Medida');
    }
}
