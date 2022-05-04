<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\AuthManager;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\V1\CustomerController;
use Illuminate\Support\Facades\Auth;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', [CustomerController::class, 'index']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/userInfo', [AuthController::class, 'userInfo'])->middleware('auth:sanctum');
Route::post('/customer/create', [CustomerController::class, 'store']);
Route::get('/customer/{dni}', [CustomerController::class, 'show']);
Route::post('/customer/delete/{dni}', [CustomerController::class, 'destroy']);