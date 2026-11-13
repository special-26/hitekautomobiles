
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Service Bookings</h1>
            <p class="mt-1 text-sm text-slate-500">
                Manage customer service appointments and review booking details.
            </p>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Total Bookings</p>
                <div class="rounded-lg bg-slate-100 p-2 text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"><!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE --><path fill="currentColor" d="M5 22q-.825 0-1.412-.587T3 20V6q0-.825.588-1.412T5 4h1V2h2v2h8V2h2v2h1q.825 0 1.413.588T21 6v6.375l-2 2V10H5v10h6.2l2 2zm11.55.5L13 18.95l1.4-1.4l2.125 2.125l4.25-4.25l1.4 1.425z"/></svg>
                </div>
            </div>
            <p class="mt-3 text-2xl font-bold text-slate-900">
                {{ number_format($summary['total']) }}
            </p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Pending</p>
                <div class="rounded-lg bg-amber-50 p-2 text-amber-600">
                    <x-icon name="clock" class="h-5 w-5" outline />
                </div>
            </div>
            <p class="mt-3 text-2xl font-bold text-amber-600">
                {{ number_format($summary['pending']) }}
            </p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Confirmed</p>
                <div class="rounded-lg bg-emerald-50 p-2 text-emerald-600">
                    <x-icon name="check-circle" class="h-5 w-5" outline />
                </div>
            </div>
            <p class="mt-3 text-2xl font-bold text-emerald-600">
                {{ number_format($summary['confirmed']) }}
            </p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Today's Bookings</p>
                <div class="rounded-lg bg-red-50 p-2 text-red-600">
                    <x-icon name="calendar-days" class="h-5 w-5" outline />
                </div>
            </div>
            <p class="mt-3 text-2xl font-bold text-red-600">
                {{ number_format($summary['today']) }}
            </p>
        </div>

    </div>

    {{-- Filters --}}
    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
        <div class="grid grid-cols-1 gap-3 md:grid-cols-2 xl:grid-cols-4">

            <div class="relative">
                <x-icon name="magnifying-glass"
                    class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                    outline />
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search name, phone, reference..."
                    class="w-full rounded-lg border border-slate-200 py-2.5 pl-9 pr-3 text-sm text-slate-900 placeholder:text-slate-400 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100"
                />
            </div>

            <select
                wire:model.live="status"
                class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm text-slate-700 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100"
            >
                <option value="">All statuses</option>
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="completed">Completed</option>
                <option value="rejected">Rejected</option>
                <option value="cancelled">Cancelled</option>
            </select>

            <select
                wire:model.live="dateFilter"
                class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm text-slate-700 focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100"
            >
                <option value="">All dates</option>
                <option value="today">Today</option>
                <option value="tomorrow">Tomorrow</option>
                <option value="upcoming">Upcoming</option>
                <option value="past">Past bookings</option>
            </select>

            <button
                type="button"
                wire:click="$set('search', ''); $set('status', ''); $set('dateFilter', '')"
                class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50"
            >
                Clear filters
            </button>

        </div>
    </div>

    {{-- Booking List --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
            <div>
                <h2 class="font-semibold text-slate-900">Booking Requests</h2>
                <p class="mt-1 text-xs text-slate-500">
                    Review appointments before creating a job card.
                </p>
            </div>

            <span class="text-sm text-slate-500">
                {{ $bookings->total() }} records
            </span>
        </div>

        @if ($bookings->count())
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Booking
                            </th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Customer
                            </th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Service
                            </th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Appointment
                            </th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Pickup / Drop
                            </th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Status
                            </th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 bg-white">
                        @foreach ($bookings as $booking)
                            @php
                                $bookingStatus = strtolower($booking->status ?? 'pending');

                                $statusClasses = match ($bookingStatus) {
                                    'confirmed' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                                    'completed' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
                                    'rejected', 'cancelled' => 'bg-red-50 text-red-700 ring-red-600/20',
                                    default => 'bg-amber-50 text-amber-700 ring-amber-600/20',
                                };
                            @endphp

                            <tr wire:key="service-booking-{{ $booking->id }}"
                                class="transition hover:bg-slate-50/70">

                                {{-- Booking Reference --}}
                                <td class="whitespace-nowrap px-5 py-4 align-top">
                                    <p class="font-semibold text-slate-900">
                                        {{ $booking->booking_reference ?: 'HB-' . str_pad((string) $booking->id, 6, '0', STR_PAD_LEFT) }}
                                    </p>
                                    <p class="mt-1 text-xs text-slate-500">
                                        Received {{ $booking->created_at?->format('d M Y') }}
                                    </p>
                                </td>

                                {{-- Customer Details --}}
                                <td class="px-5 py-4 align-top">
                                    <p class="font-medium text-slate-900">
                                        {{ $booking->customer_name }}
                                    </p>

                                    <a href="tel:{{ $booking->phone }}"
                                       class="mt-1 inline-flex items-center gap-1 text-sm text-slate-600 hover:text-red-600">
                                        <x-icon name="phone" class="h-3.5 w-3.5" outline />
                                        {{ $booking->phone }}
                                    </a>

                                    @if ($booking->email)
                                        <p class="mt-1 text-xs text-slate-500">
                                            {{ $booking->email }}
                                        </p>
                                    @endif
                                </td>

                                {{-- Service Details --}}
                                <td class="px-5 py-4 align-top">
                                    <p class="font-medium text-slate-800">
                                        {{ \Illuminate\Support\Str::headline($booking->service_type ?: 'General Service') }}
                                    </p>

                                    @if ($booking->notes)
                                        <div class="mt-1 max-w-xs text-xs leading-5 text-slate-500"
                                             title="{{ $booking->notes }}">
                                            {{ \Illuminate\Support\Str::limit($booking->notes, 90) }}
                                        </div>
                                    @endif
                                </td>

                                {{-- Appointment --}}
                                <td class="whitespace-nowrap px-5 py-4 align-top">
                                    <div class="flex items-start gap-2">
                                        <x-icon name="calendar-days" class="mt-0.5 h-4 w-4 text-slate-400" outline />
                                        <div>
                                            <p class="font-medium text-slate-800">
                                                {{ $booking->service_date?->format('d M Y') ?? '—' }}
                                            </p>
                                            <p class="mt-1 text-sm text-slate-500">
                                                {{ $booking->slot_key }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Pickup / Drop --}}
                                <td class="px-5 py-4 align-top">
                                    @if ($booking->pickup_drop_required)
                                        <span class="inline-flex items-center rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-medium text-indigo-700">
                                            Required
                                        </span>

                                        @if ($booking->pickup_time)
                                            <p class="mt-2 text-xs text-slate-600">
                                                Time: {{ $booking->pickup_time }}
                                            </p>
                                        @endif

                                        @if ($booking->pickup_address)
                                            <p class="mt-1 max-w-xs text-xs leading-5 text-slate-500"
                                               title="{{ $booking->pickup_address }}">
                                                {{ \Illuminate\Support\Str::limit($booking->pickup_address, 65) }}
                                            </p>
                                        @endif
                                    @else
                                        <span class="text-sm text-slate-400">Not requested</span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td class="whitespace-nowrap px-5 py-4 align-top">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold capitalize ring-1 ring-inset {{ $statusClasses }}">
                                        {{ str_replace('_', ' ', $bookingStatus) }}
                                    </span>
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 align-top">
                                    <div class="flex items-center gap-2">

                                        @if ($booking->status === 'pending')
                                            <button
                                                type="button"
                                                wire:click="confirmBooking({{ $booking->id }})"
                                                wire:loading.attr="disabled"
                                                wire:target="confirmBooking({{ $booking->id }})"
                                                wire:confirm="Confirm this service booking?"
                                                class="rounded-lg bg-emerald-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-emerald-700 disabled:opacity-50"
                                            >
                                                Confirm
                                            </button>
                                        @endif

                                        @if (in_array($booking->status, ['pending', 'confirmed'], true))
                                            <button
                                                type="button"
                                                wire:click="cancelBooking({{ $booking->id }})"
                                                wire:loading.attr="disabled"
                                                wire:target="cancelBooking({{ $booking->id }})"
                                                wire:confirm="Cancel this booking and release its time slot?"
                                                class="rounded-lg border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-50 disabled:opacity-50"
                                            >
                                                Cancel
                                            </button>
                                        @else
                                            @if ($booking->status !== 'pending')
                                                <span class="text-xs text-slate-400">No actions</span>
                                            @endif
                                        @endif

                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="border-t border-slate-200 px-5 py-4">
                {{ $bookings->links() }}
            </div>

        @else
            <div class="px-6 py-16 text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24"><!-- Icon from Lucide by Lucide Contributors - https://github.com/lucide-icons/lucide/blob/main/LICENSE --><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 2v4m8-4v4m5 7V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8M3 10h18m-4 12l5-5m-5 0l5 5"/></svg>
                </div>

                <h3 class="mt-4 text-base font-semibold text-slate-900">
                    No bookings found
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Try changing your search or filters.
                </p>

                <button
                    type="button"
                    wire:click="$set('search', ''); $set('status', ''); $set('dateFilter', '')"
                    class="mt-4 text-sm font-semibold text-red-600 hover:text-red-700"
                >
                    Clear all filters
                </button>
            </div>
        @endif

    </div>

</div>
