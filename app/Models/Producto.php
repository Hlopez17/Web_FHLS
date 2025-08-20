<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producto extends Model
{
     // Nombre de la tabla 
    protected $table = 'Productos';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Idproducto';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Idsubcat',
        'Id_Medida',
        'Codigo_barra',
        'Nombre',
        'foto',
        'Precio_costo',
        'Precio_venta',
        'Precio_descuento',
        'Precio_Mayorista',
        'Estado'
    ]; 

     public function unidadmedida()
     {
        return $this->belongsTo(Unidadmedida::class, 'Id_Medida','Id_Medida');
     }

      public function Productoprov()
     {
        return $this->hasMany(Productoprov::class, 'Idproducto','Idproducto');
     }

      public function detalleinv()
    {
        return $this->hasMany(Detalle_inv::class, 'Idproducto','Idproducto');
    }

     public function detallemov()
      {
        return $this->hasMany(Detalle_Mov::class, 'Idproducto','Idproducto');
      }

      public function subcat()
      {
         return $this->belongsTo(Subcategoria::class, 'Idsubcat','Idsubcat');
      }

      public function detallecot()
      {
         return $this->hasMany(Detalle_cot::class, 'Idproducto','Idproducto');
      }

     //Idsubcat
}
