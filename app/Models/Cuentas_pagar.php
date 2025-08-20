<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cuentas_pagar extends Model
{
     // Nombre de la tabla 
    protected $table = 'Cuentas_pagar';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Id_cuentapagar';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Idrecepcion',
        'Idproveedor',
        'Estado',
        'Fecha_emision',
        'Fecha_vencimiento',
        'Saldo_pendiente',
        'Total'
    ]; 

    public function recepcion()
    {
        return $this->belongsTo(Tipo_Entrega::class, 'Idrecepcion','Idrecepcion');
    }
    //Pendiente los has Many en recepcion y proveedor    

    public function proveedor()
    {
        return $this->belongsTo(Tipo_Entrega::class, 'Idproveedor','Idproveedor');
    }

    public function abonoprov()
    {
        return $this->hasMany(Abono_proveedor::class, 'Id_cuentapagar','Id_cuentapagar');
    }
}
