<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
     protected $table = 'tipodocumento';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'type',
        'created_at',
        'update_at'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Un tipo de documento puede estar en muchas compras
    public function compras()
    {
        return $this->hasMany(Compra::class, 'tipodocumento_id', 'id');
    }

    // Un tipo de documento puede estar en muchas ventas
    public function ventas()
    {
        return $this->hasMany(Venta::class, 'tipodocumento_id', 'id');
    }
}
