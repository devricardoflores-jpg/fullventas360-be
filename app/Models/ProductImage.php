<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    //
      protected $table = 'product_image';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'image_path',
        'created_at',
        'update_at'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Una imagen pertenece a un producto
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
