sasa<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;

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

Route::controller(PlayerController::class)->group(function (){
    Route::get('players', 'index');
    Route::get('players/{id}', 'show');
    Route::post('players', 'store');
    Route::delete('players/{id}', 'destroy');
    Route::put('players/{id}', 'update');
});
