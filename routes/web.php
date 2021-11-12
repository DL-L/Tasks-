<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\TasksController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::post('user/validate/', [LoginController::class, 'validate_num']);
Route::post('user/auth/', [LoginController::class,'auth']);
Route::get('/', function(Request $request)
    {
      return 'Unauthenticated';
    })->name('login');

Route::get('/users/admins', 'App\Http\Controllers\UsersController@indexAdmins');

Route::get('tasks', 'App\Http\Controllers\TasksController@index');

Route::get('/users/subs', 'App\Http\Controllers\UsersController@indexSubs');

Route::get('/users/admins/{id}', 'App\Http\Controllers\UsersController@showAdminTasks');

Route::get('/users/subs/{id}', 'App\Http\Controllers\UsersController@showSubTasks');

Route::resource('/tasks', TasksController::class);

Route::get('users/admins/tasks/{id}', 'App\Http\Controllers\TasksController@show');

Route::get('user/logout', function()
{
  Auth::logout();
  return \Response::json(array("success" => true));
});
