
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">
                Leave Management
            </h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Review employee leave requests and manage approvals.
            </p>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 dark:border-green-800 dark:bg-green-950 dark:text-green-200">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 dark:border-red-800 dark:bg-red-950 dark:text-red-200">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div>
            <label for="leaveSearch" class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">
                Search employee
            </label>
            <input
                id="leaveSearch"
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Employee name..."
                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-hitek-red focus:outline-none dark:border-slate-700 dark:bg-slate-900 dark:text-white"
            >
        </div>

        <div>
            <label for="leaveStatus" class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">
                Status
            </label>
            <select
                id="leaveStatus"
                wire:model.live="status"
                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-hitek-red focus:outline-none dark:border-slate-700 dark:bg-slate-900 dark:text-white"
            >
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
                <option value="cancelled">Cancelled</option>
                <option value="">All statuses</option>
            </select>
        </div>

        <div>
            <label for="leaveType" class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">
                Leave Type
            </label>
            <select
                id="leaveType"
                wire:model.live="leaveType"
                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-hitek-red focus:outline-none dark:border-slate-700 dark:bg-slate-900 dark:text-white"
            >
                <option value="">All types</option>
                <option value="casual">Casual Leave</option>
                <option value="sick">Sick Leave</option>
                <option value="unpaid">Unpaid Leave</option>
                <option value="other">Other</option>
            </select>
        </div>

        <div>
            <label for="leaveStartDate" class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">
                Start Date From
            </label>
            <input
                id="leaveStartDate"
                type="date"
                wire:model.live="startDate"
                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-hitek-red focus:outline-none dark:border-slate-700 dark:bg-slate-900 dark:text-white"
            >
        </div>

        <div>
            <label for="leaveEndDate" class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">
                End Date To
            </label>
            <input
                id="leaveEndDate"
                type="date"
                wire:model.live="endDate"
                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-hitek-red focus:outline-none dark:border-slate-700 dark:bg-slate-900 dark:text-white"
            >
        </div>
    </div>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
                <thead class="bg-slate-50 dark:bg-slate-800">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Employee</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Leave Type</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Dates</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Days</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Reason</th>
                        <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    @forelse ($leaveRequests as $request)
                        <tr wire:key="leave-request-{{ $request->id }}" class="hover:bg-slate-50 dark:hover:bg-slate-800/40">
                            <td class="whitespace-nowrap px-5 py-4">
                                <div class="font-medium text-slate-900 dark:text-white">
                                    {{ $request->employee?->user?->name ?? 'Employee #'.$request->employee_id }}
                                </div>
                                <div class="text-xs text-slate-500 dark:text-slate-400">
                                    ID: {{ $request->employee_id }}
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-700 dark:text-slate-300">
                                {{ ucfirst(str_replace('_', ' ', $request->leave_type)) }}
                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-700 dark:text-slate-300">
                                {{ $request->start_date->format('d M Y') }}
                                @if ($request->start_date->toDateString() !== $request->end_date->toDateString())
                                    <span class="text-slate-400">to</span>
                                    {{ $request->end_date->format('d M Y') }}
                                @endif
                            </td>

                            <td class="px-5 py-4 text-right text-sm text-slate-700 dark:text-slate-300">
                                {{ number_format((float) $request->total_days, 2) }}
                            </td>

                            <td class="max-w-xs px-5 py-4 text-sm text-slate-600 dark:text-slate-400">
                                <span class="line-clamp-2">
                                    {{ $request->reason ?: '—' }}
                                </span>
                            </td>

                            <td class="px-5 py-4 text-center">
                                @php
                                    $statusClasses = match ($request->status) {
                                        'approved' => 'bg-green-100 text-green-800 dark:bg-green-950 dark:text-green-300',
                                        'rejected' => 'bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-300',
                                        'cancelled' => 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300',
                                        default => 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300',
                                    };
                                @endphp

                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $statusClasses }}">
                                    {{ ucfirst($request->status) }}
                                </span>
                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-right">
                                @if ($request->status === 'pending' && auth()->user()->can('leave-requests.review'))
                                    <button
                                        type="button"
                                        wire:click="openReviewModal({{ $request->id }}, 'approve')"
                                        class="rounded-lg bg-green-600 px-3 py-2 text-xs font-semibold text-white hover:bg-green-700"
                                    >
                                        Approve
                                    </button>

                                    <button
                                        type="button"
                                        wire:click="openReviewModal({{ $request->id }}, 'reject')"
                                        class="ml-1 rounded-lg border border-red-300 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-50 dark:border-red-800 dark:text-red-400 dark:hover:bg-red-950"
                                    >
                                        Reject
                                    </button>
                                @else
                                    <span class="text-xs text-slate-400">—</span>
                                @endif
                            </td>
                        </tr>

                        @if ($request->review_notes)
                            <tr class="bg-slate-50/70 dark:bg-slate-800/20">
                                <td colspan="7" class="px-5 py-2 text-xs text-slate-500 dark:text-slate-400">
                                    <span class="font-semibold">Review notes:</span>
                                    {{ $request->review_notes }}
                                    @if ($request->reviewer)
                                        <span> — {{ $request->reviewer->name }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center">
                                <p class="font-medium text-slate-700 dark:text-slate-300">
                                    No leave requests found
                                </p>
                                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                    Try changing the filters or check again when requests are submitted.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-200 px-5 py-4 dark:border-slate-800">
            {{ $leaveRequests->links() }}
        </div>
    </div>

    @if ($showReviewModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-black/60 p-4">
            <div class="my-auto w-full max-w-lg rounded-xl border border-slate-200 bg-white shadow-xl dark:border-slate-700 dark:bg-slate-900">
                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4 dark:border-slate-800">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
                        {{ $reviewAction === 'approve' ? 'Approve Leave Request' : 'Reject Leave Request' }}
                    </h2>

                    <button
                        type="button"
                        wire:click="closeReviewModal"
                        class="text-2xl leading-none text-slate-400 hover:text-slate-700 dark:hover:text-white"
                        aria-label="Close"
                    >
                        &times;
                    </button>
                </div>

                <form wire:submit="reviewRequest" class="space-y-5 p-6">
                    <p class="text-sm text-slate-600 dark:text-slate-400">
                        @if ($reviewAction === 'approve')
                            Confirm approval of this employee's leave request.
                        @else
                            Please confirm rejection of this leave request.
                        @endif
                    </p>

                    <div>
                        <label for="reviewNotes" class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Review Notes
                        </label>

                        <textarea
                            id="reviewNotes"
                            wire:model="reviewNotes"
                            rows="3"
                            placeholder="Optional notes for the employee..."
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-hitek-red focus:outline-none dark:border-slate-700 dark:bg-slate-950 dark:text-white"
                        ></textarea>

                        @error('reviewNotes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3 border-t border-slate-200 pt-4 dark:border-slate-800">
                        <button
                            type="button"
                            wire:click="closeReviewModal"
                            class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="rounded-lg px-4 py-2 text-sm font-semibold text-white disabled:opacity-50 {{ $reviewAction === 'approve' ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700' }}"
                        >
                            <span wire:loading.remove wire:target="reviewRequest">
                                {{ $reviewAction === 'approve' ? 'Confirm Approval' : 'Confirm Rejection' }}
                            </span>
                            <span wire:loading wire:target="reviewRequest">Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
