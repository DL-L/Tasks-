<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Task;
use App\Models\Relation;

class TaskAddedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $relations = Relation::where('sub_id', '=', $event->user_id)
                            ->get();
        $array = array();
        foreach ($relations as $relation) {
            $relation_id = $relation->id;
            $array[] = $relation->id;
        }
        $tasks = Task::whereIn('relation_id', $array)->get();
        if (empty($tasks)) {
            
        }else {
            foreach ($tasks as $task) {
                $task->updateStatusToReceived();
            }
        }
        
    }
}
