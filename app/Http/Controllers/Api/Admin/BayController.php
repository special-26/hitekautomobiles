<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Bay;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BayController extends Controller
{
    /**
     * List all bays
     */
    public function index(Request $request)
    {
        $bays = Bay::query()
            ->with('department:id,name')
            ->when(
                $request->filled('department_id'),
                fn($query) =>
                $query->where('department_id', $request->department_id)
            )
            ->when(
                $request->has('is_active'),
                fn($query) =>
                $query->where('is_active', $request->boolean('is_active'))
            )
            ->orderBy('name')
            ->get();

        return ApiResponse::success(
            $bays,
            'Bays fetched successfully.'
        );
    }

    /**
     * Create a bay
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100',],
            'code' => ['required', 'string', 'max:50', 'unique:bays,code',],
            'department_id' => ['required', 'integer', 'exists:departments,id',],
            'type' => ['required', 'string', 'max:100',],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $bay = Bay::create([
            'name' => $validated['name'],
            'code' => strtoupper($validated['code']),
            'department_id' => $validated['department_id'],
            'type' => $validated['type'],
            'is_active' => true,
        ]);

        return ApiResponse::success(
            $bay->load('department:id,name'),
            'Bay created successfully.',
            201
        );
    }

    /**
     * Show a single bay
     */
    public function show(Bay $bay)
    {
        return ApiResponse::success(
            $bay->load([
                'department:id,name',
                'tasks:id,job_card_id,department_id,bay_id,assigned_to,title,status,estimated_minutes',
            ]),
            'Bay fetched successfully.'
        );
    }

    /**
     * Update bay
     */
    public function update(
        Request $request,
        Bay $bay
    ) {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100',],
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('bays', 'code')->ignore($bay->id),
            ],
            'department_id' => ['required', 'integer', 'exists:departments,id',],
            'type' => ['required', 'string', 'max:100',],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $bay->update([
            'name' => $validated['name'],
            'code' => strtoupper($validated['code']),
            'department_id' => $validated['department_id'],
            'type' => $validated['type'],
        ]);

        return ApiResponse::success(
            $bay->fresh()->load('department:id,name'),
            'Bay updated successfully.'
        );
    }

    /**
     * Activate / deactivate bay
     */
    public function updateStatus(
        Request $request,
        Bay $bay
    ) {
        $validated = $request->validate([
            'is_active' => [
                'required',
                'boolean',
            ],
        ]);

        $bay->update([
            'is_active' => $validated['is_active'],
        ]);

        return ApiResponse::success(
            $bay->fresh()->load('department:id,name'),
            'Bay status updated successfully.'
        );
    }
}
