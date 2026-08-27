<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Department::query()
            ->orderBy('name');

        if (! $request->boolean('all')) {
            $query->where('is_active', true);
        }

        $departments = $query->get([
            'id',
            'name',
            'is_active',
        ]);

        return ApiResponse::success(
            $departments,
            'Departments fetched successfully.'
        );
    }
    /**
     * Create department.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:departments,name',
            ],
        ]);

        $department = Department::create([
            'name' => $validated['name'],
            'is_active' => true,
        ]);

        return ApiResponse::success(
            $department,
            'Department created successfully.',
            201
        );
    }

    /**
     * Show department
     */
    public function show(Department $department)
    {
        return ApiResponse::success(
            $department,
            'Department fetched successfully.'
        );
    }

    /**
     * Update department
     */
    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('departments', 'name')
                    ->ignore($department->id),
            ],
        ]);

        $department->update([
            'name' => $validated['name'],
        ]);

        return ApiResponse::success(
            $department->fresh(),
            'Department updated successfully.'
        );
    }

    /**
     * Update department status
     */
    public function updateStatus(
        Request $request,
        Department $department
    ) {
        $validated = $request->validate([
            'is_active' => ['required', 'boolean'],
        ]);

        $department->update([
            'is_active' => $validated['is_active'],
        ]);

        return ApiResponse::success(
            $department->fresh(),
            'Department status updated successfully.'
        );
    }
}
