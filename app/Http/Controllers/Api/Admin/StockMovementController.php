<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Part;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StockMovementController extends Controller
{
    public function index(Request $request)
    {
        $query = StockMovement::with([
            'part:id,part_number,name,unit',
            'createdBy:id,name',
        ]);

        if ($request->filled('part_id')) {
            $query->where('part_id', $request->part_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $movements = $query
            ->latest()
            ->paginate($request->integer('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => $movements,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'part_id' => [
                'required',
                'integer',
                'exists:parts,id',
            ],

            'type' => [
                'required',
                Rule::in([
                    'in',
                    'out',
                    'return',
                    'adjustment',
                ]),
            ],

            'quantity' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'unit_cost' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'reference' => [
                'nullable',
                'string',
                'max:255',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        $movement = DB::transaction(function () use ($validated, $request) {
            /*
             * Lock the part row while calculating the new stock.
             * This prevents two stock operations from overwriting
             * each other's stock values.
             */
            $part = Part::where('id', $validated['part_id'])
                ->lockForUpdate()
                ->firstOrFail();

            $previousStock = (float) $part->current_stock;
            $quantity = (float) $validated['quantity'];

            switch ($validated['type']) {
                case 'in':
                case 'return':
                    $newStock = $previousStock + $quantity;
                    break;

                case 'out':
                    $newStock = $previousStock - $quantity;

                    if ($newStock < 0) {
                        abort(422, 'Insufficient stock available.');
                    }

                    break;

                case 'adjustment':
                    /*
                     * For adjustment, quantity represents the
                     * difference to apply.
                     *
                     * Positive quantity = add stock
                     * Negative quantity = reduce stock
                     */
                    $newStock = $previousStock + $quantity;

                    break;

                default:
                    abort(422, 'Invalid stock movement type.');
            }

            $part->update([
                'current_stock' => $newStock,
            ]);

            return StockMovement::create([
                'part_id' => $part->id,
                'type' => $validated['type'],
                'quantity' => $quantity,
                'previous_stock' => $previousStock,
                'new_stock' => $newStock,
                'unit_cost' => $validated['unit_cost'] ?? null,
                'reference' => $validated['reference'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'created_by' => $request->user()->id,
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Stock movement recorded successfully.',
            'data' => $movement->load([
                'part:id,part_number,name,unit',
                'createdBy:id,name',
            ]),
        ], 201);
    }

    public function show(StockMovement $stockMovement)
    {
        return response()->json([
            'success' => true,
            'data' => $stockMovement->load([
                'part:id,part_number,name,unit',
                'createdBy:id,name',
            ]),
        ]);
    }
}
