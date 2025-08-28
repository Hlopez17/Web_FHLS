<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rol extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'rols';

    // Clave primaria
    protected $primaryKey = 'Idrol';
    public $incrementing = true; // autoincremental
    //protected $keyType = 'int'; // si quieres especificar tipo entero

    // Campos de la base de datos
    // Idrol -> clave primaria
    // nombre -> nombre del rol
    // descripcion -> descripción del rol
    protected $fillable = [
        'nombre',
        'descripcion'
    ]; 

    /**
     * Relación uno a muchos con usuarios
     * Un rol puede tener muchos usuarios
     */
    public function users()
    {
        return $this->hasMany(User::class, 'Idrol', 'Idrol');
    }
}
