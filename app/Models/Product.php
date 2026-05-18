<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'Products';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'price',
        'quantity',
        'category_id',
        'status',
        'created_at',
        'update_at',
        'barcode',
        'qrcode'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Un producto pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Un producto pertenece a una categoría
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    // Un producto tiene muchas imágenes
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    // Un producto tiene muchos detalles de compra
    public function detalleCompras()
    {
        return $this->hasMany(DetalleCompra::class, 'product_id', 'id');
    }

    // Un producto tiene muchos detalles de venta
    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class, 'product_id', 'id');
    }

    // Un producto tiene muchos movimientos de inventario
    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'product_id', 'id');
    }
}
