<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\JobCard;
use App\Models\JobCardTask;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JobCardTaskController extends Controller
{
    /** * List tasks for a job card */
    public function index(JobCard $jobCard)
    {
        $tasks = $jobCard->tasks()
            ->with([
                'department:id,name',
                'bay:id,name,code,type',
                'assignedEmployee:id,user_id,employee_code,designation,department_id,status',
                'assignedEmployee.user:id,name',
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
        ]);

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
        }

        $validated['status'] = 'pending';

        $task = $jobCard->tasks()->create(
            $validated
        );

        $task->load([
            'department:id,name',
            'bay:id,name,code,type',
            'assignedEmployee:id,user_id,employee_code,designation,department_id,status',
            'assignedEmployee.user:id,name',
        ]);

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

        $validated = $request->validate([
            'department_id' => ['required', 'integer', 'exists:departments,id',],
            'bay_id' => ['nullable', 'integer', 'exists:bays,id',],
            'assigned_to' => ['nullable', 'integer', 'exists:employees,id',],
            'title' => ['required', 'string', 'max:150',],
            'description' => ['nullable', 'string',],
            'estimated_minutes' => ['nullable', 'integer', 'min:1',],
            'actual_minutes' => ['nullable', 'integer', 'min:0',],
            'labour_cost' => ['nullable', 'numeric', 'min:0',],
            'started_at' => ['nullable', 'date',],
            'completed_at' => ['nullable', 'date',],
            'notes' => ['nullable', 'string',],
        ]);

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
