<?php

namespace App\Livewire\JobCards;

use App\Models\Customer;
use App\Models\Vehicle;
use Illuminate\Support\Str;
use Livewire\Component;

class Create extends Component
{
    public $customer;

    public $vehicle;

    public $jobCard;

    public $concerns = [];

    public $customerSearch = '';
    public $customerResults = [];
    public $showCustomerModal = false;
    public $newCustomer = [
        'name' => '',
        'phone' => '',
        'email' => '',
        'address' => '',
        'city' => '',
        'state' => '',
        'pincode' => '',
        'date_of_birth' => '',
    ];

    public $vehicleSearch = '';
    public $vehicleResults = [];
    public $showVehicleModal = false;
    public $newVehicle = [
        'registration_number' => '',
        'make' => '',
        'model' => '',
        'variant' => '',
        'fuel_type' => '',
        'manufacturing_year' => '',
        'color' => '',
        'vin' => '',
        'engine_number' => '',
        'current_odometer' => '',
    ];

    public function mount()
    {
        $this->customer = [
            'id' => 101,
            'name' => 'Mrs. Indu Narula',
            'mobile' => '9256681776',
            'email' => 'indu.narula@example.com',
            'address' => 'Sector 17, Chandigarh',
        ];

        $this->vehicle = [
            'id' => 201,
            'registration_no' => 'CH01BT9020',
            'make' => 'Hyundai',
            'model' => 'Creta 1.6',
            'year' => '2021',
            'fuel_type' => 'Petrol',
            'colour' => 'White',
            'km' => '138884',
        ];

        $this->jobCard = [
            'job_card_no' => 'Auto Generated',
            'advisor' => 'Basant Joshi',
            'source' => 'Walk-in',
            'arrival_date' => '2026-09-23',
            'arrival_time' => '09:15',
            'expected_delivery' => '2026-09-26',
            'delivery_time' => '17:00',
            'fuel_level' => 'Half',
            'insurance' => false,
            'insurance_company' => null,
            'policy_number' => null,
            'claim_number' => null,
            'odometer' => '138884',
            'remarks' => '',
        ];

        $this->concerns = [
            [
                'id' => 1,
                'description' => 'Periodic service required',
                'type' => 'Service',
            ],
            [
                'id' => 2,
                'description' => 'Brake noise while driving',
                'type' => 'Customer Complaint',
            ],
        ];
    }

    public function updatedCustomerSearch()
    {
        $search = trim($this->customerSearch);

        if ($search === '') {
            $this->customerResults = [];

            return;
        }

        $this->customerResults = Customer::query()
            ->where('is_active', true)
            ->where(function ($query) use ($search) {
                $query->where('name', 'ilike', "%{$search}%")
                    ->orWhere('phone', 'ilike', "%{$search}%");
            })
            ->orderBy('name')
            ->limit(10)
            ->get([
                'id',
                'name',
                'phone',
                'email',
                'address',
                'city',
                'state',
            ])
            ->toArray();
    }

    public function selectCustomer($customerId)
    {
        $selectedCustomer = Customer::query()
            ->where('is_active', true)
            ->findOrFail($customerId);

        $this->customer = [
            'id' => $selectedCustomer->id,
            'name' => $selectedCustomer->name,
            'mobile' => $selectedCustomer->phone,
            'email' => $selectedCustomer->email,
            'address' => collect([
                $selectedCustomer->address,
                $selectedCustomer->city,
                $selectedCustomer->state,
                $selectedCustomer->pincode,
            ])->filter()->implode(', '),
        ];

        $this->customerSearch = $selectedCustomer->name;
        $this->customerResults = [];

        // Reset vehicle selection when customer changes.
        $this->vehicle = null;
        $this->vehicleSearch = '';
        $this->vehicleResults = [];
    }

    public function openVehicleModal()
    {
        if (!$this->customer) {
            return;
        }

        $this->resetVehicleForm();

        $this->showVehicleModal = true;
    }

