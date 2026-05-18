<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    //
     protected $table = 'detalle_ventas';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'sales_id',
        'product_id',
        'quantity',
        'unit_price',
        'subtotal',
        'created_at',
        'update_at'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Un detalle pertenece a una venta
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'sales_id', 'id');
    }

    // Un detalle pertenece a un producto
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
