<?php

namespace App\Livewire\ServiceBookings;

use App\Models\ServiceBooking;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithPagination;
use TallStackUi\Traits\Interactions;

class Index extends Component
{
    use WithPagination, Interactions;

    public string $search = '';
    public string $status = '';
    public string $dateFilter = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function updatedDateFilter(): void
    {
        $this->resetPage();
    }

    public function confirmBooking(int $bookingId): void
    {
        $booking = ServiceBooking::findOrFail($bookingId);

        if ($booking->status !== 'pending') {
            $this->dispatch(
                'booking-action-message',
                message: 'Only pending bookings can be confirmed.'
            );

            return;
        }

        $booking->update([
            'status' => 'confirmed',
        ]);

        $this->toast()
            ->position('top-center')
            ->success('Service Booking', 'Booking confirmed successfully.')
            ->send();
    }

    public function cancelBooking(int $bookingId): void
    {
        DB::transaction(function () use ($bookingId) {
            $booking = ServiceBooking::query()
                ->whereKey($bookingId)
                ->lockForUpdate()
                ->firstOrFail();

            if (! in_array($booking->status, ['pending', 'confirmed'], true)) {
                throw ValidationException::withMessages([
                    'booking' => 'Only pending or confirmed bookings can be cancelled.',
                ]);
            }

            $booking->update([
                'status' => 'cancelled',
            ]);
        });

        $this->toast()
            ->position('top-center')
            ->success('Service Booking', 'Booking cancelled. The time slot is now available.')
            ->send();
    }


    public function render()
    {
        $bookings = ServiceBooking::query()
            ->when($this->search, function ($query) {
                $search = '%' . trim($this->search) . '%';

                $query->where(function ($query) use ($search) {
                    $query->where('booking_reference', 'ilike', $search)
                        ->orWhere('customer_name', 'ilike', $search)
                        ->orWhere('phone', 'ilike', $search)
                        ->orWhere('email', 'ilike', $search)
                        ->orWhere('service_type', 'ilike', $search)
                        ->orWhere('slot_key', 'ilike', $search);
                });
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->dateFilter, function ($query) {
                match ($this->dateFilter) {
                    'today' => $query->whereDate('service_date', today()),

                    'tomorrow' => $query->whereDate(
                        'service_date',
                        today()->addDay()
                    ),

                    'upcoming' => $query->whereDate(
                        'service_date',
                        '>=',
                        today()
                    ),

                    'past' => $query->whereDate(
                        'service_date',
                        '<',
                        today()
                    ),

                    default => null,
                };
            })
            ->orderByDesc('service_date')
            ->orderBy('slot_key')
            ->orderByDesc('id')
            ->paginate(20);

        $summary = [
            'total' => ServiceBooking::count(),

            'pending' => ServiceBooking::where(
                'status',
                'pending'
            )->count(),

            'confirmed' => ServiceBooking::where(
                'status',
                'confirmed'
            )->count(),

            'today' => ServiceBooking::whereDate(
                'service_date',
                today()
            )->whereNotIn('status', [
                'rejected',
                'cancelled',
            ])->count(),
        ];

        return view('livewire.service-bookings.index', [
            'bookings' => $bookings,
            'summary' => $summary,
        ])->layout('components.layouts.management', [
            'title' => 'Service Bookings',
        ]);
    }
}
