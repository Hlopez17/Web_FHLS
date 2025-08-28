<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categoria extends Model
{
    //
      // Nombre de la tabla 
<<<<<<< HEAD
    protected $table = 'categorias';
=======
    protected $table = 'Categorias';
>>>>>>> 13b3d461d8bc4249d6bb121107be16ea3c4b9c25

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Idcategoria';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Nombre_cat'
        
    ]; 

   public function subcategoria()
    {
        return $this->hasMany(Subcategoria::class, 'Idcategoria', 'Idcategoria');
    }
}
