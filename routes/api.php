<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;

use App\Http\Controllers\Api\TipoDocumentoController;

use App\Http\Controllers\Api\SupplierController;

use App\Http\Controllers\Api\CustomerController;

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductImageController;
use App\Http\Controllers\Api\MenuController;
//Route::apiResource('categories', CategoryController::class);

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/

Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Rutas protegidas
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/me', [AuthController::class, 'me']);

       Route::get('/menus', [MenuController::class, 'index']);
    /*
    |--------------------------------------------------------------------------
    | Categories
    |--------------------------------------------------------------------------
    */

    Route::apiResource('categories', CategoryController::class);

    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    */

    Route::apiResource('roles', RoleController::class);

    /*
    |--------------------------------------------------------------------------
    | Tipo documento
    |--------------------------------------------------------------------------
    */
  Route::apiResource('tipodocumentos', TipoDocumentoController::class);


  Route::apiResource('users', UserController::class);

  Route::apiResource('proveedores', SupplierController::class);

  Route::apiResource('clientes', CustomerController::class);

    Route::apiResource('products', ProductController::class);
    Route::apiResource('product-images', ProductImageController::class);

});