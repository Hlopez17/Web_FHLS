<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{
        // Nombre de la tabla 
    protected $table = 'Clientes';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Idcliente';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Cedula',
        'Nombre',
        'Apellido',
        'Telefono',
        'Correo',
        'Limitecredito',
        'Saldocredito'
    ]; 

    public function cotizacion()
    {
        return $this->hasMany(Cotizacion::class, 'Idcliente','Idcliente');
    }

    public function factura()
    {
        return $this->hasMany(Factura::class, 'Idcliente','Idcliente');
    }

    public function cuentascobrar()
    {
        return $this->hasMany(Cuentas_cobrar::class, 'Idcliente','Idcliente');
    }
}
