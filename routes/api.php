<?php

use App\Http\Controllers\Api\AuthOrioksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/authtorize', [AuthOrioksController::class, 'store']);

Route::get('/news', [\App\Http\Controllers\Api\NewsController::class, 'index']);
Route::post('/news', [\App\Http\Controllers\Api\NewsController::class, 'store']);
Route::put('/news/{id}', [\App\Http\Controllers\Api\NewsController::class, 'update']);
Route::get('/news/{id}', [\App\Http\Controllers\Api\NewsController::class, 'show']);
Route::delete('/news/{id}', [\App\Http\Controllers\Api\NewsController::class, 'destroy']);

Route::get('/barter', [\App\Http\Controllers\Api\BarterController::class, 'index']);
Route::post('/barter', [\App\Http\Controllers\Api\BarterController::class, 'store']);
Route::put('/barter/{id}', [\App\Http\Controllers\Api\BarterController::class, 'update']);
Route::get('/barter/{id}', [\App\Http\Controllers\Api\BarterController::class, 'show']);
Route::delete('/barter/{id}', [\App\Http\Controllers\Api\BarterController::class, 'destroy']);

Route::get('/canteen', [\App\Http\Controllers\Api\CanteenController::class, 'index']);
Route::post('/canteen', [\App\Http\Controllers\Api\CanteenController::class, 'store']);
Route::put('/canteen/{id}', [\App\Http\Controllers\Api\CanteenController::class, 'update']);
Route::get('/canteen/{id}', [\App\Http\Controllers\Api\CanteenController::class, 'show']);
Route::delete('/canteen/{id}', [\App\Http\Controllers\Api\CanteenController::class, 'destroy']);

Route::post('/admin', [\App\Http\Controllers\Api\AdminsController::class, 'index']);

Route::get('/storage/{filename}', '\App\Http\Controllers\Api\StorageController@getImage')->where('filename', '(.*)');
