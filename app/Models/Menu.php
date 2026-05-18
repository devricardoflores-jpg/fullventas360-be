<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
  protected $table = 'menus';

    public $timestamps = false;

    protected $fillable = [

        'name',
        'icon',
        'route',
        'parent_id',
        'sort_order',
        'status'

    ];

    public function children()
    {
        return $this->hasMany(
            Menu::class,
            'parent_id',
            'id'
        );
    }
}