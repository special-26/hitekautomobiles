<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobCard;
use App\Models\JobCardEstimate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobCardEstimateController extends Controller
{
    /**
     * Get the estimate for a job card.
     */
    public function show(JobCard $jobCard)
    {
        $estimate = $jobCard->estimates()
            ->with('items')
            ->latest()
            ->first();

        return response()->json([
            'success' => true,
            'data' => $estimate,
        ]);
    }

    /**
     * Create or update the estimate for a job card.
     */
    public function store(Request $request, JobCard $jobCard)
    {
        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],

            'items.*.item_type' => [
                'required',
                'string',
                'in:labour,part',
            ],

            'items.*.description' => [
                'required',
                'string',
                'max:255',
            ],

            'items.*.quantity' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'items.*.unit_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'items.*.discount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'discount' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'tax' => [
                'nullable',
                'numeric',
                'min:0',
            ],
        ]);

        $estimate = DB::transaction(function () use (
            $validated,
            $jobCard,
            $request
        ) {
            $items = $validated['items'];

            $subtotal = 0;

            foreach ($items as &$item) {
                $quantity = (float) $item['quantity'];
                $unitPrice = (float) $item['unit_price'];
                $discount = (float) ($item['discount'] ?? 0);

                $itemTotal = max(
                    0,
                    ($quantity * $unitPrice) - $discount
                );

                $item['discount'] = $discount;
                $item['total'] = $itemTotal;

                $subtotal += $itemTotal;
            }

            unset($item);

            $discount = (float) ($validated['discount'] ?? 0);
            $tax = (float) ($validated['tax'] ?? 0);

            $taxableAmount = max(
                0,
                $subtotal - $discount
            );

            $total = $taxableAmount + $tax;

            $estimate = $jobCard->estimates()
                ->where('status', 'draft')
                ->latest()
                ->first();

            if (!$estimate) {
                $estimate = JobCardEstimate::create([
                    'job_card_id' => $jobCard->id,
                    'estimate_number' => 'EST-' . now()->format('YmdHis'),
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'tax' => $tax,
                    'total' => $total,
                    'status' => 'draft',
                    'created_by' => $request->user()->id,
                ]);
            } else {
                $estimate->update([
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'tax' => $tax,
                    'total' => $total,
                ]);

                $estimate->items()->delete();
            }

            foreach ($items as $item) {
                $estimate->items()->create($item);
            }

            return $estimate->load('items');
        });

        return response()->json([
            'success' => true,
            'message' => 'Estimated bill saved successfully.',
            'data' => $estimate,
        ], 201);
    }
}
