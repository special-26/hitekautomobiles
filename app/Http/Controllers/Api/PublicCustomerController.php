<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicCustomerController extends Controller
{
    public function show(string $token): JsonResponse
    {
        $customer = Customer::query()
            ->where('public_token', $token)
            ->where('is_active', true)
            ->with([
                'vehicles:id,customer_id,registration_number,make,model,variant,fuel_type,current_odometer',

                'jobCards:id,job_card_number,customer_id,vehicle_id,department_id,bay_id,complaint,estimated_cost,estimated_completion_at,status,created_at',

                'jobCards.vehicle:id,customer_id,registration_number,make,model,variant',

                'jobCards.department:id,name',

                'jobCards.bay:id,name,code,type',

                'jobCards.tasks:id,job_card_id,department_id,bay_id,title,description,status,estimated_minutes,actual_minutes,started_at,completed_at',

                'jobCards.tasks.department:id,name',

                'jobCards.tasks.bay:id,name,code,type',

                'jobCards.parts:id,job_card_id,job_card_task_id,part_id,quantity,status',

                'jobCards.parts.part:id,part_number,name,unit',
            ])
            ->first();

        if (! $customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer tracking link is invalid or inactive.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $customer,
        ]);
    }
}
