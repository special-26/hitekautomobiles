<?php

namespace App\Http\Controllers\Api\Admin;

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
                'vehicle:id,customer_id,registration_number,make,model',
                'advisor:id,employee_code,designation',
                'advisor.user:id,name',
                'bay:id,name,code',
            ])
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->priority, function ($query, $priority) {
                $query->where('priority', $priority);
            })
            ->latest()
            ->paginate(20);

        return response()->json($jobCards);
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

            'service_booking_id' => [
                'nullable',
                'integer',
                'exists:service_bookings,id',
            ],

            'advisor_id' => [
                'nullable',
                'integer',
                'exists:employees,id',
            ],

            'bay_id' => [
                'nullable',
                'integer',
                'exists:bays,id',
            ],

            'complaint' => [
                'nullable',
                'string',
            ],

            'work_description' => [
                'nullable',
                'string',
            ],

            'estimated_cost' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'estimated_completion_at' => [
                'nullable',
                'date',
            ],

            'priority' => [
                'nullable',
                'string',
                Rule::in([
                    'low',
                    'normal',
                    'high',
                    'urgent',
                ]),
            ],
        ]);

        $vehicleBelongsToCustomer = Vehicle::query()
            ->where('id', $validated['vehicle_id'])
            ->where('customer_id', $validated['customer_id'])
            ->exists();

        if (! $vehicleBelongsToCustomer) {
            return response()->json([
                'message' => 'The selected vehicle does not belong to the selected customer.',
            ], 422);
        }

        if (! empty($validated['advisor_id'])) {
            $advisorExists = Employee::query()
                ->where('id', $validated['advisor_id'])
                ->where('status', 'active')
                ->exists();

            if (! $advisorExists) {
                return response()->json([
                    'message' => 'The selected advisor is not active.',
                ], 422);
            }
        }

        if (! empty($validated['bay_id'])) {
            $bayExists = Bay::query()
                ->where('id', $validated['bay_id'])
                ->where('is_active', true)
                ->exists();

            if (! $bayExists) {
                return response()->json([
                    'message' => 'The selected bay is not active.',
                ], 422);
            }
        }

        $jobCard = DB::transaction(function () use ($validated) {

            $lastId = JobCard::query()
                ->lockForUpdate()
                ->max('id');

            $jobCardNumber = 'JC-' . str_pad(
                (string) (($lastId ?? 0) + 1),
                6,
                '0',
                STR_PAD_LEFT
            );

            return JobCard::create([
                ...$validated,
                'job_card_number' => $jobCardNumber,
                'status' => 'open',
                'priority' => $validated['priority'] ?? 'normal',
            ]);
        });

        $jobCard->load([
            'customer:id,customer_code,name,phone',
            'vehicle:id,customer_id,registration_number,make,model',
            'advisor:id,employee_code,designation',
            'advisor.user:id,name',
            'bay:id,name,code',
        ]);

        return response()->json([
            'message' => 'Job card created successfully.',
            'data' => $jobCard,
        ], 201);
    }

    public function show(JobCard $jobCard): JsonResponse
    {
        $jobCard->load([
            'customer:id,customer_code,name,phone,email',
            'vehicle:id,customer_id,registration_number,make,model,variant,fuel_type,current_odometer',
            'serviceBooking:id,service_date,slot_key,service_type,status',
            'advisor:id,employee_code,designation,phone',
            'advisor.user:id,name,email',
            'bay:id,name,code,type',
        ]);

        return response()->json([
            'data' => $jobCard,
        ]);
    }

    public function update(Request $request, JobCard $jobCard): JsonResponse
    {
        $validated = $request->validate([
            'customer_id' => [
                'sometimes',
                'required',
                'integer',
                'exists:customers,id',
            ],

            'vehicle_id' => [
                'sometimes',
                'required',
                'integer',
                'exists:vehicles,id',
            ],

            'service_booking_id' => [
                'nullable',
                'integer',
                'exists:service_bookings,id',
            ],

            'advisor_id' => [
                'nullable',
                'integer',
                'exists:employees,id',
            ],

            'bay_id' => [
                'nullable',
                'integer',
                'exists:bays,id',
            ],

            'complaint' => [
                'nullable',
                'string',
            ],

            'work_description' => [
                'nullable',
                'string',
            ],

            'estimated_cost' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'estimated_completion_at' => [
                'nullable',
                'date',
            ],

            'priority' => [
                'sometimes',
                'string',
                Rule::in([
                    'low',
                    'normal',
                    'high',
                    'urgent',
                ]),
            ],
        ]);

        $customerId = $validated['customer_id'] ?? $jobCard->customer_id;
        $vehicleId = $validated['vehicle_id'] ?? $jobCard->vehicle_id;

        $vehicleBelongsToCustomer = Vehicle::query()
            ->where('id', $vehicleId)
            ->where('customer_id', $customerId)
            ->exists();

        if (! $vehicleBelongsToCustomer) {
            return response()->json([
                'message' => 'The selected vehicle does not belong to the selected customer.',
            ], 422);
        }

        if (array_key_exists('advisor_id', $validated) && $validated['advisor_id']) {
            $advisorExists = Employee::query()
                ->where('id', $validated['advisor_id'])
                ->where('status', 'active')
                ->exists();

            if (! $advisorExists) {
                return response()->json([
                    'message' => 'The selected advisor is not active.',
                ], 422);
            }
        }

        if (array_key_exists('bay_id', $validated) && $validated['bay_id']) {
            $bayExists = Bay::query()
                ->where('id', $validated['bay_id'])
                ->where('is_active', true)
                ->exists();

            if (! $bayExists) {
                return response()->json([
                    'message' => 'The selected bay is not active.',
                ], 422);
            }
        }

        $jobCard->update($validated);

        $jobCard->load([
            'customer:id,customer_code,name,phone',
            'vehicle:id,customer_id,registration_number,make,model',
            'advisor:id,employee_code,designation',
            'advisor.user:id,name',
            'bay:id,name,code',
        ]);

        return response()->json([
            'message' => 'Job card updated successfully.',
            'data' => $jobCard,
        ]);
    }

    public function updateStatus(
        Request $request,
        JobCard $jobCard
    ): JsonResponse {
        $validated = $request->validate([
            'status' => [
                'required',
                'string',
                Rule::in([
                    'open',
                    'in_progress',
                    'waiting_parts',
                    'completed',
                    'cancelled',
                    'delivered',
                ]),
            ],
        ]);

        $jobCard->update([
            'status' => $validated['status'],
        ]);

        return response()->json([
            'message' => 'Job card status updated successfully.',
            'data' => $jobCard->fresh(),
        ]);
    }
}
