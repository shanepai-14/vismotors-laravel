<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
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

Route::middleware('auth:sanctum')->get('/user', function () {

});

Route::post('/login', [ApiController::class, 'login']);
Route::group(['middleware' => ['auth:sanctum']] ,function () {
    Route::get('/balance/{userId}', [ApiController::class, 'getUserBalance']);
    Route::get('/payments/{userId}', [ApiController::class, 'getUserPayments']);
});

Route::get('/user', [ApiController::class, 'getUserByContract']);