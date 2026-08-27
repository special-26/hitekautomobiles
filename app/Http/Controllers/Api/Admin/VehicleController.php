<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    /**
     * List vehicles
     */
    public function index()
    {
        $vehicles = Vehicle::query()
            ->with('customer:id,customer_code,name,phone')
            ->orderBy('registration_number')
            ->get();

        return ApiResponse::success(
            $vehicles,
            'Vehicles fetched successfully.'
        );
    }

    /**
     * Create vehicle
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => [
                'required',
                'integer',
                'exists:customers,id',
            ],

            'registration_number' => [
                'required',
                'string',
                'max:30',
                'unique:vehicles,registration_number',
            ],

            'make' => [
                'required',
                'string',
                'max:100',
            ],

            'model' => [
                'required',
                'string',
                'max:100',
            ],

            'variant' => [
                'nullable',
                'string',
                'max:100',
            ],

            'fuel_type' => [
                'nullable',
                'string',
                'max:50',
            ],

            'manufacturing_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:' . (date('Y') + 1),
            ],

            'color' => [
                'nullable',
                'string',
                'max:50',
            ],

            'vin' => [
                'nullable',
                'string',
                'max:100',
                'unique:vehicles,vin',
            ],

            'engine_number' => [
                'nullable',
                'string',
                'max:100',
                'unique:vehicles,engine_number',
            ],

            'current_odometer' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ]);

        $validated['registration_number'] =
            strtoupper(
                $validated['registration_number']
            );

        $vehicle = Vehicle::create($validated);

        return ApiResponse::success(
            $vehicle->load(
                'customer:id,customer_code,name,phone'
            ),
            'Vehicle created successfully.',
            201
        );
    }

    /**
     * Show vehicle
     */
    public function show(Vehicle $vehicle)
    {
        return ApiResponse::success(
            $vehicle->load('customer'),
            'Vehicle fetched successfully.'
        );
    }

    /**
     * Update vehicle
     */
    public function update(
        Request $request,
        Vehicle $vehicle
    ) {
        $validated = $request->validate([
            'customer_id' => [
                'required',
                'integer',
                'exists:customers,id',
            ],

            'registration_number' => [
                'required',
                'string',
                'max:30',
                Rule::unique(
                    'vehicles',
                    'registration_number'
                )->ignore($vehicle->id),
            ],

            'make' => [
                'required',
                'string',
                'max:100',
            ],

            'model' => [
                'required',
                'string',
                'max:100',
            ],

            'variant' => [
                'nullable',
                'string',
                'max:100',
            ],

            'fuel_type' => [
                'nullable',
                'string',
                'max:50',
            ],

            'manufacturing_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:' . (date('Y') + 1),
            ],

            'color' => [
                'nullable',
                'string',
                'max:50',
            ],

            'vin' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique(
                    'vehicles',
                    'vin'
                )->ignore($vehicle->id),
            ],

            'engine_number' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique(
                    'vehicles',
                    'engine_number'
                )->ignore($vehicle->id),
            ],

            'current_odometer' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ]);

        $validated['registration_number'] =
            strtoupper(
                $validated['registration_number']
            );

        $vehicle->update($validated);

        return ApiResponse::success(
            $vehicle->fresh()->load(
                'customer:id,customer_code,name,phone'
            ),
            'Vehicle updated successfully.'
        );
    }

    /**
     * Activate / deactivate vehicle
     */
    public function updateStatus(
        Request $request,
        Vehicle $vehicle
    ) {
        $validated = $request->validate([
            'is_active' => [
                'required',
                'boolean',
            ],
        ]);

        $vehicle->update([
            'is_active' => $validated['is_active'],
        ]);

        return ApiResponse::success(
            $vehicle->fresh(),
            'Vehicle status updated successfully.'
        );
    }
}
