<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Bay;
use App\Models\Employee;
use App\Models\JobCard;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class JobCardController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $jobCards = JobCard::query()
            ->with([
                'customer:id,customer_code,name,phone',
                'vehicle:id,customer_id,registration_number,make,model,variant',
                'department:id,name',
                'bay:id,name,code',
                'advisor:id,user_id',
            ])
            ->orderByDesc('id')
            ->get();
        return ApiResponse::success(
            $jobCards,
            'Job cards fetched successfully.'
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'customer_id' => [
                'required',
                'integer',
                'exists:customers,id',
            ],

            'vehicle_id' => [
                'required',
                'integer',
                'exists:vehicles,id',
            ],
            'department_id' => ['required', 'integer', 'exists:departments,id',],
            'bay_id' => ['nullable', 'integer', 'exists:bays,id',],
            'advisor_id' => ['nullable', 'integer', 'exists:employees,id',],
            'complaint' => ['required', 'string',],
            'customer_notes' => ['nullable', 'string',],
            'estimated_cost' => ['nullable', 'numeric', 'min:0',],
            'estimated_completion_at' => ['nullable', 'date',],
        ]);

        /* 
        |-------------------------------------------------------------------------- 
        | Validate Vehicle Belongs To Customer |-------------------------------------------------------------------------- 
        */
        $vehicleBelongsToCustomer = DB::table('vehicles')
            ->where('id', $validated['vehicle_id'])
            ->where('customer_id', $validated['customer_id'])
            ->exists();

        if (! $vehicleBelongsToCustomer) {
            return ApiResponse::error(
                'The selected vehicle does not belong to the selected customer.',
                422
            );
        }

        /* 
        |-------------------------------------------------------------------------- 
        | Validate Bay Belongs To Department |-------------------------------------------------------------------------- 
        */
        if (! empty($validated['bay_id'])) {
            $bayBelongsToDepartment = DB::table('bays')
                ->where('id', $validated['bay_id'])
                ->where(
                    'department_id',
                    $validated['department_id']
                )
                ->exists();

            if (! $bayBelongsToDepartment) {
                return ApiResponse::error(
                    'The selected bay does not belong to the selected department.',
                    422
                );
            }
        }

        /* 
        |-------------------------------------------------------------------------- 
        | Create Job Card 
        |-------------------------------------------------------------------------- 
        */
        $jobCard = DB::transaction(function () use ($validated) {
            $lastJobCard = JobCard::query()
                ->orderByDesc('id')
                ->lockForUpdate()
                ->first();

            $nextNumber = $lastJobCard
                ? $lastJobCard->id + 1
                : 1;

            $validated['job_card_number'] =
                'JC-' . str_pad(
                    $nextNumber,
                    6,
                    '0',
                    STR_PAD_LEFT
                );

            $validated['status'] = 'pending';
            $validated['is_active'] = true;

            return JobCard::create($validated);
        });

        return ApiResponse::success(
            $jobCard->load([
                'customer:id,customer_code,name,phone',
                'vehicle:id,customer_id,registration_number,make,model,variant',
                'department:id,name',
                'bay:id,name,code',
                'advisor:id,user_id',
            ]),
            'Job card created successfully.',
            201
        );
    }

    /** * Show job card */
    public function show(JobCard $jobCard): JsonResponse
    {
        $jobCard->load([
            'customer',
            'vehicle',
            'department',
            'bay',
            'advisor:id,user_id',
        ]);

        return ApiResponse::success(
            $jobCard,
            'Job card fetched successfully.'
        );
    }

    /** * Update job card */
    public function update(Request $request, JobCard $jobCard): JsonResponse
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'integer', 'exists:customers,id',],

            'vehicle_id' => ['required', 'integer', 'exists:vehicles,id',],

            'department_id' => ['required', 'integer', 'exists:departments,id',],

            'bay_id' => ['nullable', 'integer', 'exists:bays,id',],

            'advisor_id' => ['nullable', 'integer', 'exists:employees,id',],

            'complaint' => ['required', 'string',],

            'customer_notes' => ['nullable', 'string',],

            'estimated_cost' => ['nullable', 'numeric', 'min:0',],

            'estimated_completion_at' => ['nullable', 'date',],
        ]);

        /* 
        |-------------------------------------------------------------------------- 
        | Validate Vehicle Belongs To Customer |-------------------------------------------------------------------------- 
        */
        $vehicleBelongsToCustomer = DB::table('vehicles')
            ->where('id', $validated['vehicle_id'])
            ->where('customer_id', $validated['customer_id'])
            ->exists();

        if (! $vehicleBelongsToCustomer) {
            return ApiResponse::error(
                'The selected vehicle does not belong to the selected customer.',
                422
            );
        }

        /* 
        |-------------------------------------------------------------------------- 
        | Validate Bay Belongs To Department |-------------------------------------------------------------------------- 
        */
        if (! empty($validated['bay_id'])) {
            $bayBelongsToDepartment = DB::table('bays')
                ->where('id', $validated['bay_id'])
                ->where(
                    'department_id',
                    $validated['department_id']
                )
                ->exists();

            if (! $bayBelongsToDepartment) {
                return ApiResponse::error(
                    'The selected bay does not belong to the selected department.',
                    422
                );
            }
        }

        $jobCard->update($validated);

        return ApiResponse::success(
            $jobCard->fresh()->load([
                'customer:id,customer_code,name,phone',
                'vehicle:id,customer_id,registration_number,make,model,variant',
                'department:id,name',
                'bay:id,name,code',
                'advisor:id,user_id',
            ]),
            'Job card updated successfully.'
        );
    }

    /** * Activate / deactivate job card */
    public function updateStatus(
        Request $request,
        JobCard $jobCard
    ): JsonResponse {
        $validated = $request->validate([
            'is_active' => [
                'required',
                'boolean',
            ],
        ]);

        $jobCard->update([
            'is_active' => $validated['is_active'],
        ]);

        return ApiResponse::success(
            $jobCard->fresh(),
            'Job card status updated successfully.'
        );
    }

    /** * Update workflow status */

    public function updateWorkflowStatus(
        Request $request,
        JobCard $jobCard
    ) {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'pending',
                    'confirmed',
                    'in_progress',
                    'on_hold',
                    'completed',
                    'cancelled',
                ]),
            ],
        ]);

        $newStatus = $validated['status'];
        $currentStatus = $jobCard->status;

        $allowedTransitions = [
            'pending' => [
                'confirmed',
                'cancelled',
            ],

            'confirmed' => [
                'pending',
                'in_progress',
                'cancelled',
            ],

            'in_progress' => [
                'confirmed',
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
                "Job card cannot be changed from {$currentStatus} to {$newStatus}.",
                422
            );
        }

        $jobCard->update([
            'status' => $newStatus,
        ]);

        return ApiResponse::success(
            $jobCard->fresh(),
            'Job card workflow status updated successfully.'
        );
    }
}
