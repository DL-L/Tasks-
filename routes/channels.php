<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel("task.private.channel.{userId}" , function ($user , $userId){
    return true;
    // (int) $user->id === (int) $userId;
});

Broadcast::channel("invitation.private.channel.{user_id}" , function ($user , $user_id){
    return true;
    // (int) $user->id === (int) $userId;
});

Broadcast::channel("otp.private.channel.{user_id}" , function ($user , $user_id){
    return true;
    // (int) $user->id === (int) $userId;
});
// Broadcast::channel('Task.Added.{taskId}', function ($user, $taskId) {
//     return $user->id === Task::findOrNew($taskId)->sub_user_id;
// });
