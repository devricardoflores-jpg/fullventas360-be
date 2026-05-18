<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    //

    protected $table = 'detalle_compras';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'purchase_id',
        'product_id',
        'quantity',
        'unit_cost',
        'subtotal',
        'created_at',
        'updated_at'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Un detalle pertenece a una compra
    public function compra()
    {
        return $this->belongsTo(Compra::class, 'purchase_id', 'id');
    }

    // Un detalle pertenece a un producto
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
