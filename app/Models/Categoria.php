<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categoria extends Model
{
    use HasFactory;

    // Nombre de la tabla 
    protected $table = 'categorias';

    // Se define como PrimaryKey y autoincremental
    protected $primaryKey = 'Idcategoria';
    public $incrementing = true;
    // protected $keyType = 'int'; // si lo quieres forzar como entero

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Nombre_cat',
        'created_at',
        'updated_at'
    ]; 

    // Relaciones
    public function subcategorias()
    {
        return $this->hasMany(Subcategoria::class, 'Idcategoria', 'Idcategoria');
    }
    public function getRouteKeyName()
    {
       return 'Idcategoria';
    }

}