    public function closeVehicleModal()
    {
        $this->showVehicleModal = false;
    }

    protected function resetVehicleForm()
    {
        $this->newVehicle = [
            'registration_number' => '',
            'make' => '',
            'model' => '',
            'variant' => '',
            'fuel_type' => '',
            'manufacturing_year' => '',
            'color' => '',
            'vin' => '',
            'engine_number' => '',
            'current_odometer' => '',
        ];
    }

    public function updatedVehicleSearch()
    {
        $search = trim($this->vehicleSearch);

        if (!$this->customer || !$this->customer['id'] || $search === '') {
            $this->vehicleResults = [];

            return;
        }

        $this->vehicleResults = Vehicle::query()
            ->where('customer_id', $this->customer['id'])
            ->where('is_active', true)
            ->where(function ($query) use ($search) {
                $query->where('registration_number', 'ilike', "%{$search}%")
                    ->orWhere('make', 'ilike', "%{$search}%")
                    ->orWhere('model', 'ilike', "%{$search}%");
            })
            ->orderBy('registration_number')
            ->limit(10)
            ->get([
                'id',
                'registration_number',
                'make',
                'model',
                'variant',
                'fuel_type',
                'manufacturing_year',
                'color',
                'current_odometer',
            ])
            ->toArray();
    }

    public function selectVehicle($vehicleId)
    {
        $selectedVehicle = Vehicle::query()
            ->where('customer_id', $this->customer['id'])
            ->where('is_active', true)
            ->findOrFail($vehicleId);

        $this->vehicle = [
            'id' => $selectedVehicle->id,
            'registration_no' => $selectedVehicle->registration_number,
            'make' => $selectedVehicle->make,
            'model' => $selectedVehicle->model,
            'variant' => $selectedVehicle->variant,
            'year' => $selectedVehicle->manufacturing_year,
            'fuel_type' => $selectedVehicle->fuel_type,
            'colour' => $selectedVehicle->color,
            'km' => $selectedVehicle->current_odometer,
        ];

        $this->vehicleSearch = $selectedVehicle->registration_number;
        $this->vehicleResults = [];

        // Use the vehicle's latest odometer reading as the initial job-card reading.
        $this->jobCard['odometer'] = $selectedVehicle->current_odometer;
    }

    public function createVehicle()
    {
        if (!$this->customer) {
            return;
        }

        $validated = $this->validate([
            'newVehicle.registration_number' => ['required', 'string', 'max:255', 'unique:vehicles,registration_number'],
            'newVehicle.make' => ['required', 'string', 'max:255'],
            'newVehicle.model' => ['required', 'string', 'max:255'],
            'newVehicle.variant' => ['nullable', 'string', 'max:255'],
            'newVehicle.fuel_type' => ['nullable', 'string', 'max:255'],
            'newVehicle.manufacturing_year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'newVehicle.color' => ['nullable', 'string', 'max:255'],
            'newVehicle.vin' => ['nullable', 'string', 'max:255', 'unique:vehicles,vin'],
            'newVehicle.engine_number' => ['nullable', 'string', 'max:255', 'unique:vehicles,engine_number'],
            'newVehicle.current_odometer' => ['nullable', 'integer', 'min:0'],
        ]);

        $newVehicle = Vehicle::create([
            'customer_id' => $this->customer['id'],
            'registration_number' => strtoupper(trim($validated['newVehicle']['registration_number'])),
            'make' => trim($validated['newVehicle']['make']),
            'model' => trim($validated['newVehicle']['model']),
            'variant' => $validated['newVehicle']['variant'] ?: null,
            'fuel_type' => $validated['newVehicle']['fuel_type'] ?: null,
            'manufacturing_year' => $validated['newVehicle']['manufacturing_year'] ?: null,
            'color' => $validated['newVehicle']['color'] ?: null,
            'vin' => $validated['newVehicle']['vin']
                ? strtoupper(trim($validated['newVehicle']['vin']))
                : null,
            'engine_number' => $validated['newVehicle']['engine_number']
                ? strtoupper(trim($validated['newVehicle']['engine_number']))
                : null,
            'current_odometer' => $validated['newVehicle']['current_odometer'] ?: null,
            'is_active' => true,
        ]);

        $this->vehicle = [
            'id' => $newVehicle->id,
            'registration_no' => $newVehicle->registration_number,
            'make' => $newVehicle->make,
            'model' => $newVehicle->model,
            'variant' => $newVehicle->variant,
            'year' => $newVehicle->manufacturing_year,
            'fuel_type' => $newVehicle->fuel_type,
            'colour' => $newVehicle->color,
            'km' => $newVehicle->current_odometer,
        ];

        $this->vehicleSearch = $newVehicle->registration_number;
        $this->vehicleResults = [];

        $this->jobCard['odometer'] = $newVehicle->current_odometer;

        $this->showVehicleModal = false;

        $this->resetVehicleForm();

        $this->dispatch(
            'notify',
            type: 'success',
            heading: 'New Vehicle',
            text: 'Vehicle added successfully.'
        );
    }

