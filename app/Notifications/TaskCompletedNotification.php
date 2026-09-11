<?php

namespace App\Notifications;

use App\Models\JobCardTask;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskCompletedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public JobCardTask $task
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'job_card_task.completed',
            'title' => 'Task Completed',
            'message' => "Task \"{$this->task->title}\" has been completed.",
            'task_id' => $this->task->id,
            'job_card_id' => $this->task->job_card_id,
            'job_card_number' => $this->task->jobCard->job_card_number,
        ];
    }
}
