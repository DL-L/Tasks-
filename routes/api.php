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
    Route::get('/users', 'App\Http\Controllers\UsersController@index');
    Route::get('/users/admins', 'App\Http\Controllers\UsersController@indexAdmins');
    Route::get('/users/subs', 'App\Http\Controllers\UsersController@indexSubs');
    Route::get('/users/unrelated', 'App\Http\Controllers\UsersController@indexInrelatedUsers');
    Route::get('/user/{user}', 'App\Http\Controllers\UsersController@show');
    //tasks
    Route::get('/users/admins/tasks', 'App\Http\Controllers\TasksController@indexAdmin');
    Route::get('/users/subs/tasks', 'App\Http\Controllers\TasksController@indexSub');
    Route::get('/users/tasks', 'App\Http\Controllers\TasksController@index');
    Route::get('/tasks/admin', 'App\Http\Controllers\TasksController@getTasksAdmin');
    Route::get('/tasks/sub', 'App\Http\Controllers\TasksController@getTasksSub');
    Route::post('/tasks', 'App\Http\Controllers\TasksController@store' );
    Route::delete('admin/tasks/{id}', 'App\Http\Controllers\TasksController@destroy')->middleware('role.admin');
    Route::put('/sub/tasks/{task}', 'App\Http\Controllers\TasksController@sub_update' )
        ->whereUuid('task')
        ->middleware('role.sub');
    Route::put('/admin/tasks/{task}', 'App\Http\Controllers\TasksController@admin_update' )
        ->middleware('role.admin');
    Route::get('tasks/{task}', 'App\Http\Controllers\TasksController@show');
    //status
    Route::get('/statuses', 'App\Http\Controllers\StatusesController@index');
    //History
    Route::get('/histories', 'App\Http\Controllers\HistoriesController@index');
    //Invitation
    Route::post('/invitation', 'App\Http\Controllers\InvitationsController@store' );
    Route::get('/myinvitations', 'App\Http\Controllers\InvitationsController@index_my_invitations');
    Route::get('/newinvitations', 'App\Http\Controllers\InvitationsController@index_new_invitations');
    Route::put('/newinvitations/{invitation}', 'App\Http\Controllers\InvitationsController@update_accept_inv');
    Route::delete('invitations/{id}', 'App\Http\Controllers\InvitationsController@destroy');
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
