<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subcategoria extends Model
{
      // Nombre de la tabla 
    protected $table = 'Subcategoria';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Idsubcat';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Nombre_subcat',
        'Idcategoria'
    ]; 

     public function categoria()
    {
        return $this->belongsTo(Categoria::class,'Idcategoria', 'Idcategoria');
    }

        public function producto()
    {
        return $this->hasMany(Producto::class,'Idsubcat', 'Idsubcat');
    }
    
}
