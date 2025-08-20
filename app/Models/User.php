<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $primaryKey = 'Idusuario';
    public $incrementing = true;

    protected $fillable = [
        'name',
        'Apellido',
        'Usuario',
        'email',
        'password',
        'Estado',
        'Telefono',
        'foto_perfil',
        'Idrol',
        'Comision',
        
    ];

     public function rol()
    {
        return $this->belongsTo(Rol::class,'Idrol', 'Idrol');
    }
    
    public function cotizacion()
    {
        return $this->hasMany(Cotizacion::class, 'Idusuario','Idusuario');
    }

     public function factura()
    {
        return $this->hasMany(Factura::class, 'Idusuario','Idusuario');
    }

     public function movimiento()
    {
        return $this->hasMany(Movimiento::class, 'Idusuario','Idusuario');
    }

    public function abonocliente()
    {
        return $this->hasMany(Abono_cliente::class, 'Idusuario','Idusuario');
    }

    public function devoluciones()
    {
        return $this->hasMany(Devoluciones::class, 'Idusuario','Idusuario');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
