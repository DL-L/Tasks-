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

// Route::post('user/validate/', [LoginController::class, 'validate_num']);
// Route::post('user/auth/', [LoginController::class,'auth']);
Route::get('/', function(Request $request)
    {
      return 'Unauthenticated';
    })->name('login');

// Route::get('/users/admins', 'App\Http\Controllers\UsersController@indexAdmins');



// Route::middleware(['RoleAdmin'])->group(function(){
  
//   Route::resource('/tasks', TasksController::class, ['only' => ['destroy']]);
// });
//Route::resource('/tasks', TasksController::class);
//Route::put('/tasks/{id}', 'App\Http\Controllers\TasksController@admin_update')->middleware('RoleAdmin');

Route::get('tasks/{task}', 'App\Http\Controllers\TasksController@show');

// Route::post('/tasks', 'App\Http\Controllers\TasksController@store' );

Route::put('/admin/tasks/{task}', 'App\Http\Controllers\TasksController@admin_update' )
        ->whereUuid('task')
        ->middleware('role.admin');

Route::put('/sub/tasks/{task}', 'App\Http\Controllers\TasksController@sub_update' )
        ->whereUuid('task')
        ->middleware('role.sub');

Route::delete('/tasks/{task}', 'App\Http\Controllers\TasksController@destroy')->middleware('role.admin');


Route::post('/tasks/comments/{task}', 'App\Http\Controllers\TasksController@store_comment')->middleware('role.sub');

Route::put('/comments/{comment}', 'App\Http\Controllers\CommentsController@update' );

// Route::put('/tasks/{task}', 'App\Http\Controllers\TasksController@sub_update' )->whereUuid('task');

Route::get('user/logout', function()
{
  Auth::logout();
  return \Response::json(array("success" => true));
});
