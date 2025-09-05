<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subcategoria extends Model
{
    use HasFactory;

    // Nombre de la tabla 
    protected $table = 'subcategorias';

    // Se define como PrimaryKey y autoincremental
    protected $primaryKey = 'Idsubcat';
    public $incrementing = true;
    // protected $keyType = 'int'; // si lo quieres forzar como entero

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Nombre_subcat',
        'Idcategoria',
        'created_at',
        'updated_at'
    ]; 

    // Relaciones
    public function categoria()
    {
        return $this->belongsTo(Categoria::class,'Idcategoria', 'Idcategoria');
    }

    public function productos()
    {
        return $this->hasMany(Producto::class,'Idsubcat', 'Idsubcat');
    }
}
