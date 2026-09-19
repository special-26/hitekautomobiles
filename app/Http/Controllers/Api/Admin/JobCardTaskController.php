<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\JobCard;
use App\Models\JobCardTask;
use App\Models\ServiceTask;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Notifications\JobCardTaskCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JobCardTaskController extends Controller
{
    /** * List tasks for a job card */
    public function index(JobCard $jobCard)
    {
        abort_unless(
            $this->hasPermission('job-cards-tasks.view'),
            403,
            'You do not have permission to view job card tasks.'
        );

        $tasks = $jobCard->tasks()
            ->with([
                'department:id,name',
                'bay:id,name,code,type',
                'assignedEmployee:id,user_id,employee_code,designation,department_id,status',
                'assignedEmployee.user:id,name',
                'assignedEmployee.user.roles:uuid,name',
            ])
            ->orderBy('id')
            ->get();

        return ApiResponse::success(
            $tasks,
            'Job card tasks fetched successfully.'
        );
    }

    /** * Create task */
    public function store(Request $request, JobCard $jobCard)
    {
        abort_unless(
            $this->hasPermission('job-cards-tasks.create'),
            403,
            'You do not have permission to create job card tasks.'
        );

        $validated = $request->validate([
            'department_id' => [
                'required',
                'integer',
                'exists:departments,id',
            ],
            'bay_id' => ['nullable', 'integer', 'exists:bays,id',],
            'assigned_to' => ['nullable', 'integer', 'exists:employees,id',],
            'title' => ['required', 'string', 'max:150',],
            'description' => ['nullable', 'string',],
            'estimated_minutes' => ['nullable', 'integer', 'min:1',],
            'labour_cost' => ['nullable', 'numeric', 'min:0',],
            'notes' => ['nullable', 'string',],
            'service_task_id' => [
                'nullable',
                'integer',
                'exists:service_tasks,id',
            ],
        ]);

        if (! $this->hasPermission('job-cards-tasks.assign-mechanic')) {
            $validated['assigned_to'] = null;
        }

        if (! $this->hasPermission('job-cards-tasks.assign-bay')) {
            $validated['bay_id'] = null;
        }

        /* 
            |-------------------------------------------------------------------------- 
            | Validate Bay Belongs To Department |-------------------------------------------------------------------------- 
            */
        if (
            ! empty($validated['bay_id'])
        ) {
            $bayBelongsToDepartment =
                \App\Models\Bay::query()
                ->whereKey(
                    $validated['bay_id']
                )
                ->where(
                    'department_id',
                    $validated['department_id']
                )->exists();

            if (! $bayBelongsToDepartment) {
                return ApiResponse::error(
                    'Selected bay does not belong to the selected department.',
                    422
                );
            }
        }

        /* 
        |-------------------------------------------------------------------------- 
        | Validate Assigned Employee |-------------------------------------------------------------------------- 
        */
        if (
            ! empty($validated['assigned_to'])
        ) {
            $employee = Employee::query()
                ->with('user')
                ->whereKey(
                    $validated['assigned_to']
                )
                ->first();

            if (! $employee) {
                return ApiResponse::error(
                    'Selected employee does not exist.',
                    422
                );
            }

            if ($employee->status !== 'active') {
                return ApiResponse::error(
                    'Selected employee is not active.',
                    422
                );
            }

            if (
                $employee->department_id !==
                (int) $validated['department_id']
            ) {
                return ApiResponse::error(
                    'Selected employee does not belong to the selected department.',
                    422
                );
            }

            if (! $employee->user || ! $employee->user->hasRole('Mechanic')) {
                return ApiResponse::error(
                    'Selected employee must have the Mechanic role.',
                    422
                );
            }
        }

        $serviceTask = null;
        if (! empty($validated['service_task_id'])) {
            $serviceTask = ServiceTask::query()
                ->where('is_active', true)
                ->with([
                    'taskParts.part',
                ])
                ->find($validated['service_task_id']);

            if (! $serviceTask) {
                return ApiResponse::error(
                    'Selected service task does not exist or is inactive.',
                    422
                );
            }
        }

        $validated['status'] = 'pending';
        $task = DB::transaction(function () use (
            $jobCard,
            $validated,
            $serviceTask
        ) {
            // Create the job card task
            $task = $jobCard->tasks()->create($validated);

            // Copy suggested parts from the predefined service task
            if ($serviceTask) {
                foreach ($serviceTask->taskParts as $suggestedPart) {
                    $part = $suggestedPart->part;

                    if (! $part) {
                        continue;
                    }

                    $quantity = $suggestedPart->default_quantity;

                    $unitPrice = $part->cost_price ?? 0;

                    $total = $quantity * $unitPrice;

                    $task->parts()->create([
                        'job_card_id' => $jobCard->id,
                        'part_id' => $part->id,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'discount' => 0,
                        'total' => $total,
                        'status' => 'pending',
                    ]);
                }
            }

            return $task;
        });

        $task->load([
            'jobCard:id,job_card_number',
            'department:id,name',
            'bay:id,name,code,type',
            'assignedEmployee:id,user_id,employee_code,designation,department_id,status',
            'assignedEmployee.user:id,name',
            'serviceTask:id,name,slug',
            'parts.part:id,name,category,cost_price',
        ]);

        $usersToNotify = User::role([
            'Super Admin',
            'Admin',
            'Mechanic Coordinator',
        ])->get();

        foreach ($usersToNotify as $user) {
            $user->notify(
                new JobCardTaskCreatedNotification($task)
            );
        }

        return ApiResponse::success(
            $task,
            'Job card task created successfully.',
            201
        );
    }

    /** * Show task */
    public function show(
        JobCard $jobCard,
        JobCardTask $task
    ) {
        $this->ensureTaskBelongsToJobCard(
            $jobCard,
            $task
        );
        $task->load([
            'jobCard:id,job_card_number',
            'department:id,name',
            'bay:id,name,code,type',
            'assignedEmployee:id,user_id,employee_code,designation,department_id,status',
            'assignedEmployee.user:id,name',
        ]);

        return ApiResponse::success(
            $task,
            'Job card task fetched successfully.'
        );
    }

    /** * Update task */
    public function update(Request $request, JobCard $jobCard, JobCardTask $task)
    {
        $this->ensureTaskBelongsToJobCard(
            $jobCard,
            $task
        );

        abort_unless(
            $this->hasPermission('job-cards-tasks.update'),
            403,
            'You do not have permission to update job card tasks.'
        );

        $rules = [
            'title' => ['sometimes', 'required', 'string', 'max:150'],
            'description' => ['sometimes', 'nullable', 'string'],
            'estimated_minutes' => ['sometimes', 'nullable', 'integer', 'min:1'],
            'labour_cost' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'notes' => ['sometimes', 'nullable', 'string'],
        ];
        if ($this->hasPermission('job-cards-tasks.assign-mechanic')) {
            $rules['assigned_to'] = [
                'sometimes',
                'nullable',
                'integer',
                'exists:employees,id',
            ];
        }

        if ($this->hasPermission('job-cards-tasks.assign-bay')) {
            $rules['bay_id'] = [
                'sometimes',
                'nullable',
                'integer',
                'exists:bays,id',
            ];
        }

        $validated = $request->validate($rules);

        /* 
        |-------------------------------------------------------------------------- 
        | Validate Bay |-------------------------------------------------------------------------- 
        */
        if (! empty($validated['bay_id'])) {
            $bayBelongsToDepartment = \App\Models\Bay::query()->whereKey($validated['bay_id'])->where('department_id', $validated['department_id'])->exists();
            if (! $bayBelongsToDepartment) {
                return ApiResponse::error('Selected bay does not belong to the selected department.', 422);
            }
        }

        /* 
        |-------------------------------------------------------------------------- 
        | Validate Employee |-------------------------------------------------------------------------- 
        */
        if (
            ! empty($validated['assigned_to'])
        ) {
            $employee = Employee::query()
                ->whereKey(
                    $validated['assigned_to']
                )
                ->first();

            if (! $employee) {
                return ApiResponse::error(
                    'Selected employee does not exist.',
                    422
                );
            }
            if ($employee->status !== 'active') {
                return ApiResponse::error(
                    'Selected employee is not active.',
                    422
                );
            }
            if (
                $employee->department_id !== (int)
                $validated['department_id']
            ) {
                return ApiResponse::error(
                    'Selected employee does not belong to the selected department.',
                    422
                );
            }
        }

        $task->update($validated);

        return ApiResponse::success(
            $task->fresh()->load([
                'department:id,name',
                'bay:id,name,code,type',
                'assignedEmployee:id,user_id,employee_code,designation,department_id,status',
                'assignedEmployee.user:id,name',
            ]),
            'Job card task updated successfully.'
        );
    }

    /** * Update task status */
    public function updateStatus(
        Request $request,
        JobCard $jobCard,
        JobCardTask $task
    ) {
        $this->ensureTaskBelongsToJobCard(
            $jobCard,
            $task
        );

        abort_unless(
            $this->hasPermission('job-cards-tasks.status.update'),
            403,
            'You do not have permission to update task status.'
        );

        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'pending',
                    'assigned',
                    'in_progress',
                    'on_hold',
                    'completed',
                    'cancelled',
                ]),
            ],
        ]);

        $currentStatus = $task->status;
        $newStatus = $validated['status'];

        $allowedTransitions = [
            'pending' => [
                'assigned',
                'cancelled',
            ],
            'assigned' => [
                'pending',
                'in_progress',
                'cancelled',
            ],
            'in_progress' => [
                'assigned',
                'on_hold',
                'completed',
            ],
            'on_hold' => [
                'in_progress',
                'completed',
                'cancelled'
            ],
            'completed' => [],
            'cancelled' => [],
        ];

        if (
            $newStatus !== $currentStatus &&
            ! in_array(
                $newStatus,
                $allowedTransitions[$currentStatus] ?? [],
                true
            )
        ) {
            return ApiResponse::error(
                "Task cannot be changed from {$currentStatus} to {$newStatus}.",
                422
            );
        }

        /* 
        |-------------------------------------------------------------------------- 
        | Automatic Time Tracking |-------------------------------------------------------------------------- 
        */
        $updateData = [
            'status' => $newStatus,
        ];
        if (
            $newStatus === 'in_progress' &&
            ! $task->started_at
        ) {
            $updateData['started_at'] = now();
        }
        if (
            $newStatus === 'completed' &&
            ! $task->completed_at
        ) {
            $updateData['completed_at'] = now();
            if (
                $task->started_at &&
                ! $task->actual_minutes
            ) {
                $updateData['actual_minutes'] =
                    (int) $task->started_at->diffInMinutes(now());
            }
        }
        $task->update($updateData);

        return ApiResponse::success(
            $task->fresh()->load([
                'department:id,name',
                'bay:id,name,code,type',
                'assignedEmployee:id,user_id,employee_code,designation,department_id,status',
                'assignedEmployee.user:id,name',
            ]),
            'Task status updated successfully.'
        );
    }

    /**
     * Check whether the authenticated user has a permission.
     */
    private function hasPermission(string $permission): bool
    {
        return auth()->user()?->can($permission) ?? false;
    }

    /** * Make sure the task belongs to the supplied job card. */
    private function ensureTaskBelongsToJobCard(
        JobCard $jobCard,
        JobCardTask $task
    ): void {
        abort_unless(
            $task->job_card_id === $jobCard->id,
            404
        );
    }
}
