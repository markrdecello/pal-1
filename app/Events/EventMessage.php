<?php

namespace App\Events;

use App\Events\Event;
use App\Chat;
use Illuminate\Queue\SerializesModels;
use Illuminate\Console\Command;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Redis;


class EventMessage extends Event implements ShouldBroadcast
{
    use SerializesModels;
    public $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Chat $data)
    {
        $this->data = array(
            'name' => $data->name,
            'sender' => $data->sender,
            'receiver' => $data->receiver,
            'message' => $data->message
        );

        $obj = json_encode($this->data);

        Redis::publish("index", $obj);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {

    }
}
