<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\JobCardTask;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Notifications\TaskCompletedNotification;

class MechanicTaskController extends Controller
{
    /**
     * Get the authenticated mechanic's tasks.
     */
    public function index(Request $request)
    {
        $employee = $this->getAuthenticatedEmployee($request);

        $tasks = JobCardTask::query()
            ->where('assigned_to', $employee->id)
            ->with([
                'jobCard:id,job_card_number,customer_id,vehicle_id,complaint',
                'jobCard.customer:id,customer_code,name,phone',
                'jobCard.vehicle:id,customer_id,registration_number,make,model,variant',
                'department:id,name',
                'bay:id,name,code,type',

                'parts:id,job_card_task_id,part_id,quantity,status',
                'parts.part:id,part_number,name,category,brand,unit',
            ])
            ->orderByRaw("
                CASE status
                    WHEN 'in_progress' THEN 1
                    WHEN 'assigned' THEN 2
                    WHEN 'on_hold' THEN 3
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
            'Mechanic tasks fetched successfully.'
        );
    }

    /**
     * Show one task belonging to the authenticated mechanic.
     */
    public function show(Request $request, JobCardTask $task)
    {
        $employee = $this->getAuthenticatedEmployee($request);

        $this->ensureTaskBelongsToMechanic($task, $employee);

        $task->load([
            'jobCard:id,job_card_number,customer_id,vehicle_id,complaint,customer_notes',
            'jobCard.customer:id,customer_code,name,phone',
            'jobCard.vehicle:id,customer_id,registration_number,make,model,variant,fuel_type,current_odometer',
            'department:id,name',
            'bay:id,name,code,type',
            'parts:id,job_card_task_id,part_id,quantity,unit_price,discount,total,status,notes',
            'parts.part:id,part_number,name,category,brand,unit',
        ]);

        return ApiResponse::success(
            $task,
            'Mechanic task fetched successfully.'
        );
    }

    /**
     * Get authenticated employee.
     */
    private function getAuthenticatedEmployee(Request $request): Employee
    {
        $user = $request->user();

        $employee = Employee::query()
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->first();

        abort_unless($employee, 403, 'Authenticated user is not an active employee.');

        return $employee;
    }

    /**
     * Ensure task belongs to authenticated mechanic.
     */
    private function ensureTaskBelongsToMechanic(
        JobCardTask $task,
        Employee $employee
    ): void {
        abort_unless(
            $task->assigned_to === $employee->id,
            403,
            'You are not assigned to this task.'
        );
    }

    public function updateStatus(
        Request $request,
        JobCardTask $task
    ) {
        $employee = $this->getAuthenticatedEmployee($request);

        $this->ensureTaskBelongsToMechanic($task, $employee);

        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
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

        /*
        |--------------------------------------------------------------------------
        | Prevent Completion With Pending Parts
        |--------------------------------------------------------------------------
        */

        if ($newStatus === 'completed') {
            $task->loadMissing([
                'parts:id,job_card_task_id,status',
            ]);

            $hasPendingParts = $task->parts
                ->contains(fn($part) => $part->status === 'pending');

            if ($hasPendingParts) {
                return ApiResponse::error(
                    'Task cannot be completed while parts are pending.',
                    422
                );
            }
        }

        $allowedTransitions = [
            'assigned' => [
                'in_progress',
                'cancelled',
            ],

            'in_progress' => [
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
        | Notify Admin + Coordinator When Mechanic Completes Task
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
            ]),
            'Task status updated successfully.'
        );
    }
}
