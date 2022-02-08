<?php
namespace App\Events;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ActionEvent implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $data = 'echo test';
  // public $sub_ids;
  // public $task;

  /**
    * Create a new event instance.
    *
    * @author Author
    *
    * @return void
    */
  public function __construct()
  {
    
    // $this->sub_id = $sub_id;
    // $this->task= $task;
  }

  /**
    * Get the channels the event should broadcast on.
    *
    * @author Author
    *
    * @return Channel|array
    */
  public function broadcastOn()
  {
      return new Channel('test');
  }

//   public function broadcastAs()
// {
//     return 'task.created';
// }

  /**
    * Get the data to broadcast.
    *
    * @author Author
    *
    * @return array
    */
    public function broadcastWith()
    {
        return [
            'title' => 'first notification'
        ];
    }
}