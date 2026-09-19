<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Bay;
use App\Models\Employee;
use App\Models\JobCardTask;
use App\Models\User;
use App\Notifications\TaskAssignedNotification;
use App\Notifications\TaskCompletedNotification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MechanicCoordinatorTaskController extends Controller
{
    // Summary of workshop tasks by status.
    public function summary()
    {
        $summary = JobCardTask::query()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return ApiResponse::success([
            'pending' => (int) ($summary['pending'] ?? 0),
            'assigned' => (int) ($summary['assigned'] ?? 0),
            'in_progress' => (int) ($summary['in_progress'] ?? 0),
            'on_hold' => (int) ($summary['on_hold'] ?? 0),
            'completed' => (int) ($summary['completed'] ?? 0),
            'cancelled' => (int) ($summary['cancelled'] ?? 0),
        ], 'Workshop task summary fetched successfully.');
    }

    /**
     * List workshop tasks.
     */
    public function index(Request $request)
    {
        $tasks = JobCardTask::query()
            ->with([
                'jobCard:id,job_card_number,customer_id,vehicle_id,complaint',
                'jobCard.customer:id,customer_code,name,phone',
                'jobCard.vehicle:id,customer_id,registration_number,make,model,variant',
                'department:id,name',
                'bay:id,name,code,type',
                'assignedEmployee:id,user_id,employee_code,designation,department_id,status',
                'assignedEmployee.user:id,name',
                'parts:id,job_card_task_id,part_id,quantity,status',
                'parts.part:id,part_number,name,category,brand,unit',
            ])

            // Optional filters
            ->when(
                $request->filled('status'),
                function ($query) use ($request) {
                    $statuses = is_array($request->status)
                        ? $request->status
                        : explode(',', $request->status);

                    $query->whereIn('status', $statuses);
                }
            )

            ->when(
                $request->filled('department_id'),
                fn($query) => $query->where(
                    'department_id',
                    $request->department_id
                )
            )

            ->when(
                $request->filled('bay_id'),
                fn($query) => $query->where(
                    'bay_id',
                    $request->bay_id
                )
            )

            ->orderByRaw("
                CASE status
                    WHEN 'in_progress' THEN 1
                    WHEN 'on_hold' THEN 2
                    WHEN 'assigned' THEN 3
                    WHEN 'pending' THEN 4
                    WHEN 'completed' THEN 5
                    WHEN 'cancelled' THEN 6
                    ELSE 7
                END
            ")
            ->orderBy('id')
            ->paginate($request->integer('per_page', 20));

        return ApiResponse::success(
            $tasks,
            'Workshop tasks fetched successfully.'
        );
    }

    /**
     * Show one workshop task.
     */
    public function show(JobCardTask $task)
    {
        $task->load([
            'jobCard:id,job_card_number,customer_id,vehicle_id,complaint,customer_notes',
            'jobCard.customer:id,customer_code,name,phone',
            'jobCard.vehicle:id,customer_id,registration_number,make,model,variant,fuel_type,current_odometer',
            'department:id,name',
            'bay:id,name,code,type',
            'assignedEmployee:id,user_id,employee_code,designation,department_id,status',
            'assignedEmployee.user:id,name',
            'parts:id,job_card_task_id,part_id,quantity,unit_price,discount,total,status,notes',
            'parts.part:id,part_number,name,category,brand,unit',
        ]);

        return ApiResponse::success(
            $task,
            'Workshop task fetched successfully.'
        );
    }

    /**
     * Update task status.
     */
    public function updateStatus(
        Request $request,
        JobCardTask $task
    ) {
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
                'cancelled',
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

        $updateData = [
            'status' => $newStatus,
        ];

        /*
        |--------------------------------------------------------------------------
        | Automatic Time Tracking
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | Notify Coordinator + Advisor When Task Is Completed
        |--------------------------------------------------------------------------
        */

        if ($newStatus === 'completed') {

            $task->load([
                'jobCard:id,job_card_number,advisor_id',
                'jobCard.advisor:id,user_id',
                'jobCard.advisor.user:id,name',
            ]);

            $usersToNotify = collect();

            /*
            |--------------------------------------------------------------------------
            | Notify Advisor
            |--------------------------------------------------------------------------
            */

            if ($task->jobCard->advisor?->user) {
                $usersToNotify->push(
                    $task->jobCard->advisor->user
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Notify Mechanic Coordinators
            |--------------------------------------------------------------------------
            */

            $coordinators = User::role(
                'Mechanic Coordinator'
            )->get();

            foreach ($coordinators as $coordinator) {
                $usersToNotify->push($coordinator);
            }

            /*
            |--------------------------------------------------------------------------
            | Send Notifications
            |--------------------------------------------------------------------------
            */

            foreach ($usersToNotify->unique('id') as $user) {
                $user->notify(
                    new TaskCompletedNotification($task)
                );
            }
        }

        return ApiResponse::success(
            $task->fresh()->load([
                'jobCard:id,job_card_number,customer_id,vehicle_id,complaint',
                'jobCard.customer:id,customer_code,name,phone',
                'jobCard.vehicle:id,customer_id,registration_number,make,model,variant',
                'department:id,name',
                'bay:id,name,code,type',
                'assignedEmployee:id,user_id,employee_code,designation,department_id,status',
                'assignedEmployee.user:id,name',
                'parts:id,job_card_task_id,part_id,quantity,unit_price,discount,total,status,notes',
                'parts.part:id,part_number,name,category,brand,unit',
            ]),
            'Task status updated successfully.'
        );
    }

    /**
     * Assign / reassign task to mechanic and bay.
     */
    public function updateAssignment(
        Request $request,
        JobCardTask $task
    ) {
        $validated = $request->validate([
            'department_id' => [
                'required',
                'integer',
                'exists:departments,id',
            ],

            'bay_id' => [
                'nullable',
                'integer',
                'exists:bays,id',
            ],

            'assigned_to' => [
                'nullable',
                'integer',
                'exists:employees,id',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Validate Bay
        |--------------------------------------------------------------------------
        */

        if (! empty($validated['bay_id'])) {
            $bayBelongsToDepartment = Bay::query()
                ->whereKey($validated['bay_id'])
                ->where(
                    'department_id',
                    $validated['department_id']
                )
                ->where('is_active', true)
                ->exists();

            if (! $bayBelongsToDepartment) {
                return ApiResponse::error(
                    'Selected bay does not belong to the selected department or is inactive.',
                    422
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Validate Mechanic
        |--------------------------------------------------------------------------
        */

        if (! empty($validated['assigned_to'])) {
            $employee = Employee::query()
                ->whereKey($validated['assigned_to'])
                ->where('status', 'active')
                ->first();

            if (! $employee) {
                return ApiResponse::error(
                    'Selected employee does not exist or is not active.',
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

        /*
        |--------------------------------------------------------------------------
        | Update Assignment
        |--------------------------------------------------------------------------
        */

        $oldAssignedTo = $task->assigned_to;

        $task->update([
            'department_id' => $validated['department_id'],
            'bay_id' => $validated['bay_id'] ?? null,
            'assigned_to' => $validated['assigned_to'] ?? null,
        ]);

        $assignmentChanged = $oldAssignedTo != $task->assigned_to;

        /*
        |--------------------------------------------------------------------------
        | Notify Assigned Mechanic
        |--------------------------------------------------------------------------
        */

        if (
            $assignmentChanged &&
            ! empty($validated['assigned_to'])
        ) {
            $employee->load('user');

            if ($employee->user) {
                $task->load([
                    'jobCard:id,job_card_number',
                    'bay:id,name',
                ]);

                $employee->user->notify(
                    new TaskAssignedNotification($task)
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Return Updated Task
        |--------------------------------------------------------------------------
        */

        return ApiResponse::success(
            $task->fresh()->load([
                'jobCard:id,job_card_number,customer_id,vehicle_id,complaint',
                'jobCard.customer:id,customer_code,name,phone',
                'jobCard.vehicle:id,customer_id,registration_number,make,model,variant',
                'department:id,name',
                'bay:id,name,code,type',
                'assignedEmployee:id,user_id,employee_code,designation,department_id,status',
                'assignedEmployee.user:id,name',
            ]),
            'Task assignment updated successfully.'
        );
    }
}
