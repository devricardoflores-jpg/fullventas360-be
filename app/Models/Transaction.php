<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //

       protected $table = 'Transactions';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'type',
        'amount',
        'reference_id',
        'description',
        'user_id',
        'created_at',
        'update_at'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Una transacción pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
