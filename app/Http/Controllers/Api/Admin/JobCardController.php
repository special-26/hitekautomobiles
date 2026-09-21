<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Bay;
use App\Models\Employee;
use App\Models\JobCard;
use App\Models\JobCardInvoiceShareActivity;
use App\Models\User;
use App\Models\Vehicle;
use App\Notifications\JobCardCreatedNotification;
use App\Services\RazorpayPaymentService;
use App\Services\WhatsApp\WhatsAppMessageService;
use App\Services\WhatsApp\WhatsAppService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class JobCardController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $jobCards = JobCard::query()
            ->with([
                'customer:id,customer_code,name,phone',
                'vehicle:id,customer_id,registration_number,make,model,variant',
                'department:id,name',
                'bay:id,name,code',
                'advisor:id,user_id',
            ])
            ->orderByDesc('id')
            ->get();
        return ApiResponse::success(
            $jobCards,
            'Job cards fetched successfully.'
        );
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'customer_id' => [
                'required',
                'integer',
                'exists:customers,id',
            ],

            'vehicle_id' => [
                'required',
                'integer',
                'exists:vehicles,id',
            ],
            'department_id' => ['required', 'integer', 'exists:departments,id',],
            'bay_id' => ['nullable', 'integer', 'exists:bays,id',],
            'advisor_id' => ['nullable', 'integer', 'exists:employees,id',],
            'complaint' => ['required', 'string',],
            'customer_notes' => ['nullable', 'string',],
            'estimated_cost' => ['nullable', 'numeric', 'min:0',],
            'estimated_completion_at' => ['nullable', 'date',],
        ]);

        if ($request->user()->hasRole('Advisor')) {
            $advisorEmployee = Employee::query()
                ->where('user_id', $request->user()->id)
                ->where('status', 'active')
                ->first();

            if (! $advisorEmployee) {
                return ApiResponse::error(
                    'Your employee profile could not be found.',
                    422
                );
            }

            $validated['advisor_id'] = $advisorEmployee->id;
        }

        /* 
        |-------------------------------------------------------------------------- 
        | Validate Vehicle Belongs To Customer |-------------------------------------------------------------------------- 
        */
        $vehicleBelongsToCustomer = DB::table('vehicles')
            ->where('id', $validated['vehicle_id'])
            ->where('customer_id', $validated['customer_id'])
            ->exists();

        if (! $vehicleBelongsToCustomer) {
            return ApiResponse::error(
                'The selected vehicle does not belong to the selected customer.',
                422
            );
        }

        /* 
        |-------------------------------------------------------------------------- 
        | Validate Bay Belongs To Department |-------------------------------------------------------------------------- 
        */
        if (! empty($validated['bay_id'])) {
            $bayBelongsToDepartment = DB::table('bays')
                ->where('id', $validated['bay_id'])
                ->where(
                    'department_id',
                    $validated['department_id']
                )
                ->exists();

            if (! $bayBelongsToDepartment) {
                return ApiResponse::error(
                    'The selected bay does not belong to the selected department.',
                    422
                );
            }
        }

        /* 
        |-------------------------------------------------------------------------- 
        | Create Job Card 
        |-------------------------------------------------------------------------- 
        */
        $jobCard = DB::transaction(function () use ($validated) {
            $lastJobCard = JobCard::query()
                ->orderByDesc('id')
                ->lockForUpdate()
                ->first();

            $nextNumber = $lastJobCard
                ? $lastJobCard->id + 1
                : 1;

            $validated['job_card_number'] =
                'JC-' . str_pad(
                    $nextNumber,
                    6,
                    '0',
                    STR_PAD_LEFT
                );

            $validated['status'] = 'pending';
            $validated['is_active'] = true;

            return JobCard::create($validated);
        });

        $jobCard->load([
            'customer:id,customer_code,name,phone',
            'vehicle:id,customer_id,registration_number,make,model,variant',
            'department:id,name',
            'bay:id,name,code',
            'advisor:id,user_id',
        ]);

        $usersToNotify = User::role([
            'Super Admin',
            'Admin',
            'Mechanic Coordinator',
        ])->get();

        foreach ($usersToNotify as $user) {
            $user->notify(
                new JobCardCreatedNotification($jobCard)
            );
        }

        return ApiResponse::success(
            $jobCard,
            'Job card created successfully.',
            201
        );
    }

    /** * Show job card */
    public function show(JobCard $jobCard): JsonResponse
    {
        $jobCard->load([
            'customer',
            'vehicle',
            'department',
            'bay',
            'advisor:id,user_id',
        ]);

        return ApiResponse::success(
            $jobCard,
            'Job card fetched successfully.'
        );
    }

    /** * Update job card */
    public function update(Request $request, JobCard $jobCard): JsonResponse
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'integer', 'exists:customers,id',],

            'vehicle_id' => ['required', 'integer', 'exists:vehicles,id',],

            'department_id' => ['required', 'integer', 'exists:departments,id',],

            'bay_id' => ['nullable', 'integer', 'exists:bays,id',],

            'advisor_id' => ['nullable', 'integer', 'exists:employees,id',],

            'complaint' => ['required', 'string',],

            'customer_notes' => ['nullable', 'string',],

            'estimated_cost' => ['nullable', 'numeric', 'min:0',],

            'estimated_completion_at' => ['nullable', 'date',],
        ]);

        /* 
        |-------------------------------------------------------------------------- 
        | Validate Vehicle Belongs To Customer |-------------------------------------------------------------------------- 
        */
        $vehicleBelongsToCustomer = DB::table('vehicles')
            ->where('id', $validated['vehicle_id'])
            ->where('customer_id', $validated['customer_id'])
            ->exists();

        if (! $vehicleBelongsToCustomer) {
            return ApiResponse::error(
                'The selected vehicle does not belong to the selected customer.',
                422
            );
        }

        /* 
        |-------------------------------------------------------------------------- 
        | Validate Bay Belongs To Department |-------------------------------------------------------------------------- 
        */
        if (! empty($validated['bay_id'])) {
            $bayBelongsToDepartment = DB::table('bays')
                ->where('id', $validated['bay_id'])
                ->where(
                    'department_id',
                    $validated['department_id']
                )
                ->exists();

            if (! $bayBelongsToDepartment) {
                return ApiResponse::error(
                    'The selected bay does not belong to the selected department.',
                    422
                );
            }
        }

        $jobCard->update($validated);

        return ApiResponse::success(
            $jobCard->fresh()->load([
                'customer:id,customer_code,name,phone',
                'vehicle:id,customer_id,registration_number,make,model,variant',
                'department:id,name',
                'bay:id,name,code',
                'advisor:id,user_id',
            ]),
            'Job card updated successfully.'
        );
    }

    /** * Activate / deactivate job card */
    public function updateStatus(
        Request $request,
        JobCard $jobCard
    ): JsonResponse {
        $validated = $request->validate([
            'is_active' => [
                'required',
                'boolean',
            ],
        ]);

        $jobCard->update([
            'is_active' => $validated['is_active'],
        ]);

        return ApiResponse::success(
            $jobCard->fresh(),
            'Job card status updated successfully.'
        );
    }

    /** * Update workflow status */

    public function updateWorkflowStatus(
        Request $request,
        JobCard $jobCard
    ) {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'pending',
                    'confirmed',
                    'in_progress',
                    'on_hold',
                    'completed',
                    'cancelled',
                ]),
            ],
        ]);

        $newStatus = $validated['status'];
        $currentStatus = $jobCard->status;

        $allowedTransitions = [
            'pending' => [
                'confirmed',
                'cancelled',
            ],

            'confirmed' => [
                'pending',
                'in_progress',
                'cancelled',
            ],

            'in_progress' => [
                'confirmed',
                'on_hold',
                'completed',
            ],

            'on_hold' => [
                'in_progress',
                'completed',
                'cancelled'
            ],

            'completed' => [],

            'cancelled' => [],
        ];

        if (
            $newStatus !== $currentStatus &&
            ! in_array(
                $newStatus,
                $allowedTransitions[$currentStatus] ?? [],
                true
            )
        ) {
            return ApiResponse::error(
                "Job card cannot be changed from {$currentStatus} to {$newStatus}.",
                422
            );
        }

        $jobCard->update([
            'status' => $newStatus,
        ]);

        return ApiResponse::success(
            $jobCard->fresh(),
            'Job card workflow status updated successfully.'
        );
    }

    // WhatsApp Function
    public function whatsappJobCardCreated(
        JobCard $jobCard,
        WhatsAppService $whatsapp,
        WhatsAppMessageService $messages
    ) {
        $jobCard->load([
            'customer',
            'vehicle',
        ]);

        if (!$jobCard->customer?->phone) {
            return response()->json([
                'message' => 'Customer phone number is not available.',
            ], 422);
        }

        $message = $messages->jobCardCreated($jobCard);

        $url = $whatsapp->createChatUrl(
            $jobCard->customer->phone,
            $message
        );

        return response()->json([
            'data' => [
                'phone' => $jobCard->customer->phone,
                'message' => $message,
                'url' => $url,
            ],
        ]);
    }

    public function whatsappMessage(
        Request $request,
        JobCard $jobCard,
        WhatsAppService $whatsapp,
        WhatsAppMessageService $messages,
    ) {
        $request->validate([
            'type' => [
                'required',
                'string',
                'in:job_card_created,vehicle_ready,estimate,final',
            ],
        ]);

        $jobCard->load([
            'customer',
            'vehicle',
        ]);

        if (!$jobCard->customer?->phone) {
            return response()->json([
                'message' => 'Customer phone number is not available.',
            ], 422);
        }

        $message = match ($request->type) {
            'job_card_created' =>
            $messages->jobCardCreated($jobCard),

            'vehicle_ready' =>
            $messages->vehicleReady($jobCard),

            'estimate' =>
            $messages->estimateBill($jobCard),

            'final' => $this->generateFinalBillMessage(
                $jobCard,
                $messages,
            ),

            default => null,
        };

        if (!$message) {
            return response()->json([
                'message' => 'Unsupported WhatsApp message type.',
            ], 422);
        }

        $url = $whatsapp->createChatUrl(
            $jobCard->customer->phone,
            $message
        );

        /*
        |--------------------------------------------------------------------------
        | Record Invoice Share Activity
        |--------------------------------------------------------------------------
        */
        if (in_array($request->type, ['estimate', 'final'], true)) {
            $invoice = $jobCard->invoices()
                ->latest()
                ->first();

            if ($invoice) {
                // The final bill flow may have just created a payment link.
                $invoice->refresh();

                JobCardInvoiceShareActivity::create([
                    'job_card_invoice_id' => $invoice->id,

                    'shared_by' => auth()->id(),

                    'share_type' => $request->type,

                    'channel' => 'whatsapp',

                    'payment_link_included' =>
                    $request->type === 'final'
                        && !empty($invoice->razorpay_payment_link_url),

                    'shared_at' => now(),
                ]);
            }
        }

        return response()->json([
            'phone' => $jobCard->customer->phone,
            'message' => $message,
            'url' => $url,
        ]);
    }

    /**
     * Generate final bill WhatsApp message
     * with Razorpay payment link.
     */
    private function generateFinalBillMessage(
        JobCard $jobCard,
        WhatsAppMessageService $messages
    ): string {
        return $messages->finalBill($jobCard);
    }

    // Generate Payment link
    public function generatePaymentLink(
        JobCard $jobCard,
        RazorpayPaymentService $razorpay
    ) {
        $invoice = $jobCard->invoices()
            ->latest()
            ->first();

        if (!$invoice) {
            return response()->json([
                'message' => 'Final bill is not available for this job card.',
            ], 422);
        }

        if ((float) $invoice->total <= 0) {
            return response()->json([
                'message' => 'Invoice total must be greater than zero.',
            ], 422);
        }

        if ($invoice->approval_status !== 'approved') {
            return response()->json([
                'message' => 'Invoice must be approved before generating a payment link.',
            ], 422);
        }

        if (
            $invoice->razorpay_payment_status === 'paid'
        ) {
            return response()->json([
                'message' => 'This invoice has already been paid.',
            ], 422);
        }

        $paymentLink = $razorpay
            ->getOrCreateInvoicePaymentLink($invoice);

        $invoice->refresh();

        return response()->json([
            'message' => 'Payment link generated successfully.',
            'invoice' => $invoice,
            'payment_link' => $paymentLink,
        ]);
    }

    public function approveInvoice(JobCard $jobCard)
    {
        $invoice = $jobCard->invoices()
            ->latest()
            ->first();

        if (!$invoice) {
            return response()->json([
                'message' => 'Final bill is not available for this job card.',
            ], 422);
        }

        if ($invoice->razorpay_payment_status === 'paid') {
            return response()->json([
                'message' => 'This invoice has already been paid.',
            ], 422);
        }

        if ($invoice->approval_status === 'approved') {
            return response()->json([
                'message' => 'This invoice is already approved.',
                'invoice' => $invoice,
            ]);
        }

        $invoice->update([
            'approval_status' => 'approved',
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        $invoice->refresh();

        return response()->json([
            'message' => 'Invoice approved successfully.',
            'invoice' => $invoice,
        ]);
    }

    public function whatsappPaymentLink(
        JobCard $jobCard,
        WhatsAppService $whatsapp,
        WhatsAppMessageService $messages,
        RazorpayPaymentService $razorpay
    ) {
        $jobCard->load([
            'customer',
            'vehicle',
        ]);

        if (!$jobCard->customer?->phone) {
            return response()->json([
                'message' => 'Customer phone number is not available.',
            ], 422);
        }

        $invoice = $jobCard->invoices()
            ->latest()
            ->first();

        if (!$invoice) {
            return response()->json([
                'message' => 'Final bill is not available for this job card.',
            ], 422);
        }

        if ($invoice->approval_status !== 'approved') {
            return response()->json([
                'message' => 'Invoice must be approved before sharing a payment link.',
            ], 422);
        }

        if ($invoice->razorpay_payment_status === 'paid') {
            return response()->json([
                'message' => 'This invoice has already been paid.',
            ], 422);
        }

        if ((float) $invoice->total <= 0) {
            return response()->json([
                'message' => 'Invoice total must be greater than zero.',
            ], 422);
        }

        $paymentLink = $razorpay
            ->getOrCreateInvoicePaymentLink($invoice);

        $message = $messages->paymentLink(
            $jobCard,
            $paymentLink
        );

        $url = $whatsapp->createChatUrl(
            $jobCard->customer->phone,
            $message
        );

        return response()->json([
            'phone' => $jobCard->customer->phone,
            'message' => $message,
            'payment_link' => $paymentLink,
            'url' => $url,
        ]);
    }
}
