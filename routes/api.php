<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\CourseController;
use App\Http\Controllers\Api\v1\ChapterController;
use App\Http\Controllers\Api\v1\RoleController;
use App\Http\Controllers\Api\v1\PermissionController;
use App\Http\Controllers\Api\AuthController;

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

// auth
Route::group(['prefix' => 'auth'], function () {
  Route::post('/login', [AuthController::class, 'login']);
  Route::post('/register', [AuthController::class, 'register']);
  Route::post('/logout', [AuthController::class, 'logout']);
  Route::post('/refresh-token', [AuthController::class, 'refresh_token']);
  Route::get('/show-logged-user-data', [AuthController::class, 'show_logged_user_data']);
});

Route::group(['prefix' => 'v1', 'middleware' => 'CheckToken'], function(){
  // custome api url
  Route::post('/role/assign-role-to-user', [RoleController::class, 'assign_role_to_user'])->name('role.assign_role_to_user');

  // resource api url
  Route::apiResource('course', CourseController::class);
  Route::apiResource('chapter', ChapterController::class);
  Route::apiResource('role', RoleController::class);
  Route::apiResource('permission', PermissionController::class);
});
