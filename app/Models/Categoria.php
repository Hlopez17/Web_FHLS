<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categoria extends Model
{
    //
      // Nombre de la tabla 
    protected $table = 'Categorias';

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
