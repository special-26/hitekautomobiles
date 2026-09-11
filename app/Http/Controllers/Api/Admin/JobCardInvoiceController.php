<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobCard;
use App\Models\JobCardInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobCardInvoiceController extends Controller
{
    public function show(JobCard $jobCard)
    {
        $invoice = $jobCard->invoices()
            ->with('items')
            ->latest()
            ->first();

        if (! $invoice) {
            return response()->json([
                'data' => null,
            ]);
        }

        return response()->json([
            'data' => $invoice,
        ]);
    }

    public function generate(JobCard $jobCard)
    {
        $jobCard->load([
            'tasks' => function ($query) {
                $query->whereIn('status', [
                    'in_progress',
                    'completed',
                ]);
            },
            'parts' => function ($query) {
                $query->where('status', 'issued')
                    ->with('part');
            },
        ]);

        $items = collect();

        // Labour from job card tasks
        foreach ($jobCard->tasks as $task) {
            $labourCost = (float) ($task->labour_cost ?? 0);

            if ($labourCost <= 0) {
                continue;
            }

            $items->push([
                'item_type' => 'labour',
                'description' => $task->title,
                'quantity' => 1,
                'unit_price' => $labourCost,
                'discount' => 0,
                'total' => $labourCost,
            ]);
        }

        // Parts actually issued
        foreach ($jobCard->parts as $jobCardPart) {
            $unitPrice = (float) ($jobCardPart->unit_price ?? 0);
            $quantity = (float) ($jobCardPart->quantity ?? 0);
            $discount = (float) ($jobCardPart->discount ?? 0);

            $total = max(
                0,
                ($quantity * $unitPrice) - $discount
            );

            $items->push([
                'item_type' => 'part',
                'description' => $jobCardPart->part?->name
                    ?? 'Part',
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'discount' => $discount,
                'total' => $total,
            ]);
        }

        return response()->json([
            'data' => [
                'items' => $items->values(),
                'subtotal' => $items->sum('total'),
                'discount' => 0,
                'tax' => 0,
                'total' => $items->sum('total'),
            ],
        ]);
    }

    public function store(Request $request, JobCard $jobCard)
    {
        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],

            'items.*.item_type' => [
                'required',
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

        $invoice = DB::transaction(function () use (
            $validated,
            $jobCard,
            $request
        ) {
            $items = collect($validated['items'])->map(function ($item) {
                $quantity = (float) $item['quantity'];
                $unitPrice = (float) $item['unit_price'];
                $discount = (float) ($item['discount'] ?? 0);

                $total = max(
                    0,
                    ($quantity * $unitPrice) - $discount
                );

                return [
                    'item_type' => $item['item_type'],
                    'description' => $item['description'],
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'discount' => $discount,
                    'total' => $total,
                ];
            });

            $subtotal = $items->sum('total');

            $discount = max(
                0,
                (float) ($validated['discount'] ?? 0)
            );

            $tax = max(
                0,
                (float) ($validated['tax'] ?? 0)
            );

            $total = max(
                0,
                $subtotal - $discount + $tax
            );

            $invoice = $jobCard->invoices()
                ->where('status', 'draft')
                ->latest()
                ->first();

            if (! $invoice) {
                $invoice = JobCardInvoice::create([
                    'job_card_id' => $jobCard->id,
                    'invoice_number' => 'INV-' . now()->format('YmdHis'),
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'tax' => $tax,
                    'total' => $total,
                    'status' => 'draft',
                    'created_by' => $request->user()->id,
                ]);
            } else {
                $invoice->update([
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'tax' => $tax,
                    'total' => $total,
                ]);

                $invoice->items()->delete();
            }

            foreach ($items as $item) {
                $invoice->items()->create($item);
            }

            return $invoice->load('items');
        });

        return response()->json([
            'message' => 'Final bill saved successfully.',
            'data' => $invoice,
        ]);
    }
}
