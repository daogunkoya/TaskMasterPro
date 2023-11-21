<?php

namespace App\Console\Commands;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DeadlineNotification; // Assuming you have a custom notification class

class SendDeadlineNotifications extends Command
{
    protected $signature = 'notifications:send_deadline';

    protected $description = 'Send notifications to users 10 minutes before project deadlines';

    public function handle()
    {
        $deadlineThreshold = Carbon::now()->addMinutes(10);

        $projects = Project::with('user')
            ->where('deadline', '<=', $deadlineThreshold)
            ->where('deadline', '>=', Carbon::now())
            ->with('user') // Eager load users
            ->get();

        foreach ($projects as $project) {
            Log::info('Notiication loop.');
            if ($project->user) {
                Log::info('Notiication individual sent');
                Notification::send($project->user, new DeadlineNotification($project));

                $this->info('Notification sent for Project ID: ' . $project->id);
            }
        }
    }
}

