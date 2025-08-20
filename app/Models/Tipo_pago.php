<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tipo_pago extends Model
{
     // Nombre de la tabla 
    protected $table = 'Tipo_pago';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Id_tipopago';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Nombre_pago'
    ]; 

    public function factura()
    {
        return $this->hasMany(Factura::class, 'Id_tipopago', 'Id_tipopago');
    }

    public function abonocliente()
    {
        return $this->hasMany(Abono_cliente::class, 'Id_tipopago','Id_tipopago');
    }

    public function abonoprov()
    {
        return $this->hasMany(Abono_proveedor::class, 'Id_tipopago','Id_tipopago');
    }
}
