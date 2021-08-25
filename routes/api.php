<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\PermissionController;

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
Route::middleware(['auth:api'])->group(function (){
    Route::get('/permissions',[PermissionController::class,'all']);
    Route::get('/get_user',[UserController::class,'get_user']);

});

Route::post('/create_user',[UserController::class,'createUser'])->middleware('auth:api');
Route::post('/login',[UserController::class,'login']);