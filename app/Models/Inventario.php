<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventario extends Model
{
     // Nombre de la tabla 
    protected $table = 'Inventario';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Id_inventario';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Idbodega'
    ]; 

    public function bodega()
    {
        return $this->belongsTo(Bodega::class, 'Idbodega','Idbodega');
    }

    public function detalleinv()
    {
        return $this->hasMany(Detalle_inv::class, 'Id_inventario','Id_inventario');
    }

    
}
