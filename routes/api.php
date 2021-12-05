<?php

use App\Http\Controllers\CollectController;
use App\Http\Controllers\ObjectController;
use App\Http\Controllers\UserController;
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
Route::get('user-info', [UserController::class, 'userInfo']);
Route::get('guide/{username}', [ObjectController::class, 'collectGuide']);
Route::get('user/request-collect/{name}/{count}', [ObjectController::class, 'requestCollect']);
Route::get('user/history', [ObjectController::class, 'history']);
Route::get('driver/user-list', [CollectController::class, 'usersToCollect']);
Route::get('driver/user/requests/', [CollectController::class, 'UserRequest']);
Route::get('driver/user/confirm/{request_id}/{weight}', [CollectController::class, 'collected']);