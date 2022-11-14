<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\DesaController;
use App\Http\Controllers\API\V1\WisataController;

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

Route::prefix('v1')->group(function () {
    Route::apiResource('wisata', WisataController::class);

    Route::post('wisata/{id}/image', [WisataController::class, 'upload']);

    Route::get('desa', [DesaController::class, 'index']);
    Route::post('villages', [DesaController::class, 'store']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('users', UserController::class);

        Route::post('logout', [AuthController::class, 'logout']);
    });
});

