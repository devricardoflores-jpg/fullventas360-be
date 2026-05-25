<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategorySucursal extends Model
{
    protected $table = 'category_sucursal';

    protected $fillable = [

        'category_id',

        'sucursal_id'

    ];

    // =========================
    // CATEGORY
    // =========================

    public function category()
    {
        return $this->belongsTo(

            Category::class,

            'category_id'

        );
    }

    // =========================
    // SUCURSAL
    // =========================

    public function sucursal()
    {
        return $this->belongsTo(

            Sucursal::class,

            'sucursal_id'

        );
    }
}