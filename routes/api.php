<?php

use App\Http\Controllers\Api\ApiBffController;
use App\Http\Controllers\Api\AuthController;
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

Route::get('/authorize', [AuthController::class, 'login'])->name('api.authorize.login');
Route::delete('/authorize', [AuthController::class, 'quit'])->name('api.authorize.quit');

Route::post('/', [ApiBffController::class, 'redirect']);

Route::post('/news', [\App\Http\Controllers\Api\NewsController::class, 'store'])->name('api.news.store');
Route::put('/news', [\App\Http\Controllers\Api\NewsController::class, 'update'])->name('api.news.update');
Route::get('/news', [\App\Http\Controllers\Api\NewsController::class, 'show'])->name('api.news.show');
Route::delete('/news', [\App\Http\Controllers\Api\NewsController::class, 'destroy'])->name('api.news.destroy');

Route::get('/barter', [\App\Http\Controllers\Api\BarterController::class, 'index']);
Route::post('/barter', [\App\Http\Controllers\Api\BarterController::class, 'store']);
Route::put('/barter/{id}', [\App\Http\Controllers\Api\BarterController::class, 'update']);
Route::get('/barter/{id}', [\App\Http\Controllers\Api\BarterController::class, 'show']);
Route::delete('/barter/{id}', [\App\Http\Controllers\Api\BarterController::class, 'destroy']);

Route::get('/canteen', [\App\Http\Controllers\Api\CanteenController::class, 'show'])->name('api.canteen.show');
Route::post('/canteen', [\App\Http\Controllers\Api\CanteenController::class, 'store'])->name('api.canteen.store');
Route::put('/canteen/{id}', [\App\Http\Controllers\Api\CanteenController::class, 'update'])->name('api.canteen.update');
Route::delete('/canteen/{id}', [\App\Http\Controllers\Api\CanteenController::class, 'destroy'])->name('api.canteen.destroy');

Route::get('/storage/{filename}', '\App\Http\Controllers\Api\StorageController@getImage')->where('filename', '(.*)');
