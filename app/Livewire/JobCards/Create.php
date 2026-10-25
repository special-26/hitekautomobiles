<?php

namespace App\Livewire\JobCards;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\JobCard;
use App\Models\JobCardInsurance;
use App\Models\JobCardInsuranceActivity;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Create extends Component
{
    use Interactions;

    public $customer;

    public $vehicle;

    public $jobCard;

    public $concerns = [];
    public $showConcernModal = false;
    public $newConcern = [
        'description' => '',
        'type' => 'Customer Complaint',
    ];

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

    public $advisorResults = [];

    public function mount($customer = null, $vehicle = null)
    {
        $this->customer = null;

        $this->vehicle = null;

        $this->jobCard = [
            'job_card_no' => 'Auto Generated',
            'advisor' => 'Basant Joshi',
            'source' => 'Walk-in',
            'arrival_date' => now()->format('Y-m-d'),
            'arrival_time' => now()->format('H:i'),
            'expected_delivery' => now()->addDays(3)->format('Y-m-d'),
            'delivery_time' => '17:00',
            'fuel_level' => 'Half',
            'insurance' => false,
            'insurance_company' => null,
            'policy_number' => null,
            'claim_number' => null,
            'odometer' => '',
            'remarks' => '',
        ];

        $this->concerns = [];

        // Preselect customer and vehicle when coming from Vehicle Profile.
        if ($customer) {
            $selectedCustomer = Customer::query()
                ->where('is_active', true)
                ->findOrFail($customer);

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
        }

        if ($vehicle && $this->customer) {
            $selectedVehicle = Vehicle::query()
                ->where('id', $vehicle)
                ->where('customer_id', $this->customer['id'])
                ->where('is_active', true)
                ->findOrFail($vehicle);

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
            $this->jobCard['odometer'] = $selectedVehicle->current_odometer;
        }

        // $this->loadAdvisors();
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

        $this->toast()
            ->position('top-center')
            ->success('Success', 'Vehicle added successfully.')
            ->send();
    }
    public function clearVehicle()
    {
        $this->vehicle = null;

        $this->vehicleSearch = '';
        $this->vehicleResults = [];

        $this->jobCard['odometer'] = '';
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

    // Load Advisor
    public function loadAdvisors()
    {
        $this->advisorResults = Employee::query()
            ->where('status', 'active')
            ->whereHas('user')
            ->with('user:id,name')
            ->get()
            ->map(function ($employee) {
                return [
                    'id' => $employee->id,
                    'name' => $employee->user->name,
                ];
            })
            ->toArray();
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
    public function confirmClearCustomer()
    {
        $this->dialog()
            ->question('Warning!', 'Changing the customer will also clear the selected vehicle. Continue?')
            ->confirm('Confirm', 'clearCustomer')
            ->cancel('Cancel')
            ->send();
    }
    public function clearCustomer()
    {
        $this->customer = null;

        $this->customerSearch = '';
        $this->customerResults = [];

        // Vehicle belongs to the selected customer,
        // so clear it as well.
        $this->vehicle = null;
        $this->vehicleSearch = '';
        $this->vehicleResults = [];
    }

    public function openConcernModal()
    {
        $this->resetConcernForm();
        $this->showConcernModal = true;
    }

    public function closeConcernModal()
    {
        $this->showConcernModal = false;
    }

    protected function resetConcernForm()
    {
        $this->newConcern = [
            'description' => '',
            'type' => 'Customer Complaint',
        ];
    }

    public function addConcern()
    {
        $validated = $this->validate([
            'newConcern.description' => ['required', 'string', 'max:1000'],
            'newConcern.type' => ['required', 'string', 'max:100'],
        ]);

        $this->concerns[] = [
            'id' => count($this->concerns) + 1,
            'description' => trim($validated['newConcern']['description']),
            'type' => $validated['newConcern']['type'],
        ];

        $this->closeConcernModal();
        $this->resetConcernForm();
    }

    public function removeConcern($index)
    {
        unset($this->concerns[$index]);

        $this->concerns = array_values($this->concerns);
    }

    public function saveDraft()
    {
        $this->validateCreateForm();

        $jobCard = $this->createJobCard('draft');

        $this->toast()
            ->position('top-center')
            ->success('Job Card Created', 'Job Card has been saved as draft.')
            ->send();

        return redirect()->route('job-cards.show', $jobCard);
    }

    public function saveAndContinue()
    {
        $this->validateCreateForm();

        $jobCard = $this->createJobCard('pending');

        $this->toast()
            ->position('top-center')
            ->success('Job Card Created', 'Job Card has been created successfully.')
            ->send();

        return redirect()->route('job-cards.tasks', $jobCard);
    }

    protected function createJobCard(string $status): JobCard
    {
        return DB::transaction(function () use ($status) {

            $customer = Customer::query()
                ->where('id', $this->customer['id'])
                ->where('is_active', true)
                ->firstOrFail();

            $vehicle = Vehicle::query()
                ->where('id', $this->vehicle['id'])
                ->where('customer_id', $customer->id)
                ->where('is_active', true)
                ->firstOrFail();

            $arrivedAt = Carbon::parse(
                $this->jobCard['arrival_date'] . ' ' . $this->jobCard['arrival_time']
            );

            $estimatedCompletionAt = Carbon::parse(
                $this->jobCard['expected_delivery'] . ' ' . $this->jobCard['delivery_time']
            );

            $complaint = collect($this->concerns)
                ->map(function ($concern) {
                    return trim($concern['description']);
                })
                ->filter()
                ->implode("\n");

            /*
            * job_card_number is unique.
            * We create the record with a temporary unique number,
            * then replace it with the actual ID-based number.
            */
            $jobCard = JobCard::create([
                'job_card_number' => 'TEMP-' . Str::uuid(),

                'customer_id' => $customer->id,
                'vehicle_id' => $vehicle->id,

                // Coordinator will assign these later.
                'department_id' => null,
                'bay_id' => null,

                // Employees module is not implemented yet.
                'advisor_id' => null,

                'complaint' => $complaint,
                'customer_notes' => filled($this->jobCard['remarks'])
                    ? trim($this->jobCard['remarks'])
                    : null,

                'customer_source' => $this->jobCard['source'],

                'odometer' => $this->jobCard['odometer'],
                'fuel_level' => $this->jobCard['fuel_level'],

                'arrived_at' => $arrivedAt,
                'estimated_completion_at' => $estimatedCompletionAt,

                'estimated_cost' => null,

                'status' => $status,
                'is_active' => true,
            ]);

            $jobCard->update([
                'job_card_number' => 'JC-' . str_pad(
                    $jobCard->id,
                    6,
                    '0',
                    STR_PAD_LEFT
                ),
            ]);

            /*
            * Create insurance record only when insurance
            * was selected on the Job Card.
            */
            if ($this->jobCard['insurance']) {

                $insurance = JobCardInsurance::create([
                    'job_card_id' => $jobCard->id,

                    'insurance_company' => filled($this->jobCard['insurance_company'])
                        ? trim($this->jobCard['insurance_company'])
                        : null,

                    'policy_number' => filled($this->jobCard['policy_number'])
                        ? trim($this->jobCard['policy_number'])
                        : null,

                    'claim_number' => filled($this->jobCard['claim_number'])
                        ? trim($this->jobCard['claim_number'])
                        : null,

                    'claim_status' => 'pending',
                    'cashless' => false,
                ]);

                JobCardInsuranceActivity::create([
                    'job_card_insurance_id' => $insurance->id,
                    'activity_type' => 'created',
                    'description' => 'Insurance case created with Job Card.',
                    'old_status' => null,
                    'new_status' => 'pending',
                    'created_by' => auth()->id(),
                ]);
            }

            return $jobCard->fresh();
        });
    }

    protected function validateCreateForm()
    {
        $this->validate([
            'customer.id' => [
                'required',
                'integer',
                'exists:customers,id',
            ],

            'vehicle.id' => [
                'required',
                'integer',
                'exists:vehicles,id',
            ],

            'jobCard.advisor' => [
                'required',
                'string',
            ],

            'jobCard.source' => [
                'required',
                'string',
            ],

            'jobCard.arrival_date' => [
                'required',
                'date',
            ],

            'jobCard.arrival_time' => [
                'required',
            ],

            'jobCard.expected_delivery' => [
                'required',
                'date',
            ],

            'jobCard.delivery_time' => [
                'required',
            ],

            'jobCard.odometer' => [
                'required',
                'integer',
                'min:0',
            ],

            'jobCard.fuel_level' => [
                'required',
                'string',
            ],

            'jobCard.insurance' => [
                'boolean',
            ],

            'jobCard.insurance_company' => [
                'nullable',
                'string',
                'max:255',
            ],

            'jobCard.policy_number' => [
                'nullable',
                'string',
                'max:255',
            ],

            'jobCard.claim_number' => [
                'nullable',
                'string',
                'max:255',
            ],

            'concerns' => [
                'required',
                'array',
                'min:1',
            ],

            'concerns.*.description' => [
                'required',
                'string',
            ],

            'concerns.*.type' => [
                'required',
                'string',
            ],
        ]);
    }

    public function render()
    {
        return view('livewire.job-cards.create')
            ->layout('components.layouts.management', [
                'title' => 'Create Job Card',
            ]);
    }
}
