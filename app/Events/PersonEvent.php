<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use App\Models\Task;

class PersonEvent
{
    // use Dispatchable, InteractsWithSockets, SerializesModels;

    private readonly Task $task;
    /**
     * Create a new event instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function getTask() {
        return $this->task;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }

}