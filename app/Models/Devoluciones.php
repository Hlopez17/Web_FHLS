<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Devoluciones extends Model
{
     // Nombre de la tabla 
    protected $table = 'Devoluciones';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Id_devolucion';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'IdFactura',
        'Idusuario',
        'Fecha_dev',
        'Total_devuelto'
    ]; 

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'IdFactura','IdFactura');
    }
    
    public function usuario()
    {
        return $this->belongsTo(User::class, 'Idusuario','Idusuario');
    }

    public function detalledev()
    {
        return $this->hasMany(Detalle_dev::class, 'Id_devolucion','Id_devolucion');
    }
    
}
