<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Part;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PartController extends Controller
{
    public function index(Request $request)
    {
        $query = Part::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('part_number', 'ilike', "%{$search}%")
                    ->orWhere('name', 'ilike', "%{$search}%")
                    ->orWhere('brand', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', filter_var(
                $request->is_active,
                FILTER_VALIDATE_BOOLEAN
            ));
        }

        $parts = $query
            ->orderBy('name')
            ->paginate($request->integer('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => $parts,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'part_number' => [
                'required',
                'string',
                'max:100',
                'unique:parts,part_number',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'category' => [
                'nullable',
                'string',
                'max:100',
            ],
            'brand' => [
                'nullable',
                'string',
                'max:100',
            ],
            'unit' => [
                'required',
                'string',
                'max:50',
            ],
            'cost_price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'selling_price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'current_stock' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'minimum_stock' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'is_active' => [
                'boolean',
            ],
        ]);

        $part = Part::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Part created successfully.',
            'data' => $part,
        ], 201);
    }

    public function show(Part $part)
    {
        return response()->json([
            'success' => true,
            'data' => $part,
        ]);
    }

    public function update(Request $request, Part $part)
    {
        $validated = $request->validate([
            'part_number' => [
                'required',
                'string',
                'max:100',
                Rule::unique('parts', 'part_number')
                    ->ignore($part->id),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'category' => [
                'nullable',
                'string',
                'max:100',
            ],
            'brand' => [
                'nullable',
                'string',
                'max:100',
            ],
            'unit' => [
                'required',
                'string',
                'max:50',
            ],
            'cost_price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'selling_price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'current_stock' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'minimum_stock' => [
                'nullable',
                'numeric',
                'min:0',
            ],
            'is_active' => [
                'boolean',
            ],
        ]);

        $part->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Part updated successfully.',
            'data' => $part->fresh(),
        ]);
    }

    public function destroy(Part $part)
    {
        $part->update([
            'is_active' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Part deactivated successfully.',
        ]);
    }
}
