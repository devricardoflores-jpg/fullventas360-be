<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    //
     protected $table = 'Ventas';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'user_id',
        'tipodocumento_id',
        'total_price',
        'sale_date',
        'status',
        'payment_method',
        'created_at',
        'updated_at'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Una venta pertenece a un cliente
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    // Una venta pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Una venta pertenece a un tipo de documento
    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'tipodocumento_id', 'id');
    }

    // Una venta tiene muchos detalles
    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class, 'sales_id', 'id');
    }
}
