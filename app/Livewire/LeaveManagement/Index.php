<?php

namespace App\Livewire\LeaveManagement;

use App\Models\EmployeeLeaveRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = 'pending';
    public string $leaveType = '';
    public string $startDate = '';
    public string $endDate = '';

    public bool $showReviewModal = false;
    public ?int $reviewingRequestId = null;
    public string $reviewAction = '';
    public string $reviewNotes = '';

    public function mount(): void
    {
        Gate::authorize('leave-requests.view');
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function updatedLeaveType(): void
    {
        $this->resetPage();
    }

    public function openReviewModal(int $requestId, string $action): void
    {
        Gate::authorize('leave-requests.review');

        if (!in_array($action, ['approve', 'reject'], true)) {
            throw ValidationException::withMessages([
                'reviewAction' => 'Invalid review action.',
            ]);
        }

        $leaveRequest = EmployeeLeaveRequest::findOrFail($requestId);

        if ($leaveRequest->status !== 'pending') {
            session()->flash('error', 'Only pending requests can be reviewed.');
            return;
        }

        $this->reviewingRequestId = $leaveRequest->id;
        $this->reviewAction = $action;
        $this->reviewNotes = '';
        $this->resetValidation();
        $this->showReviewModal = true;
    }

    public function reviewRequest(): void
    {
        Gate::authorize('leave-requests.review');

        $validated = $this->validate([
            'reviewingRequestId' => [
                'required',
                'integer',
                'exists:employee_leave_requests,id',
            ],
            'reviewAction' => ['required', 'in:approve,reject'],
            'reviewNotes' => ['nullable', 'string', 'max:2000'],
        ]);

        $leaveRequest = EmployeeLeaveRequest::query()
            ->lockForUpdate()
            ->findOrFail($validated['reviewingRequestId']);

        if ($leaveRequest->status !== 'pending') {
            throw ValidationException::withMessages([
                'reviewAction' => 'This request has already been reviewed.',
            ]);
        }

        $leaveRequest->update([
            'status' => $validated['reviewAction'] === 'approve'
                ? 'approved'
                : 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'review_notes' => $validated['reviewNotes'] ?: null,
        ]);

        $this->closeReviewModal();

        session()->flash(
            'success',
            $validated['reviewAction'] === 'approve'
                ? 'Leave request approved successfully.'
                : 'Leave request rejected.'
        );
    }

    public function closeReviewModal(): void
    {
        $this->showReviewModal = false;
        $this->reviewingRequestId = null;
        $this->reviewAction = '';
        $this->reviewNotes = '';
        $this->resetValidation();
    }

    public function render()
    {
        $leaveRequests = EmployeeLeaveRequest::query()
            ->with(['employee.user', 'reviewer'])
            ->when($this->search !== '', function ($query) {
                $search = trim($this->search);

                $query->whereHas('employee.user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%");
                });
            })
            ->when(
                $this->status !== '',
                fn($query) =>
                $query->where('status', $this->status)
            )
            ->when(
                $this->leaveType !== '',
                fn($query) =>
                $query->where('leave_type', $this->leaveType)
            )
            ->when(
                $this->startDate !== '',
                fn($query) =>
                $query->whereDate('start_date', '>=', $this->startDate)
            )
            ->when(
                $this->endDate !== '',
                fn($query) =>
                $query->whereDate('end_date', '<=', $this->endDate)
            )
            ->latest()
            ->paginate(10);

        return view('livewire.leave-management.index', [
            'leaveRequests' => $leaveRequests,
        ])->layout('components.layouts.management');
    }
}
