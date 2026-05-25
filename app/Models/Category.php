<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
     protected $table = 'categories';

    protected $fillable = [

        'configuracion_id',

        'name',

        'description'

    ];

    // =========================
    // SUCURSALES
    // =========================

    public function sucursales()
    {
        return $this->belongsToMany(

            Sucursal::class,

            'category_sucursal',

            'category_id',

            'sucursal_id'

        );
    }

    // =========================
    // PRODUCTOS
    // =========================

    public function products()
    {
        return $this->hasMany(

            Product::class,

            'category_id'

        );
    }
}