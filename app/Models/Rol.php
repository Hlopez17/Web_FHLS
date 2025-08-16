<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rol extends Model
{
     // Nombre de la tabla 
    protected $table = 'rols';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Idrol';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'nombre',
        'descripcion'
    ]; 

   public function users()
    {
        return $this->hasMany(User::class, 'Idrol', 'Idrol');
    }

}




