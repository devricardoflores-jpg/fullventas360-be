<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Configuracion extends Model
{
    use HasFactory;

    protected $table = 'configuracion';

    protected $fillable = [
        'empresa_nombre',
        'empresa_ruc',
        'empresa_email',
        'empresa_telefono',
        'empresa_direccion',
        'empresa_web',
        'empresa_logo',
        'igv',
        'moneda',
        'simbolo_moneda',
        'serie_factura',
        'serie_boleta',
        'modo_oscuro',
        'mantenimiento',
        'mensaje_ticket',
    ];

    protected $casts = [
        'igv' => 'decimal:2',
        'modo_oscuro' => 'boolean',
        'mantenimiento' => 'boolean',
    ];

    public function sucursales()
    {
        return $this->hasMany(Sucursal::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}