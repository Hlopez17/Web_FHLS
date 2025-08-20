<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Abono_cliente extends Model
{
     // Nombre de la tabla 
    protected $table = 'Abono_cliente';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Id_abonocliente';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Id_cuentacobrar',
        'Idusuario',
        'Id_tipopago',
        'Referencia',
        'Num_abono',
        'Fecha',
        'Monto_abono'
    ]; 

    public function cuentacobrar()
    {
        return $this->belongsTo(Cuentas_cobrar::class, 'Id_cuentacobrar','Id_cuentacobrar');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'Idusuario','Idusuario');
    }

    public function tipopago()
    {
        return $this->belongsTo(Tipo_pago::class, 'Id_tipopago','Id_tipopago');
    }

    

    

}
