<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobCard;
use App\Models\JobCardPart;
use App\Models\Part;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobCardPartController extends Controller
{
    public function index(JobCard $jobCard)
    {
        $parts = $jobCard->parts()
            ->with([
                'part:id,part_number,name,unit',
                'task:id,title',
                'issuedBy:id,name',
            ])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $parts,
        ]);
    }

    public function store(Request $request, JobCard $jobCard)
    {
        $validated = $request->validate([
            'part_id' => [
                'required',
                'integer',
                'exists:parts,id',
            ],

            'job_card_task_id' => [
                'nullable',
                'integer',
                'exists:job_card_tasks,id',
            ],

            'quantity' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'unit_price' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'discount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        /*
         * If a task is supplied, make sure it belongs
         * to this Job Card.
         */
        if (!empty($validated['job_card_task_id'])) {
            $taskBelongsToJobCard = $jobCard->tasks()
                ->whereKey($validated['job_card_task_id'])
                ->exists();

            if (!$taskBelongsToJobCard) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected task does not belong to this job card.',
                ], 422);
            }
        }

        $part = Part::findOrFail($validated['part_id']);

        if (!$part->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'This part is inactive.',
            ], 422);
        }

        $unitPrice = array_key_exists('unit_price', $validated)
            && $validated['unit_price'] !== null
            ? (float) $validated['unit_price']
            : (float) $part->selling_price;

        $quantity = (float) $validated['quantity'];
        $discount = (float) ($validated['discount'] ?? 0);

        $subtotal = $quantity * $unitPrice;

        if ($discount > $subtotal) {
            return response()->json([
                'success' => false,
                'message' => 'Discount cannot be greater than the subtotal.',
            ], 422);
        }

        $total = $subtotal - $discount;

        $jobCardPart = $jobCard->parts()->create([
            'part_id' => $part->id,
            'job_card_task_id' => $validated['job_card_task_id'] ?? null,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'discount' => $discount,
            'total' => $total,
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Part added to job card successfully.',
            'data' => $jobCardPart->load([
                'part:id,part_number,name,unit',
                'task:id,title',
            ]),
        ], 201);
    }

    public function show(JobCard $jobCard, JobCardPart $jobCardPart)
    {
        if ($jobCardPart->job_card_id !== $jobCard->id) {
            abort(404);
        }

        return response()->json([
            'success' => true,
            'data' => $jobCardPart->load([
                'part:id,part_number,name,unit',
                'task:id,title',
                'issuedBy:id,name',
            ]),
        ]);
    }

    public function update(
        Request $request,
        JobCard $jobCard,
        JobCardPart $jobCardPart
    ) {
        if ($jobCardPart->job_card_id !== $jobCard->id) {
            abort(404);
        }

        if ($jobCardPart->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Only pending job card parts can be edited.',
            ], 422);
        }

        $validated = $request->validate([
            'job_card_task_id' => [
                'nullable',
                'integer',
                'exists:job_card_tasks,id',
            ],

            'quantity' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'unit_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'discount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        if (!empty($validated['job_card_task_id'])) {
            $taskBelongsToJobCard = $jobCard->tasks()
                ->whereKey($validated['job_card_task_id'])
                ->exists();

            if (!$taskBelongsToJobCard) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected task does not belong to this job card.',
                ], 422);
            }
        }

        $quantity = (float) $validated['quantity'];
        $unitPrice = (float) $validated['unit_price'];
        $discount = (float) ($validated['discount'] ?? 0);

        $subtotal = $quantity * $unitPrice;

        if ($discount > $subtotal) {
            return response()->json([
                'success' => false,
                'message' => 'Discount cannot be greater than the subtotal.',
            ], 422);
        }

        $total = $subtotal - $discount;

        $jobCardPart->update([
            'job_card_task_id' => $validated['job_card_task_id'] ?? null,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'discount' => $discount,
            'total' => $total,
            'notes' => $validated['notes'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Job card part updated successfully.',
            'data' => $jobCardPart->fresh()->load([
                'part:id,part_number,name,unit',
                'task:id,title',
            ]),
        ]);
    }

    public function destroy(JobCard $jobCard, JobCardPart $jobCardPart)
    {
        if ($jobCardPart->job_card_id !== $jobCard->id) {
            abort(404);
        }

        if ($jobCardPart->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Only pending job card parts can be removed.',
            ], 422);
        }

        $jobCardPart->delete();

        return response()->json([
            'success' => true,
            'message' => 'Part removed from job card successfully.',
        ]);
    }

    public function issue(
        Request $request,
        JobCard $jobCard,
        JobCardPart $jobCardPart
    ) {
        if ($jobCardPart->job_card_id !== $jobCard->id) {
            abort(404);
        }

        if ($jobCardPart->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Only pending parts can be issued.',
            ], 422);
        }

        $movement = DB::transaction(function () use (
            $jobCardPart,
            $request
        ) {
            $part = Part::whereKey($jobCardPart->part_id)
                ->lockForUpdate()
                ->firstOrFail();

            $quantity = (float) $jobCardPart->quantity;
            $previousStock = (float) $part->current_stock;
            $newStock = $previousStock - $quantity;

            if ($newStock < 0) {
                abort(422, 'Insufficient stock available.');
            }

            $part->update([
                'current_stock' => $newStock,
            ]);

            $movement = StockMovement::create([
                'part_id' => $part->id,
                'type' => 'out',
                'quantity' => $quantity,
                'previous_stock' => $previousStock,
                'new_stock' => $newStock,
                'unit_cost' => $part->cost_price,
                'reference' => 'JC-' . $jobCardPart->job_card_id,
                'notes' => 'Issued against Job Card Part #' . $jobCardPart->id,
                'created_by' => $request->user()->id,
            ]);

            $jobCardPart->update([
                'status' => 'issued',
                'issued_by' => $request->user()->id,
                'issued_at' => now(),
            ]);

            return $movement;
        });

        return response()->json([
            'success' => true,
            'message' => 'Part issued successfully.',
            'data' => [
                'job_card_part' => $jobCardPart->fresh()->load([
                    'part:id,part_number,name,unit',
                    'task:id,title',
                    'issuedBy:id,name',
                ]),
                'stock_movement' => $movement->load([
                    'part:id,part_number,name,unit',
                    'createdBy:id,name',
                ]),
            ],
        ]);
    }

    public function returnPart(
        Request $request,
        JobCard $jobCard,
        JobCardPart $jobCardPart
    ) {
        if ($jobCardPart->job_card_id !== $jobCard->id) {
            abort(404);
        }

        if ($jobCardPart->status !== 'issued') {
            return response()->json([
                'message' => 'Only issued parts can be returned.'
            ], 422);
        }

        $movement = DB::transaction(function () use ($request, $jobCardPart) {

            $part = Part::whereKey($jobCardPart->part_id)
                ->lockForUpdate()
                ->firstOrFail();

            $quantity = (float) $jobCardPart->quantity;

            $previousStock = (float) $part->current_stock;
            $newStock = $previousStock + $quantity;

            $part->update([
                'current_stock' => $newStock,
            ]);

            $movement = StockMovement::create([
                'part_id' => $part->id,
                'type' => 'return',
                'quantity' => $quantity,
                'previous_stock' => $previousStock,
                'new_stock' => $newStock,
                'unit_cost' => $part->cost_price,
                'reference' => 'JC-' . $jobCardPart->job_card_id,
                'notes' => 'Returned against Job Card Part #' . $jobCardPart->id,
                'created_by' => $request->user()->id,
            ]);

            $jobCardPart->update([
                'status' => 'returned',
            ]);

            return $movement;
        });

        return response()->json([
            'message' => 'Part returned successfully.',
            'data' => [
                'job_card_part' => $jobCardPart->fresh()->load('part'),
                'stock_movement' => $movement->load('part'),
            ],
        ]);
    }
}
