<?php

namespace App\Livewire;

use App\Models\ServiceBooking;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ServiceSlotBooking extends Component
{
    public string $service_date = '';
    public ?string $slot_key = null;

    public string $customer_name = '';
    public string $phone = '';
    public ?string $email = null;

    public ?string $car_make = null;
    public ?string $car_model = null;
    public ?string $car_number = null;

    public ?string $service_type = null;
    public ?string $notes = null;

    public array $availableSlots = [];
    public string $successMessage = '';

    public function mount(): void{
        $tz = config('service_slots.timezone');
        $this->service_date = Carbon::now($tz)->toDateString();
        $this->refreshSlots();
    }

    public function updatedServiceDate(): void{
        $this->slot_key = null;
        $this->successMessage = '';
        $this->refreshSlots();
    }

    private function refreshSlots(): void {
        $this->availableSlots = $this->getAvailableSlotsForDate($this->service_date);
    }

    private function getAvailableSlotsForDate(string $date): array
    {
        $allSlots = config('service_slots.slots');
        $tz = config('service_slots.timezone');

        $booked = ServiceBooking::query()
            ->whereDate('service_date', $date)
            ->where('status', '!=', 'cancelled')
            ->pluck('slot_key')
            ->all();

        $available = array_values(array_diff($allSlots, $booked));

        // Hide past slots if booking date is today
        $today = Carbon::now($tz)->toDateString();
        if ($date === $today) {
            $now = Carbon::now($tz);
            $available = array_values(array_filter($available, function ($slot) use ($date, $now, $tz) {
                [$start] = explode('-', $slot);
                $startAt = Carbon::createFromFormat('Y-m-d H:i', "$date $start", $tz);
                return $startAt->greaterThan($now);
            }));
        }

        return $available;
    }

    public function book(): void
    {
        $this->resetErrorBag();
        $this->successMessage = '';

        $this->validate([
            'service_date' => ['required', 'date', 'after_or_equal:today'],
            'slot_key' => ['required', Rule::in(config('service_slots.slots'))],

            'customer_name' => ['required', 'string', 'max:80'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:120'],

            'car_make' => ['nullable', 'string', 'max:60'],
            'car_model' => ['nullable', 'string', 'max:60'],
            'car_number' => ['nullable', 'string', 'max:30'],
            'service_type' => ['nullable', 'string', 'max:60'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        // Server-side availability check (critical)
        $available = $this->getAvailableSlotsForDate($this->service_date);
        if (!in_array($this->slot_key, $available, true)) {
            $this->addError('slot_key', 'This slot is no longer available. Please choose another slot.');
            $this->refreshSlots();
            return;
        }

        try {
            ServiceBooking::create([
                'service_date' => $this->service_date,
                'slot_key' => $this->slot_key,

                'customer_name' => $this->customer_name,
                'phone' => $this->phone,
                'email' => $this->email,

                'car_make' => $this->car_make,
                'car_model' => $this->car_model,
                'car_number' => $this->car_number,

                'service_type' => $this->service_type,
                'notes' => $this->notes,

                'status' => 'confirmed',
            ]);
        } catch (QueryException $e) {
            // Unique constraint hit = someone booked same slot at same time
            $this->addError('slot_key', 'Someone just booked this slot. Please pick another one.');
            $this->refreshSlots();
            return;
        }

        $this->successMessage = 'Booking confirmed! We will contact you shortly.';
        $this->reset(['slot_key', 'customer_name', 'phone', 'email', 'car_make', 'car_model', 'car_number', 'service_type', 'notes']);
        $this->refreshSlots();
    }


    public function render()
    {
        return view('livewire.service-slot-booking');
    }
}
