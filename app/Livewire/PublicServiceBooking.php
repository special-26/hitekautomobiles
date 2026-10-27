<?php

namespace App\Livewire;

use App\Models\Customer;
use App\Models\ServiceBooking;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class PublicServiceBooking extends Component
{
    public string $customerName = '';
    public string $phone = '';
    public string $email = '';

    public string $vehicleMake = '';
    public string $vehicleModel = '';
    public string $registrationNumber = '';

    public string $serviceCategory = '';
    public string $serviceDetails = '';

    public string $preferredDate = '';
    public string $preferredTime = '';

    public ?string $bookingReference = null;
    public bool $submitted = false;

    public bool $pickupDropRequired = false;
    public string $pickupAddress = '';
    public string $pickupTime = '';

    public function mount(): void
    {
        $this->preferredDate = now()->toDateString();
    }

    public function updatedPreferredDate(): void
    {
        $this->preferredTime = '';

        $this->resetValidation('preferredTime');
    }

    public function updatedPreferredTime(): void
    {
        $this->resetValidation('preferredTime');
    }

    /**
     * Show every configured slot, including booked and unavailable slots.
     */
    public function getSlotOptionsProperty(): array
    {
        if (! $this->preferredDate) {
            return [];
        }

        try {
            $date = Carbon::createFromFormat(
                'Y-m-d',
                $this->preferredDate
            )->startOfDay();
        } catch (\Throwable $e) {
            return [];
        }

        $today = now()->startOfDay();

        $lastBookableDate = now()->addDays(
            (int) config('service_booking.advance_booking_days', 30)
        )->startOfDay();

        if (
            $date->lt($today) ||
            $date->gt($lastBookableDate)
        ) {
            return [];
        }

        $slots = collect(config('service_booking.daily_slots', []))
            ->map(fn($slot) => (string) $slot)
            ->unique()
            ->values();

        $bookedSlots = ServiceBooking::query()
            ->whereDate('service_date', $date->toDateString())
            ->pluck('slot_key')
            ->map(fn($slot) => (string) $slot)
            ->all();

        $minimumNotice = (int) config(
            'service_booking.minimum_notice_minutes',
            60
        );

        return $slots->map(function (string $slot) use (
            $date,
            $bookedSlots,
            $minimumNotice
        ) {
            try {
                $slotDateTime = Carbon::parse(
                    $date->toDateString() . ' ' . $slot
                );
            } catch (\Throwable $e) {
                return [
                    'time' => $slot,
                    'available' => false,
                    'reason' => 'Unavailable',
                ];
            }

            $isBooked = in_array($slot, $bookedSlots, true);

            $meetsNotice = $slotDateTime->gte(
                now()->addMinutes($minimumNotice)
            );

            $available = ! $isBooked && $meetsNotice;

            return [
                'time' => $slot,
                'available' => $available,
                'reason' => $isBooked
                    ? 'Booked'
                    : ($meetsNotice ? 'Available' : 'Unavailable'),
            ];
        })->all();
    }

    /**
     * Available slots only. Keep this for server-side validation.
     */
    public function getAvailableSlotsProperty(): array
    {
        return collect($this->slotOptions)
            ->where('available', true)
            ->pluck('time')
            ->values()
            ->all();
    }


    protected function rules(): array
    {
        return [
            'customerName' => ['required', 'string', 'min:2', 'max:100'],
            'phone' => ['required', 'regex:/^[6-9][0-9]{9}$/'],
            'email' => ['nullable', 'email', 'max:150'],

            'vehicleMake' => ['required', 'string', 'max:255'],
            'vehicleModel' => ['required', 'string', 'max:255'],

            'serviceCategory' => [
                'required',
                'in:regular-service,denting-painting,car-washing,detailing,ceramic-coating,ppf,insurance,other',
            ],

            'pickupDropRequired' => ['required', 'boolean'],
            'pickupAddress' => [
                'nullable',
                'required_if:pickupDropRequired,1',
                'string',
                'max:1000',
            ],
            'pickupTime' => [
                'nullable',
                'required_if:pickupDropRequired,1',
                'date_format:H:i',
            ],

            'serviceDetails' => ['nullable', 'string', 'max:1500'],

            'preferredDate' => [
                'required',
                'date_format:Y-m-d',
                'after_or_equal:today',
                'before_or_equal:' . now()->addDays(
                    (int) config('service_booking.advance_booking_days', 30)
                )->toDateString(),
            ],

            'preferredTime' => [
                'required',
                'date_format:H:i',
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'phone.regex' => 'Enter a valid 10-digit Indian mobile number.',
            'preferredTime.required' => 'Please select an available appointment slot.',
            'preferredDate.before_or_equal' => 'Please select a date within the booking window.',
        ];
    }

    public function submit(): void
    {
        $validated = $this->validate();

        // Check that the selected slot is still available.
        if (! in_array(
            $validated['preferredTime'],
            $this->availableSlots,
            true
        )) {
            $this->preferredTime = '';

            throw ValidationException::withMessages([
                'preferredTime' => 'This slot is no longer available. Please select another time.',
            ]);
        }

        try {
            $booking = ServiceBooking::query()->create([
                'customer_name' => trim($validated['customerName']),
                'phone' => trim($validated['phone']),
                'email' => $validated['email'] ?: null,

                'service_date' => $validated['preferredDate'],
                'slot_key' => $validated['preferredTime'],
                'service_type' => $validated['serviceCategory'],
                'notes' => $validated['serviceDetails'] ?: null,

                'pickup_drop_required' => $this->pickupDropRequired,
                'pickup_address' => $this->pickupDropRequired
                    ? trim($this->pickupAddress)
                    : null,
                'pickup_time' => $this->pickupDropRequired
                    ? $this->pickupTime
                    : null,

                'status' => 'pending',
            ]);

            $this->bookingReference = 'HB-' . str_pad(
                (string) $booking->id,
                6,
                '0',
                STR_PAD_LEFT
            );

            $this->submitted = true;

            // Reset customer, service, pickup and slot selections.
            $this->reset([
                'customerName',
                'phone',
                'email',
                'vehicleMake',
                'vehicleModel',
                'registrationNumber',
                'serviceCategory',
                'serviceDetails',
                'preferredTime',
                'pickupDropRequired',
                'pickupAddress',
                'pickupTime',
            ]);

            // Keep today's date selected.
            $this->preferredDate = now()->toDateString();

            $this->resetValidation();

            $this->submitted = true;
        } catch (QueryException $e) {
            // PostgreSQL unique-constraint violations use SQLSTATE 23505.
            if (
                $e->getCode() === '23505' ||
                str_contains(
                    $e->getMessage(),
                    'uniq_service_date_slot'
                )
            ) {
                $this->preferredTime = '';

                throw ValidationException::withMessages([
                    'preferredTime' => 'That slot was just booked by someone else. Please select another available time.',
                ]);
            }

            throw $e;
        }
    }

    public function render()
    {
        return view('livewire.public-service-booking')
            ->layout('layouts.app');
    }
}
