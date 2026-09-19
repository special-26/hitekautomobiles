<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Part;
use App\Models\PartCategory;
use App\Models\Vehicle;
use App\Models\VehicleBrand;
use App\Models\VehicleModel;
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


    // ==========================================
    // VEHICLE CATALOG - BRANDS & MODELS
    // ==========================================

    // List brands
    public function catalogBrands()
    {
        $brands = VehicleBrand::query()
            ->where('is_active', true)
            ->withCount([
                'models' => function ($query) {
                    $query->where('is_active', true);
                },
            ])
            ->orderBy('name')
            ->get();

        return ApiResponse::success(
            $brands,
            'Vehicle brands fetched successfully.'
        );
    }

    // List models by brand
    public function catalogModels(VehicleBrand $vehicleBrand)
    {
        $models = $vehicleBrand->models()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return ApiResponse::success(
            $models,
            'Vehicle models fetched successfully.'
        );
    }

    // ==========================================
    // PART CATEGORIES
    // ==========================================

    // List active part categories
    public function partCategories()
    {
        $categories = PartCategory::query()
            ->where('is_active', true)
            ->withCount('parts')
            ->orderBy('name')
            ->get();

        return ApiResponse::success(
            $categories,
            'Part categories fetched successfully.'
        );
    }

    // ==========================================
    // MODEL-PART ASSIGNMENTS
    // ==========================================

    // List assigned parts
    public function assignedParts(VehicleModel $vehicleModel)
    {
        $parts = $vehicleModel->parts()
            ->with('category:id,name,slug')
            ->where('parts.is_active', true)
            ->orderBy('parts.name')
            ->get();

        return ApiResponse::success(
            $parts,
            'Assigned parts fetched successfully.'
        );
    }

    // List available parts
    public function availableParts(
        Request $request,
        VehicleModel $vehicleModel
    ) {
        $validated = $request->validate([
            'category_id' => [
                'nullable',
                'integer',
                'exists:part_categories,id',
            ],
            'search' => [
                'nullable',
                'string',
                'max:100',
            ],
        ]);

        $assignedPartIds = $vehicleModel->parts()
            ->pluck('parts.id');

        $parts = Part::query()
            ->with('category:id,name,slug')
            ->where('parts.is_active', true)
            ->when(
                $validated['category_id'] ?? null,
                function ($query, $categoryId) {
                    $query->where(
                        'part_category_id',
                        $categoryId
                    );
                }
            )
            ->when(
                $validated['search'] ?? null,
                function ($query, $search) {
                    $query->where(function ($query) use ($search) {
                        $query->where(
                            'name',
                            'ilike',
                            "%{$search}%"
                        )->orWhere(
                            'part_number',
                            'ilike',
                            "%{$search}%"
                        );
                    });
                }
            )
            ->orderBy('name')
            ->get()
            ->map(function ($part) use ($assignedPartIds) {
                $part->is_assigned = $assignedPartIds
                    ->contains($part->id);

                return $part;
            });

        return ApiResponse::success(
            $parts,
            'Available parts fetched successfully.'
        );
    }

    /**
     * Assign a part to a vehicle model
     */
    public function assignPart(
        Request $request,
        VehicleModel $vehicleModel
    ) {
        $validated = $request->validate([
            'part_id' => [
                'required',
                'integer',
                'exists:parts,id',
            ],
        ]);

        $part = Part::query()
            ->where('id', $validated['part_id'])
            ->where('is_active', true)
            ->firstOrFail();

        $vehicleModel->parts()->syncWithoutDetaching([
            $part->id,
        ]);

        return ApiResponse::success(
            $part,
            'Part assigned to vehicle model successfully.'
        );
    }

    /**
     * Remove a part from a vehicle model
     */
    public function removePart(
        VehicleModel $vehicleModel,
        Part $part
    ) {
        $vehicleModel->parts()->detach($part->id);

        return ApiResponse::success(
            null,
            'Part removed from vehicle model successfully.'
        );
    }
}
