<?php

namespace App\Livewire\JobCards;

use App\Models\JobCard;
use App\Models\JobCardPart;
use App\Models\JobCardTask;
use App\Models\ServiceTask;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Tasks extends Component
{
    public $jobCard;

    public $tasks = [];

    public bool $showAddTaskModal = false;
    public string $taskSearch = '';
    public array $serviceTaskResults = [];

    public function mount($jobCard)
    {
        $this->loadJobCard($jobCard);
    }

    public function updatedTaskSearch(): void
    {
        if (strlen(trim($this->taskSearch)) < 2) {
            $this->serviceTaskResults = [];

            return;
        }

        $search = '%' . trim($this->taskSearch) . '%';

        $this->serviceTaskResults = ServiceTask::query()
            ->where('is_active', true)
            ->with([
                'category:id,name',
                'department:id,name',
            ])
            ->withCount('taskParts')
            ->where(function ($query) use ($search) {
                $query->where('name', 'ilike', $search)
                    ->orWhere('slug', 'ilike', $search);
            })
            ->orderBy('name')
            ->limit(10)
            ->get()
            ->toArray();
    }

    public function addPredefinedTask(int $serviceTaskId): void
    {
        DB::transaction(function () use ($serviceTaskId) {

            $serviceTask = ServiceTask::query()
                ->with([
                    'taskParts.part',
                ])
                ->where('is_active', true)
                ->findOrFail($serviceTaskId);

            $jobCardTask = JobCardTask::create([
                'job_card_id' => $this->jobCard['id'],
                'service_task_id' => $serviceTask->id,
                'department_id' => $serviceTask->department_id,
                'title' => $serviceTask->name,
                'description' => $serviceTask->description,
                'status' => 'pending',
                'estimated_minutes' => $serviceTask->estimated_minutes,
            ]);

            foreach ($serviceTask->taskParts as $serviceTaskPart) {

                $part = $serviceTaskPart->part;

                if (! $part || ! $part->is_active) {
                    continue;
                }

                $quantity = (float) $serviceTaskPart->default_quantity;
                $unitPrice = (float) $part->selling_price;
                $discount = 0;

                $subtotal = $quantity * $unitPrice;
                $total = $subtotal - $discount;

                JobCardPart::create([
                    'job_card_id' => $this->jobCard['id'],
                    'part_id' => $part->id,
                    'job_card_task_id' => $jobCardTask->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'discount' => $discount,
                    'total' => $total,
                    'status' => 'pending',
                ]);
            }
        });

        $this->loadTasks($this->jobCard['id']);

        $this->taskSearch = '';
        $this->serviceTaskResults = [];
        $this->showAddTaskModal = false;

        session()->flash(
            'success',
            'Task added successfully.'
        );
    }

    protected function loadJobCard($jobCardId)
    {
        $jobCard = JobCard::query()
            ->with([
                'customer',
                'vehicle',
            ])
            ->findOrFail($jobCardId);

        $this->jobCard = [
            'id' => $jobCard->id,
            'job_card_number' => $jobCard->job_card_number,
            'vehicle_no' => $jobCard->vehicle->registration_number,
            'vehicle' => trim(
                $jobCard->vehicle->make . ' ' .
                    $jobCard->vehicle->model
            ),
            'customer' => $jobCard->customer->name,
        ];

        $this->loadTasks($jobCard->id);
    }

    protected function loadTasks($jobCardId)
    {
        $this->tasks = $this->getTaskQuery($jobCardId)
            ->get()
            ->map(function ($task) {
                return [
                    'id' => $task->id,
                    'task' => $task->title,
                    'description' => $task->description,
                    'category' => $task->serviceTask?->category?->name ?? 'Service',
                    'priority' => null,
                    'status' => $this->formatStatus($task->status),
                    'mechanic' => $task->assignedEmployee?->user?->name ?? 'Unassigned',
                    'bay' => $task->bay?->name ?? 'Unassigned',
                    'estimated_time' => $task->estimated_minutes
                        ? $this->formatMinutes($task->estimated_minutes)
                        : null,
                    'started_at' => $task->started_at
                        ? $task->started_at->format('h:i A')
                        : null,
                    'completed_at' => $task->completed_at
                        ? $task->completed_at->format('h:i A')
                        : null,
                    'parts_pending' => false,

                    'parts' => $task->parts->map(function ($jobCardPart) {
                        return [
                            'id' => $jobCardPart->id,
                            'name' => $jobCardPart->part?->name ?? 'Unknown Part',
                            'part_number' => $jobCardPart->part?->part_number,
                            'brand' => $jobCardPart->part?->brand,
                            'quantity' => $jobCardPart->quantity,
                            'unit_price' => $jobCardPart->unit_price,
                            'total' => $jobCardPart->total,
                            'status' => ucfirst($jobCardPart->status),
                        ];
                    })->toArray(),
                ];
            })
            ->toArray();
    }

    protected function getTaskQuery($jobCardId)
    {
        return JobCardTask::query()
            ->where('job_card_id', $jobCardId)
            ->with([
                'serviceTask.category',
                'assignedEmployee.user',
                'bay',
                'parts.part',
            ])
            ->orderBy('id');
    }

    protected function formatStatus(?string $status): string
    {
        return match ($status) {
            'in_progress' => 'In Progress',
            'pending_parts' => 'Pending Parts',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            default => 'Pending',
        };
    }

    protected function formatMinutes(?int $minutes): ?string
    {
        if (!$minutes) {
            return null;
        }

        if ($minutes < 60) {
            return $minutes . ' min';
        }

        $hours = intdiv($minutes, 60);
        $remainingMinutes = $minutes % 60;

        if ($remainingMinutes === 0) {
            return $hours . ' hr' . ($hours > 1 ? 's' : '');
        }

        return $hours . ' hr ' . $remainingMinutes . ' min';
    }

    public function render()
    {
        return view('livewire.job-cards.tasks')
            ->layout('components.layouts.management', [
                'title' => 'Job Card #' . $this->jobCard['job_card_number'] . ' - Tasks',
            ]);
    }
}
