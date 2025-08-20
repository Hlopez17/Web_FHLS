<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tipo_Entrega extends Model
{
      // Nombre de la tabla 
    protected $table = 'Tipo_entrega';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Id_tipoentrega';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Descripcion'
    ]; 

    public function factura()
    {
        return $this->hasMany(Factura::class, 'Id_tipoentrega', 'Id_tipoentrega');
    }
}
