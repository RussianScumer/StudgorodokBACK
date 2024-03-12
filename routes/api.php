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
Route::put('/news/{id}',[\App\Http\Controllers\Api\NewsController::class, 'update']);
Route::get('/news/{id}', [\App\Http\Controllers\Api\NewsController::class, 'show']);
Route::delete('/news/{id}', [\App\Http\Controllers\Api\NewsController::class, 'destroy']);
