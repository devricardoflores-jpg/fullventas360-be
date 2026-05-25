<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sucursal extends Model
{
    use HasFactory;

    protected $table = 'sucursales';

    protected $fillable = [
        'configuracion_id',
        'codigo',
        'nombre',
        'ruc',
        'telefono',
        'email',
        'direccion',
        'ciudad',
        'pais',
        'logo',
        'serie_factura',
        'serie_boleta',
        'estado',
    ];

    protected $casts = [
        'estado' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    public function configuracion()
    {
        return $this->belongsTo(Configuracion::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function almacenes()
    {
        return $this->hasMany(Almacen::class);
    }

    public function cajas()
    {
        return $this->hasMany(Caja::class);
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    public function compras()
    {
        return $this->hasMany(Compra::class);
    }



    public function categories()
{
    return $this->belongsToMany(

        Category::class,

        'category_sucursal',

        'sucursal_id',

        'category_id'

    );
}
}