<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImage;

class Product extends Model
{
   use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'configuracion_id',
        'sucursal_id',
        'category_id',
        'user_id',
        'name',
        'description',
        'price',
        'quantity',
        'status',
        'barcode',
        'qrcode',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'price' => 'decimal:2'
    ];

    /* ================= RELACIONES ================= */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}