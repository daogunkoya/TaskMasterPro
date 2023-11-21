<?php

namespace App\Observers;

use App\Events\TaskAssigned;
use App\Models\Task;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class TaskObserver
{


    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        // Check if the user_id attribute is being changed
        if ($task->isDirty('user_id')) {
            // Get the user associated with the updated user_id
            $user = $task->user; // Assuming a relationship exists
            // Dispatch TaskAssigned event when user_id changes
            Event::dispatch(new TaskAssigned($task, $user));
        }
    }


}
