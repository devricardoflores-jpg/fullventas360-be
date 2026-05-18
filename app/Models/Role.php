<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
     protected $table = 'roles';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // Un rol tiene muchos usuarios
    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }

    public function menus()
{
    return $this->belongsToMany(

        Menu::class,

        'role_menu',

        'role_id',

        'menu_id'

    );
}
}
