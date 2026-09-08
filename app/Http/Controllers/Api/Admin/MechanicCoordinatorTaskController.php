<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Bay;
use App\Models\Employee;
use App\Models\JobCardTask;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MechanicCoordinatorTaskController extends Controller
{
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
            ])

            // Optional filters
            ->when(
                $request->filled('status'),
                fn($query) => $query->where(
                    'status',
                    $request->status
                )
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
            ->get();

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

        $task->update([
            'department_id' => $validated['department_id'],
            'bay_id' => $validated['bay_id'] ?? null,
            'assigned_to' => $validated['assigned_to'] ?? null,
        ]);

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
