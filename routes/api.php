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

Route::post('/news', [\App\Http\Controllers\Api\NewsController::class, 'store'])->middleware('acctoken');
Route::put('/news/{id}', [\App\Http\Controllers\Api\NewsController::class, 'update'])->middleware('acctoken');
Route::get('/news/{id}', [\App\Http\Controllers\Api\NewsController::class, 'show'])->middleware('acctoken');
Route::delete('/news/{id}', [\App\Http\Controllers\Api\NewsController::class, 'destroy'])->middleware('acctoken');

Route::get('/barter', [\App\Http\Controllers\Api\BarterController::class, 'index'])->middleware('acctoken');
Route::post('/barter', [\App\Http\Controllers\Api\BarterController::class, 'store'])->middleware('acctoken');
Route::put('/barter/{id}', [\App\Http\Controllers\Api\BarterController::class, 'update'])->middleware('acctoken');
Route::get('/barter/{id}', [\App\Http\Controllers\Api\BarterController::class, 'show'])->middleware('acctoken');
Route::delete('/barter/{id}', [\App\Http\Controllers\Api\BarterController::class, 'destroy'])->middleware('acctoken');

Route::get('/canteen', [\App\Http\Controllers\Api\CanteenController::class, 'index'])->middleware('acctoken');
Route::post('/canteen', [\App\Http\Controllers\Api\CanteenController::class, 'store'])->middleware('acctoken');
Route::put('/canteen/{id}', [\App\Http\Controllers\Api\CanteenController::class, 'update'])->middleware('acctoken');
Route::delete('/canteen/{id}', [\App\Http\Controllers\Api\CanteenController::class, 'destroy'])->middleware('acctoken');

Route::post('/admin', [\App\Http\Controllers\Api\AdminsController::class, 'index']);

Route::get('/storage/{filename}', '\App\Http\Controllers\Api\StorageController@getImage')->where('filename', '(.*)');
