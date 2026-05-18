<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'Compras';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'supplier_id',
        'user_id',
        'tipodocumento_id',
        'total_cost',
        'purchase_date',
        'status',
        'created_at',
        'updated_at'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Una compra pertenece a un proveedor
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    // Una compra pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Una compra pertenece a un tipo de documento
    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipodocumento_id', 'id');
    }

    // Una compra tiene muchos detalles
    public function detalleCompras()
    {
        return $this->hasMany(DetalleCompra::class, 'purchase_id', 'id');
    }
}
