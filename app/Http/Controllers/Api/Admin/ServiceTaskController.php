<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Part;
use App\Models\ServiceTask;
use App\Models\ServiceTaskPart;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ServiceTaskController extends Controller
{
    /**
     * List all predefined service tasks.
     */
    public function index(Request $request)
    {
        $tasks = ServiceTask::query()
            ->with('category:id,name')
            ->withCount('taskParts')
            ->when(
                $request->filled('search'),
                function ($query) use ($request) {
                    $search = $request->input('search');

                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'ilike', "%{$search}%")
                            ->orWhere('description', 'ilike', "%{$search}%");
                    });
                }
            )
            ->when(
                $request->has('is_active'),
                fn($query) => $query->where(
                    'is_active',
                    $request->boolean('is_active')
                )
            )
            ->latest()
            ->paginate($request->integer('per_page', 15));

        return response()->json([
            'success' => true,
            'message' => 'Service tasks retrieved successfully.',
            'data' => $tasks,
        ]);
    }

    /**
     * Show a predefined task with its suggested parts.
     */
    public function show(ServiceTask $serviceTask)
    {
        $serviceTask->load([
            'category:id,name',
            'taskParts.part:id,name,category',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Service task retrieved successfully.',
            'data' => $serviceTask,
        ]);
    }

    /**
     * Create a predefined service task.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:150',
            ],
            'slug' => [
                'nullable',
                'string',
                'max:180',
                'unique:service_tasks,slug',
            ],
            'part_category_id' => [
                'nullable',
                'exists:part_categories,id',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'instructions' => [
                'nullable',
                'string',
            ],
            'is_active' => [
                'sometimes',
                'boolean',
            ],
        ]);

        $validated['slug'] = $validated['slug']
            ?? Str::slug($validated['name']);

        // Prevent duplicate slugs generated from different names.
        if (ServiceTask::where('slug', $validated['slug'])->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'A service task with this slug already exists.',
            ], 422);
        }

        $serviceTask = ServiceTask::create($validated);

        $serviceTask->load('category:id,name');

        return response()->json([
            'success' => true,
            'message' => 'Service task created successfully.',
            'data' => $serviceTask,
        ], 201);
    }

    /**
     * Update a predefined service task.
     */
    public function update(
        Request $request,
        ServiceTask $serviceTask
    ) {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:150',
            ],
            'slug' => [
                'nullable',
                'string',
                'max:180',
                Rule::unique('service_tasks', 'slug')
                    ->ignore($serviceTask->id),
            ],
            'part_category_id' => [
                'nullable',
                'exists:part_categories,id',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'instructions' => [
                'nullable',
                'string',
            ],
            'is_active' => [
                'sometimes',
                'boolean',
            ],
        ]);

        $validated['slug'] = $validated['slug']
            ?? Str::slug($validated['name']);

        $serviceTask->update($validated);

        $serviceTask->load('category:id,name');

        return response()->json([
            'success' => true,
            'message' => 'Service task updated successfully.',
            'data' => $serviceTask,
        ]);
    }

    /**
     * Activate or deactivate a predefined task.
     */
    public function updateStatus(
        Request $request,
        ServiceTask $serviceTask
    ) {
        $validated = $request->validate([
            'is_active' => [
                'required',
                'boolean',
            ],
        ]);

        $serviceTask->update([
            'is_active' => $validated['is_active'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Service task status updated successfully.',
            'data' => $serviceTask,
        ]);
    }

    /**
     * Add a suggested part to a service task.
     */
    public function addPart(
        Request $request,
        ServiceTask $serviceTask
    ) {
        $validated = $request->validate([
            'part_id' => [
                'required',
                'exists:parts,id',
            ],
            'default_quantity' => [
                'required',
                'integer',
                'min:1',
            ],
            'is_required' => [
                'sometimes',
                'boolean',
            ],
        ]);

        $part = Part::findOrFail($validated['part_id']);

        if (ServiceTaskPart::where('service_task_id', $serviceTask->id)
            ->where('part_id', $part->id)
            ->exists()
        ) {
            return response()->json([
                'success' => false,
                'message' => 'This part is already assigned to the task.',
            ], 422);
        }

        $taskPart = ServiceTaskPart::create([
            'service_task_id' => $serviceTask->id,
            'part_id' => $part->id,
            'default_quantity' => $validated['default_quantity'],
            'is_required' => $validated['is_required'] ?? false,
        ]);

        $taskPart->load('part');

        return response()->json([
            'success' => true,
            'message' => 'Suggested part added successfully.',
            'data' => $taskPart,
        ], 201);
    }

    /**
     * Update suggested part settings.
     */
    public function updatePart(
        Request $request,
        ServiceTask $serviceTask,
        ServiceTaskPart $serviceTaskPart
    ) {
        if ($serviceTaskPart->service_task_id !== $serviceTask->id) {
            return response()->json([
                'success' => false,
                'message' => 'This part does not belong to the selected task.',
            ], 404);
        }

        $validated = $request->validate([
            'default_quantity' => [
                'required',
                'integer',
                'min:1',
            ],
            'is_required' => [
                'required',
                'boolean',
            ],
        ]);

        $serviceTaskPart->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Suggested part updated successfully.',
            'data' => $serviceTaskPart->load('part'),
        ]);
    }

    /**
     * Remove a suggested part from a service task.
     */
    public function removePart(
        ServiceTask $serviceTask,
        ServiceTaskPart $serviceTaskPart
    ) {
        if ($serviceTaskPart->service_task_id !== $serviceTask->id) {
            return response()->json([
                'success' => false,
                'message' => 'This part does not belong to the selected task.',
            ], 404);
        }

        $serviceTaskPart->delete();

        return response()->json([
            'success' => true,
            'message' => 'Suggested part removed successfully.',
        ]);
    }

    // Search parts - add to predefined task
    public function searchParts(Request $request)
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'category_id' => ['nullable', 'integer', 'exists:part_categories,id'],
        ]);

        $parts = Part::query()
            ->select([
                'id',
                'name',
                'category',
            ])
            ->where('is_active', true)
            ->with('category:id,name')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'ilike', "%{$search}%")
                        ->orWhere('part_number', 'ilike', "%{$search}%");
                });
            })
            ->when($request->category_id, function ($query, $categoryId) {
                $query->where('part_category_id', $categoryId);
            })
            ->orderBy('name')
            ->limit(30)
            ->get();

        return ApiResponse::success($parts);
    }
}
