<?php

use Livewire\Volt\Component;
use App\Models\ServiceBooking;

new class extends Component
{
    public function with(): array
    {
        $customer = auth()->user()->customer;

        return [
            'bookings' => $customer
                ? $customer->serviceBookings()
                    ->with('vehicle')
                    ->latest('service_date')
                    ->latest()
                    ->get()
                : collect(),
        ];
    }

    public function cancelBooking(int $bookingId): void
    {
        $customer = auth()->user()->customer;

        abort_if(!$customer, 404);

        $booking = $customer->serviceBookings()
            ->findOrFail($bookingId);

        if ($booking->status !== 'confirmed') {
            return;
        }

        $booking->update([
            'status' => 'cancelled',
        ]);

        session()->flash(
            'success',
            'Booking cancelled successfully.'
        );
    }
};
?>

<div class="max-w-6xl mx-auto px-4 py-8">

    <div class="flex items-center justify-between mb-6">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                My Bookings
            </h1>

            <p class="mt-1 text-sm text-gray-600">
                View and manage your service bookings.
            </p>
        </div>

        <a
            href="{{ route('customer.book-service') }}"
            class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700"
        >
            Book Service
        </a>

    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if ($bookings->count())

        <div class="space-y-4">

            @foreach ($bookings as $booking)

                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

                    <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">

                        <div>

                            <div class="flex items-center gap-3">

                                <h2 class="text-lg font-semibold text-gray-900">
                                    {{ $booking->service_type ?: 'Service' }}
                                </h2>

                                @if ($booking->status === 'confirmed')
                                    <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                                        Confirmed
                                    </span>
                                @elseif ($booking->status === 'cancelled')
                                    <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700">
                                        Cancelled
                                    </span>
                                @elseif ($booking->status === 'completed')
                                    <span class="rounded-full bg-blue-100 px-2.5 py-1 text-xs font-medium text-blue-700">
                                        Completed
                                    </span>
                                @else
                                    <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-700">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                @endif

                            </div>

                            <p class="mt-1 text-sm text-gray-500">
                                Booking #{{ $booking->id }}
                            </p>

                        </div>

                        @if ($booking->status === 'confirmed')

                            <button
                                type="button"
                                wire:click="cancelBooking({{ $booking->id }})"
                                wire:confirm="Are you sure you want to cancel this booking?"
                                class="text-sm font-medium text-red-600 hover:text-red-800"
                            >
                                Cancel Booking
                            </button>

                        @endif

                    </div>

                    <div class="mt-5 grid grid-cols-1 gap-5 border-t border-gray-100 pt-5 md:grid-cols-3">

                        <div>
                            <p class="text-sm text-gray-500">
                                Vehicle
                            </p>

                            <p class="mt-1 font-medium text-gray-900">
                                {{ $booking->vehicle->registration_number }}
                            </p>

                            <p class="text-sm text-gray-600">
                                {{ $booking->vehicle->make }}
                                {{ $booking->vehicle->model }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">
                                Date
                            </p>

                            <p class="mt-1 font-medium text-gray-900">
                                {{ $booking->service_date->format('d M Y') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">
                                Time
                            </p>

                            <p class="mt-1 font-medium text-gray-900">
                                {{ str_replace('-', ' - ', $booking->slot_key) }}
                            </p>
                        </div>

                    </div>

                    @if ($booking->notes)

                        <div class="mt-5 border-t border-gray-100 pt-5">

                            <p class="text-sm text-gray-500">
                                Notes
                            </p>

                            <p class="mt-1 text-sm text-gray-700">
                                {{ $booking->notes }}
                            </p>

                        </div>

                    @endif

                </div>

            @endforeach

        </div>

    @else

        <div class="rounded-xl border border-dashed border-gray-300 bg-white p-10 text-center">

            <h2 class="text-lg font-semibold text-gray-900">
                No bookings yet
            </h2>

            <p class="mt-2 text-sm text-gray-600">
                You haven't booked a service yet.
            </p>

            <a
                href="{{ route('customer.book-service') }}"
                class="mt-5 inline-block rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-700"
            >
                Book Your First Service
            </a>

        </div>

    @endif

</div>