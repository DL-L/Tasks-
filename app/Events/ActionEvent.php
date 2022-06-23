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

  public $user_id ;

  /**
    * Create a new event instance.
    *
    * @author Author
    *
    * @return void
    */
  public function __construct($user_id)
  {
    $this->user_id = $user_id;
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
      return new PrivateChannel("otp.private.channel.{$this->user_id}");
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
    // public function broadcastWith()
    // {
    //     return [
    //         'title' => 'first notification'
    //     ];
    // }
}