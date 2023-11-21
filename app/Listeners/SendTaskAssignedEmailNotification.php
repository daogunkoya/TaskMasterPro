<?php

namespace App\Listeners;
use App\Mail\TaskAssignedNotification;
use App\Events\TaskAssigned;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class SendTaskAssignedEmailNotification
{

    public function handle(TaskAssigned $event): void
    {
        $task = $event->task;
        $user = $event->user;

        // Send email notification to the user
       // Mail::to($user->email)->send(new TaskAssignedNotification($task));

    }
}
