<?php

namespace App\Notifications;

use App\Models\JobCardTask;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobCardTaskCreatedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public JobCardTask $task
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'job_card_task.created',
            'title' => 'New Task Added',
            'message' => "Task \"{$this->task->title}\" has been added to Job Card {$this->task->jobCard->job_card_number}.",
            'task_id' => $this->task->id,
            'job_card_id' => $this->task->job_card_id,
            'job_card_number' => $this->task->jobCard->job_card_number,
        ];
    }
}
