<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('jwt.verify')->group(function () {
    Route::get('users', [UserController::class, 'index']);
});