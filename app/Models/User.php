<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
  use HasApiTokens;

    protected $table = 'users';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'adress',
        'photo',
        'role_id',
        'sucursal_id',
        'configuracion_id',
    ];

       protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

 
      /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */
   // Usuario pertenece a un rol
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Usuario pertenece a una sucursal
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    // Usuario pertenece a una configuración/empresa
    public function configuracion()
    {
        return $this->belongsTo(Configuracion::class);
    }

    // Ventas realizadas por el usuario
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    // Compras registradas por el usuario
    public function compras()
    {
        return $this->hasMany(Compra::class);
    }

    // Movimientos de inventario realizados
    public function movimientosInventario()
    {
        return $this->hasMany(MovimientoInventario::class, 'usuario_id');
    }

    // Transferencias realizadas
    public function transferencias()
    {
        return $this->hasMany(Transferencia::class, 'usuario_id');
    }

    // Transacciones realizadas
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getPhotoUrlAttribute()
    {
        if (!$this->photo) {
            return asset('storage/default.png');
        }

        return asset('storage/' . $this->photo);
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeBySucursal($query, $sucursalId)
    {
        return $query->where('sucursal_id', $sucursalId);
    }

    public function scopeByRole($query, $roleId)
    {
        return $query->where('role_id', $roleId);
    }
}
