<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Str;

class RoleAdminEdit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {            
            $connected_user_id= auth()->user()->id;
            // dd($request->segment(3));
            $task = Task::where('id', '=', $request->segment(3))->first();
            // dd($task);
            if ($task->admin($connected_user_id) == true) {
                return $next($request);
            }

            else{
                abort(403, 'forbidden');
                // return redirect()->back();
            }
    }
}
