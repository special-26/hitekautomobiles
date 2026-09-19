<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\JobCard;
use App\Models\JobCardPart;
use App\Models\Part;
use App\Models\StockMovement;
use App\Models\StoreManagerActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\JobCardPartIssuedNotification;
use App\Models\User;
use App\Notifications\JobCardPartRequestedNotification;

class JobCardPartController extends Controller
{

    private function authorizePermission(string $permission): void
    {
        abort_unless(
            auth()->user()?->can($permission),
            403,
            'You do not have permission to perform this action.'
        );
    }

    public function pendingRequests()
    {
        $this->authorizePermission('job-card-parts.view');
        $parts = JobCardPart::query()
            ->where('status', 'pending')
            ->with([
                'jobCard:id,job_card_number,customer_id,vehicle_id',
                'jobCard.customer:id,name,phone',
                'jobCard.vehicle:id,registration_number,make,model',
                'part:id,part_number,name,unit,current_stock',
                'task:id,title',
                'activities:id,job_card_part_id,user_id,action,description,created_at',
            ])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $parts,
        ]);
    }

    public function activityHistory(Request $request)
    {
        $this->authorizePermission('job-card-parts.view');
        $activities = StoreManagerActivity::query()
            ->with([
                'user:id,name',
                'jobCardPart:id,job_card_id,part_id,job_card_task_id,quantity,status',
                'jobCardPart.jobCard:id,job_card_number,customer_id,vehicle_id',
                'jobCardPart.jobCard.vehicle:id,registration_number,make,model',
                'jobCardPart.part:id,part_number,name,unit',
                'jobCardPart.task:id,title',
            ])
            ->latest()
            ->get();

        return ApiResponse::success(
            $activities,
            'Store Manager activity history fetched successfully.'
        );
    }

    public function index(JobCard $jobCard)
    {
        $this->authorizePermission('job-card-parts.view');
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

    public function markViewed(JobCardPart $jobCardPart)
    {
        $this->authorizePermission('job-card-parts.view');
        if ($jobCardPart->status !== 'pending') {
            return ApiResponse::error(
                'Only pending part requests can be viewed.',
                422
            );
        }

        $alreadyViewed = StoreManagerActivity::query()
            ->where('job_card_part_id', $jobCardPart->id)
            ->where('action', 'viewed')
            ->exists();

        if (! $alreadyViewed) {
            StoreManagerActivity::create([
                'job_card_part_id' => $jobCardPart->id,
                'user_id' => auth()->id(),
                'action' => 'viewed',
                'description' => 'Part request viewed by Store Manager.',
            ]);
        }

        return ApiResponse::success(
            null,
            'Part request marked as viewed.'
        );
    }

    public function store(Request $request, JobCard $jobCard)
    {
        $this->authorizePermission('job-card-parts.request');
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

        $jobCardPart->load('task');

        StoreManagerActivity::create([
            'job_card_part_id' => $jobCardPart->id,
            'user_id' => auth()->id(),
            'action' => 'requested',
            'description' => 'Part requested for task: ' . (
                $jobCardPart->task?->title ?? 'General'
            ),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Notify Auto Parts Store Manager
        |--------------------------------------------------------------------------
        */

        $jobCardPart->load([
            'jobCard:id,job_card_number',
            'part:id,part_number,name,unit',
            'task:id,title',
        ]);

        $storeManagers = User::role(
            'Auto Parts Store Manager'
        )->get();

        foreach ($storeManagers as $storeManager) {
            $storeManager->notify(
                new JobCardPartRequestedNotification($jobCardPart)
            );
        }

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
        $this->authorizePermission('job-card-parts.view');
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
        $this->authorizePermission('job-card-parts.update');
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
        $this->authorizePermission('job-card-parts.remove');
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
        $this->authorizePermission('parts.issue');
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
            $lockedJobCardPart = JobCardPart::whereKey(
                $jobCardPart->id
            )
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedJobCardPart->job_card_id !== $jobCardPart->job_card_id) {
                abort(404);
            }

            if ($lockedJobCardPart->status !== 'pending') {
                abort(
                    422,
                    'Only pending parts can be issued.'
                );
            }

            $part = Part::whereKey(
                $lockedJobCardPart->part_id
            )
                ->lockForUpdate()
                ->firstOrFail();

            $quantity = (float) $lockedJobCardPart->quantity;
            $previousStock = (float) $part->current_stock;
            $newStock = $previousStock - $quantity;

            if ($newStock < 0) {
                abort(
                    422,
                    'Insufficient stock available.'
                );
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
                'reference' => 'JC-' . $lockedJobCardPart->job_card_id,
                'notes' => 'Issued against Job Card Part #'
                    . $lockedJobCardPart->id,
                'created_by' => $request->user()->id,
            ]);

            $lockedJobCardPart->update([
                'status' => 'issued',
                'issued_by' => $request->user()->id,
                'issued_at' => now(),
            ]);

            $lockedJobCardPart->load('part');

            StoreManagerActivity::create([
                'job_card_part_id' => $lockedJobCardPart->id,
                'user_id' => $request->user()->id,
                'action' => 'issued',
                'description' => 'Part issued: '
                    . $lockedJobCardPart->part->name
                    . ' × '
                    . $lockedJobCardPart->quantity,
            ]);

            return $movement;
        });

        /*
        |--------------------------------------------------------------------------
        | Notify Advisor + Mechanic Coordinator
        |--------------------------------------------------------------------------
        */

        $jobCardPart->load([
            'jobCard:id,job_card_number,advisor_id',
            'jobCard.advisor:id,user_id',
            'jobCard.advisor.user:id,name',
            'part:id,part_number,name,unit',
            'task:id,title',
        ]);

        $usersToNotify = collect();

        /*
        |--------------------------------------------------------------------------
        | Notify Advisor
        |--------------------------------------------------------------------------
        */

        if ($jobCardPart->jobCard->advisor?->user) {
            $usersToNotify->push(
                $jobCardPart->jobCard->advisor->user
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Notify Mechanic Coordinators
        |--------------------------------------------------------------------------
        */

        $coordinators = User::role(
            'Mechanic Coordinator'
        )->get();

        foreach ($coordinators as $coordinator) {
            $usersToNotify->push($coordinator);
        }

        /*
        |--------------------------------------------------------------------------
        | Send Notifications
        |--------------------------------------------------------------------------
        */

        foreach ($usersToNotify->unique('id') as $user) {
            $user->notify(
                new JobCardPartIssuedNotification($jobCardPart)
            );
        }

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
        $this->authorizePermission('parts.return');
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
