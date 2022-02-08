<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Relation;

class checkTaskStatus
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
        $relation_id = Relation::where('sub_id', '=', $connected_user_id)
                            ->get();
        $array = array();
        foreach ($relation_id as $rel_id) {
            $relation_id = $rel_id->id;
            $array[] = $rel_id->id;
        }
        $tasks = Task::whereIn('relation_id', $array)->get();
        foreach ($tasks as $task) {
            $task->updateStatusToReceived($task);
        }
        return $next($request);
        
    }
}
