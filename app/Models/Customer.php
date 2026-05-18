<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
     protected $table = 'Customers';

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

    // Un cliente puede tener muchas ventas
    public function ventas()
    {
        return $this->hasMany(Venta::class, 'customer_id', 'id');
    }
}
