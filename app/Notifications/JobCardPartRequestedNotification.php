<?php

namespace App\Notifications;

use App\Models\JobCardPart;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobCardPartRequestedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public JobCardPart $jobCardPart
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'job_card_part.requested',
            'title' => 'New Part Request',
            'message' => "Part \"{$this->jobCardPart->part->name}\" has been requested for Job Card {$this->jobCardPart->jobCard->job_card_number}.",
            'job_card_part_id' => $this->jobCardPart->id,
            'job_card_id' => $this->jobCardPart->job_card_id,
            'job_card_number' => $this->jobCardPart->jobCard->job_card_number,
            'task_id' => $this->jobCardPart->job_card_task_id,
            'part_id' => $this->jobCardPart->part_id,
            'part_name' => $this->jobCardPart->part->name,
            'quantity' => $this->jobCardPart->quantity,
        ];
    }
}
