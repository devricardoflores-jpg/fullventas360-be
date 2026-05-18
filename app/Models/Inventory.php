<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    //
     protected $table = 'Inventories';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'type',
        'quantity',
        'reason',
        'user_id',
        'created_at',
        'updated_at'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Un movimiento de inventario pertenece a un producto
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    // Un movimiento de inventario pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
