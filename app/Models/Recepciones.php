<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recepciones extends Model
{
     // Nombre de la tabla 
    protected $table = 'Recepciones';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Idrecepcion';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Idproveedor',
        'Idusuario',
        'Id_tipopago',
        'Num_factura',
        'Fecha',
        'Estado',
        'Subtotal',
        'IVA',
        'Descuento',
        'Total'
    ]; 

    

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'Idproveedor','Idproveedor');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'Idusuario','Idusuario');
    }

    public function tipopago()
    {
        return $this->belongsTo(Tipo_pago::class, 'Id_tipopago','Id_tipopago');
    }

    public function detallerecepcion()
    {
        return $this->hasMany(Detalle_rec::class, 'Idrecepcion','Idrecepcion');
    }

    public function cuentascobrar()
    {
        return $this->hasMany(Cuentas_cobrar::class, 'Idrecepcion','Idrecepcion');
    }
    
}
