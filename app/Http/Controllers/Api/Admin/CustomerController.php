<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * List customers
     */
    public function index()
    {
        $customers = Customer::query()
            ->withCount('vehicles')
            ->orderBy('name')
            ->get();

        return ApiResponse::success(
            $customers,
            'Customers fetched successfully.'
        );
    }

    /**
     * Create customer
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:150',
            ],

            'phone' => [
                'required',
                'string',
                'max:30',
            ],

            'email' => [
                'nullable',
                'email',
                'max:150',
            ],

            'address' => [
                'nullable',
                'string',
            ],

            'city' => [
                'nullable',
                'string',
                'max:100',
            ],

            'state' => [
                'nullable',
                'string',
                'max:100',
            ],

            'pincode' => [
                'nullable',
                'string',
                'max:20',
            ],

            'date_of_birth' => [
                'nullable',
                'date',
            ],
        ]);

        $customer = DB::transaction(function () use ($validated) {

            $lastCustomer = Customer::query()
                ->orderByDesc('id')
                ->lockForUpdate()
                ->first();

            $nextNumber = $lastCustomer
                ? $lastCustomer->id + 1
                : 1;

            $validated['customer_code'] =
                'CUS-' . str_pad(
                    $nextNumber,
                    6,
                    '0',
                    STR_PAD_LEFT
                );

            $validated['is_active'] = true;

            return Customer::create($validated);
        });

        return ApiResponse::success(
            $customer,
            'Customer created successfully.',
            201
        );
    }

    /**
     * Show customer
     */
    public function show(Customer $customer)
    {
        $customer->load('vehicles');

        return ApiResponse::success(
            $customer,
            'Customer fetched successfully.'
        );
    }

    /**
     * Update customer
     */
    public function update(
        Request $request,
        Customer $customer
    ) {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:150',
            ],

            'phone' => [
                'required',
                'string',
                'max:30',
            ],

            'email' => [
                'nullable',
                'email',
                'max:150',
            ],

            'address' => [
                'nullable',
                'string',
            ],

            'city' => [
                'nullable',
                'string',
                'max:100',
            ],

            'state' => [
                'nullable',
                'string',
                'max:100',
            ],

            'pincode' => [
                'nullable',
                'string',
                'max:20',
            ],

            'date_of_birth' => [
                'nullable',
                'date',
            ],
        ]);

        $customer->update($validated);

        return ApiResponse::success(
            $customer->fresh()->load('vehicles'),
            'Customer updated successfully.'
        );
    }

    /**
     * Activate / deactivate customer
     */
    public function updateStatus(
        Request $request,
        Customer $customer
    ) {
        $validated = $request->validate([
            'is_active' => [
                'required',
                'boolean',
            ],
        ]);

        $customer->update([
            'is_active' => $validated['is_active'],
        ]);

        return ApiResponse::success(
            $customer->fresh(),
            'Customer status updated successfully.'
        );
    }
}