    public function openCustomerModal()
    {
        $this->resetCustomerForm();
        $this->showCustomerModal = true;
    }

    public function closeCustomerModal()
    {
        $this->showCustomerModal = false;
    }

    protected function resetCustomerForm()
    {
        $this->newCustomer = [
            'name' => '',
            'phone' => '',
            'email' => '',
            'address' => '',
            'city' => '',
            'state' => '',
            'pincode' => '',
            'date_of_birth' => '',
        ];
    }
    public function createCustomer()
    {
        $validated = $this->validate([
            'newCustomer.name' => ['required', 'string', 'max:255'],
            'newCustomer.phone' => ['required', 'string', 'max:255'],
            'newCustomer.email' => ['nullable', 'email', 'max:255'],
            'newCustomer.address' => ['nullable', 'string'],
            'newCustomer.city' => ['nullable', 'string', 'max:255'],
            'newCustomer.state' => ['nullable', 'string', 'max:255'],
            'newCustomer.pincode' => ['nullable', 'string', 'max:255'],
            'newCustomer.date_of_birth' => ['nullable', 'date'],
        ]);

        $customer = Customer::create([
            'name' => trim($validated['newCustomer']['name']),
            'phone' => trim($validated['newCustomer']['phone']),
            'email' => $validated['newCustomer']['email']
                ? trim($validated['newCustomer']['email'])
                : null,
            'address' => $validated['newCustomer']['address']
                ? trim($validated['newCustomer']['address'])
                : null,
            'city' => $validated['newCustomer']['city']
                ? trim($validated['newCustomer']['city'])
                : null,
            'state' => $validated['newCustomer']['state']
                ? trim($validated['newCustomer']['state'])
                : null,
            'pincode' => $validated['newCustomer']['pincode']
                ? trim($validated['newCustomer']['pincode'])
                : null,
            'date_of_birth' => $validated['newCustomer']['date_of_birth'] ?: null,
            'customer_code' => 'CUS-' . strtoupper(uniqid()),
            'public_token' => Str::random(64),
            'is_active' => true,
        ]);

        $this->customer = [
            'id' => $customer->id,
            'name' => $customer->name,
            'mobile' => $customer->phone,
            'email' => $customer->email,
            'address' => collect([
                $customer->address,
                $customer->city,
                $customer->state,
                $customer->pincode,
            ])->filter()->implode(', '),
        ];

        $this->customerSearch = $customer->name;
        $this->customerResults = [];

        $this->vehicle = null;
        $this->vehicleSearch = '';
        $this->vehicleResults = [];

        $this->showCustomerModal = false;
        $this->resetCustomerForm();

        $this->dispatch(
            'notify',
            type: 'success',
            heading: 'New Customer',
            text: 'Customer added successfully.'
        );
    }

    public function render()
    {
        return view('livewire.job-cards.create')
            ->layout('components.layouts.management', [
                'title' => 'Create Job Card',
            ]);
    }
}
