<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cotizacion extends Model
{
     // Nombre de la tabla 
    protected $table = 'Cotizacion';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Id_Cotizacion';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Idcliente',
        'Idusuario',
        'Estado',
        'Fecha',
        'subtotal',
        'Descuento',
        'Total'
    ]; 

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'Idcliente','Idcliente');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'Idusuario','Idusuario');
    }

    public function detallecot()
    {
        return $this->hasMany(Detalle_cot::class, 'Id_Cotizacion','Id_Cotizacion');
    }
}
