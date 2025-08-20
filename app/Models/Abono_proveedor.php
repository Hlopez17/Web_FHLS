<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Abono_proveedor extends Model
{
     // Nombre de la tabla 
    protected $table = 'Abono_proveedor';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Id_abonoprov';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Id_cuentapagar',
        'Id_tipopago',
        'Num_abono',
        'Referencia',
        'Fecha',
        'Monto_abono'
    ]; 

    public function cuentaspagar()
    {
        return $this->belongsTo(Cuentas_pagar::class, 'Id_cuentapagar','Id_cuentapagar');
    }

    public function tipopago()
    {
        return $this->belongsTo(Tipo_pago::class, 'Id_tipopago','Id_tipopago');
    }

    
}
