<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Task;
use App\Models\User;
use App\Jobs\SendEmailJob;


class TaskAssigned
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Task $task, public User $user)
    {
        // Dispatch the job when the event is fired
        SendEmailJob::dispatch($this->task);
    }


}
