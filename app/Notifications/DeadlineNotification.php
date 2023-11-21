<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;

class DeadlineNotification extends Notification
{
    use Queueable;


    protected $project;

    public function __construct($project)
    {
        $this->project = $project;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $userEmail = $this->project->user->email;

        return (new MailMessage)
            ->subject('Project Deadline Reminder')
            ->line('The deadline for the project "'.$this->project->title.'" is approaching.')
            ->line('Please complete the tasks associated with this project.');
    }
}
