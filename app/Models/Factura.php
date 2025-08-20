<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Factura extends Model
{
     // Nombre de la tabla 
    protected $table = 'Factura';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'IdFactura';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Id_tipoentrega',
        'Id_tipopago',
        'Idusuario',
        'Idcliente',
        'Estado',
        'Fecha',
        'subtotal',
        'Descuento',
        'Total'
    ]; 

    public function tipoentrega()
    {
        return $this->belongsTo(Tipo_Entrega::class, 'Id_tipoentrega','Id_tipoentrega');
    }

    public function tipopago()
    {
        return $this->belongsTo(Tipo_pago::class, 'Id_tipopago','Id_tipopago');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'Idusuario','Idusuario');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'Idcliente','Idcliente');
    }

    public function detallefact()
    {
        return $this->hasMany(Detalle_Fac::class, 'IdFactura','IdFactura');
    }

    public function cuentascobrar()
    {
        return $this->hasMany(Cuentas_cobrar::class, 'IdFactura','IdFactura');
    }

    public function devoluciones()
    {
        return $this->hasMany(Devoluciones::class, 'IdFactura','IdFactura');
    }
    //Detalle_Fac
}
