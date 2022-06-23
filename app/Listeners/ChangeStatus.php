<?php

namespace App\Listeners;

use App\Events\TaskEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

class ChangeStatus
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
     * @param  \App\Events\TaskEvent  $event
     * @return void
     */
    public function handle(TaskEvent $event)
    {
        // if (str_contains($event->message,'new Task')) {
        //     $event->task->updateStatusToReceived();
        // }
    }
}
