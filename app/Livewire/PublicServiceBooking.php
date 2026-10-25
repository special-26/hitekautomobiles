<?php

namespace App\Livewire;

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

    public bool $submitted = false;

    public function mount(): void
    {
        $this->preferredDate = now()->toDateString();
    }

    public function updatedServiceCategory(): void
    {
        $this->resetValidation('serviceCategory');
    }

    protected function rules(): array
    {
        return [
            'customerName' => ['required', 'string', 'min:2', 'max:100'],
            'phone' => ['required', 'regex:/^[6-9][0-9]{9}$/'],
            'email' => ['nullable', 'email', 'max:150'],

            'vehicleMake' => ['required', 'string', 'max:80'],
            'vehicleModel' => ['required', 'string', 'max:100'],
            'registrationNumber' => [
                'nullable',
                'string',
                'max:20',
            ],

            'serviceCategory' => [
                'required',
                'in:regular-service,denting-painting,car-washing,detailing,ceramic-coating,ppf,insurance,other',
            ],
            'serviceDetails' => ['nullable', 'string', 'max:1500'],

            'preferredDate' => [
                'required',
                'date',
                'after_or_equal:today',
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
            'customerName.required' => 'Please enter your name.',
            'phone.required' => 'Please enter your mobile number.',
            'phone.regex' => 'Enter a valid 10-digit Indian mobile number.',
            'vehicleMake.required' => 'Please select or enter your car make.',
            'vehicleModel.required' => 'Please enter your car model.',
            'serviceCategory.required' => 'Please select a service.',
            'preferredDate.after_or_equal' => 'Please select today or a future date.',
            'preferredTime.required' => 'Please select your preferred time.',
        ];
    }

    public function submit(): void
    {
        $this->validate();

        /*
         * Next step:
         * Check actual slot availability, create the booking in the
         * database inside a transaction, and generate a booking reference.
         *
         * Do not mark the booking as confirmed until that is implemented.
         */

        $this->submitted = false;

        $this->dispatch(
            'booking-details-validated',
            message: 'Your details are valid. Booking confirmation will be available once database saving and slot verification are connected.'
        );
    }

    public function render()
    {
        return view('livewire.public-service-booking')
            ->layout('layouts.app');
    }
}
