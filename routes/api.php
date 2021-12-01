<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TasksController;

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
// Route::group(['middleware' => ['web']], function() {
//     Route::post('user/validate/', [LoginController::class, 'validate_num']);
//     Route::post('user/auth/', [LoginController::class,'auth']);
// });
Route::post('user/validate/', [LoginController::class, 'validate_num'])->middleware('web');
Route::post('user/auth/', [LoginController::class,'auth'])->middleware('web');

Route::group(['middleware' => ['auth:sanctum', 'web']], function () {
    //users
    Route::get('/users/admins', 'App\Http\Controllers\UsersController@indexAdmins');
    Route::get('/users/subs', 'App\Http\Controllers\UsersController@indexSubs');
    //tasks
    Route::get('/users/admins/tasks', 'App\Http\Controllers\TasksController@indexAdmin');
    Route::get('/users/subs/tasks', 'App\Http\Controllers\TasksController@indexSub');
    Route::post('/tasks', 'App\Http\Controllers\TasksController@store' );
});


Route::get('user/logout', function()
{
  Auth::logout();
  return \Response::json(array("success" => true));
});

// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/logout', 'App\Http\Controllers\UsersController@logout')->name('logout.api');
//     Route::get('/user', 'App\Http\Controllers\UsersController@userdata')->name('user.api');

// });

// Route::get('/register', 'App\Http\Controllers\Auth\RegisterController@register')->name('register.api');
// Route::get('/login', 'App\Http\Controllers\Auth\UsersController@login')->name('login.api');
