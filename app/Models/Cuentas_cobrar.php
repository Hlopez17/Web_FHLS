<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cuentas_cobrar extends Model
{
     // Nombre de la tabla 
    protected $table = 'cuentas_cobrars';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Id_cuentacobrar';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'IdFactura',
        'Idcliente',
        'Estado',
        'Fecha_emision',
        'Fecha_vencimiento',
        'Saldo_pendiente',
        'Total'
    ]; 


    public function abonocliente()
    {
        return $this->hasMany(Abono_cliente::class, 'Id_cuentacobrar','Id_cuentacobrar');
    }
    
    public function factura()
    {
        return $this->belongsTo(Factura::class, 'IdFactura','IdFactura');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'Idcliente','Idcliente');
    }

    

    
}
