<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrginizationController;
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

Route::get('/positions', [OrginizationController::class, 'all']);
Route::post('/create-position', [OrginizationController::class, 'createPosition']);
Route::get('/positions/{id}', [OrginizationController::class, 'getPositionById']);
Route::delete('/positions/{id}', [OrginizationController::class, 'removePosition']);
Route::post('/update-positions/{id}', [OrginizationController::class, 'updatePosition']);

