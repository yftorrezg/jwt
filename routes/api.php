<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EquipoController; // !agregar


// !agregar
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// RUTAS ABIERTAS
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// RUTAS PROTEGIDAS
Route::middleware('jwt.verify')->group(function () {
    Route::get('users', [UserController::class, 'index']);
    Route::get('equipo', [EquipoController::class, 'index']);
    Route::get('equipo/{equipo}', [EquipoController::class, 'show']);
    Route::post('equipo', [EquipoController::class, 'store']);
    Route::post('equipo/{equipo}', [EquipoController::class, 'update']);
    Route::delete('equipo/{equipo}', [EquipoController::class, 'destroy']);
});

// equipo 😀😀😀😀😀😀

/* 
Route::get('/equipo', [EquipoController::class, 'index']);
Route::get('/equipo/{equipo}', [EquipoController::class, 'show']);
Route::post('/equipo', [EquipoController::class, 'store']);
Route::put('/equipo/{equipo}', [EquipoController::class, 'update']);
Route::delete('/equipo/{equipo}', [EquipoController::class, 'destroy']); 
*/