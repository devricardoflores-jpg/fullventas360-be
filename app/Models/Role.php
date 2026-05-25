<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'configuracion_id',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    // Un rol pertenece a una configuración/empresa
    public function configuracion()
    {
        return $this->belongsTo(Configuracion::class);
    }

    // Un rol tiene muchos usuarios
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Relación muchos a muchos con menus
    public function menus()
    {
        return $this->belongsToMany(
            Menu::class,
            'role_menu',
            'role_id',
            'menu_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeByConfiguracion($query, $configuracionId)
    {
        return $query->where('configuracion_id', $configuracionId);
    }
}