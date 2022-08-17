<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BabyPeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('/auth')->controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->name('auth.login');
    Route::post('join', 'join')->name('auth.join');
});

Route::middleware('auth:sanctum')->group(function () {
    // # 회원 인증
    Route::prefix('auth')->controller(AuthController::class)->group(function(){
        Route::post('logout', 'logout')->name('auth.logout');
        Route::delete('withdraw', 'withdraw')->name('auth.withdraw');
    });
    // # Pee
    Route::prefix('pee')->controller(BabyPeeController::class)->group(function () {
        Route::get('/',  'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{list}', 'show')->name('show');
        Route::patch('/{list}', 'update')->name('update');
        Route::delete('/{list}', 'destroy')->name('delete');
    });
});
