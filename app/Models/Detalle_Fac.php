<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Detalle_Fac extends Model
{
      // Nombre de la tabla 
    protected $table = 'Detalle_Fac';

    //Se define como PrimaryKey y autoincremental gg
    protected $primaryKey = 'Id_detallefac';
    public $incrementing = true;
    //protected $keyType = 'int';

    // Campos que se pueden asignar de forma masiva
    protected $fillable = [
        'IdFactura',
        'Idbodega',
        'Idproducto',
        'Idkit',
        'Cantidad',
        'Precio',
        'Descuento',
        'Devolucion',
        'Importe'
    ]; 

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'IdFactura','IdFactura');
    }

    public function bodega()
    {
        return $this->belongsTo(Bodega::class, 'Idbodega','Idbodega');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'Idproducto','Idproducto');
    }

    public function kit()
    {
        return $this->belongsTo(Kit::class, 'Idkit','Idkit');
    }

    public function detalledev()
    {
        return $this->hasMany(Detalle_dev::class, 'Id_detallefac','Id_detallefac');
    }

    
}
