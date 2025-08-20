<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movimiento extends Model
{
     // Nombre de la tabla 
    protected $table = 'Movimiento';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Id_movimiento';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'Idusuario',
        'Idcliente',
        'Motivo',
        'Tipo_Mov',//Entrada o Salida
        'Total_Mov'
    ]; 

    

    public function usuario()
    {
        return $this->belongsTo(User::class, 'Idusuario','Idusuario');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'Idcliente','Idcliente');
    }

    public function detalleMov()
    {
        return $this->hasMany(Detalle_Mov::class, 'Id_movimiento','Id_movimiento');
    }
}
