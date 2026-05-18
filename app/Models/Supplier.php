<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'Suppliers';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'ruc',
        'name',
        'email',
        'phone',
        'address',
        'photo',
        'status',
        'created_at',
        'update_at'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Un proveedor puede tener muchas compras
    public function compras()
    {
        return $this->hasMany(Compra::class, 'supplier_id', 'id');
    }
}
