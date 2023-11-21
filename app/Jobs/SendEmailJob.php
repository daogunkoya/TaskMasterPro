<?php

namespace App\Jobs;

use App\Mail\TaskAssignedNotification;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $task;

    public $tries = 3; // Number of times to retry the job

    public $retryAfter = 60; // Time (in seconds) before retrying the job

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function handle()
    {


        // Logic to send the email
        try {
            Mail::to($this->task->user->email)
                ->send(new TaskAssignedNotification($this->task));

            \Log::info('Email sent for Task ID: ' . $this->task->id);
        } catch (\Exception $e) {
            \Log::error('Failed to send email for Task ID: ' . $this->task->id);
            throw $e; // Rethrow the exception to trigger retry
        }
    }
}

