<?php

namespace App\Livewire\ServiceTasks;

use App\Models\Department;
use App\Models\Part;
use App\Models\PartCategory;
use App\Models\ServiceTask;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use TallStackUi\Traits\Interactions;

class Index extends Component
{
    use WithPagination, Interactions;

    public string $search = '';

    public bool $showAddServiceModal = false;

    public string $serviceName = '';
    public string $serviceDepartment = '';
    public string $serviceCategory = '';
    public string $serviceEstimatedTime = '';
    public string $serviceDescription = '';
    public string $serviceInstructions = '';

    public $departments = [];
    public $categories = [];

    public string $partSearch = '';
    public array $partResults = [];
    public array $selectedParts = [];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function mount(): void
    {
        $this->departments = Department::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name'])
            ->toArray();

        $this->categories = PartCategory::query()
            ->orderBy('name')
            ->get(['id', 'name'])
            ->toArray();
    }

    public function updatedPartSearch(): void
    {
        if (strlen(trim($this->partSearch)) < 2) {
            $this->partResults = [];

            return;
        }

        $search = '%' . trim($this->partSearch) . '%';

        $this->partResults = Part::query()
            ->where('is_active', true)
            ->where(function ($query) use ($search) {
                $query->where('name', 'ilike', $search)
                    ->orWhere('part_number', 'ilike', $search)
                    ->orWhere('brand', 'ilike', $search);
            })
            ->orderBy('name')
            ->limit(10)
            ->get([
                'id',
                'part_number',
                'name',
                'brand',
                'unit',
                'current_stock',
            ])
            ->toArray();
    }

    public function addPart(int $partId): void
    {
        $part = \App\Models\Part::query()
            ->where('is_active', true)
            ->findOrFail($partId);

        foreach ($this->selectedParts as $selectedPart) {
            if ($selectedPart['id'] === $part->id) {
                return;
            }
        }

        $this->selectedParts[] = [
            'id' => $part->id,
            'part_number' => $part->part_number,
            'name' => $part->name,
            'brand' => $part->brand,
            'unit' => $part->unit,
            'quantity' => 1,
            'is_required' => true,
        ];

        $this->partSearch = '';
        $this->partResults = [];
    }

    public function removePart(int $index): void
    {
        unset($this->selectedParts[$index]);

        $this->selectedParts = array_values($this->selectedParts);
    }

    public function saveService(): void
    {
        $validated = $this->validate([
            'serviceName' => ['required', 'string', 'max:255'],
            'serviceDepartment' => ['required', 'exists:departments,id'],
            'serviceCategory' => ['nullable', 'exists:part_categories,id'],
            'serviceEstimatedTime' => ['nullable', 'integer', 'min:1'],
            'serviceDescription' => ['nullable', 'string'],
            'serviceInstructions' => ['nullable', 'string'],
        ]);

        foreach ($this->selectedParts as $part) {
            if (
                empty($part['id']) ||
                ! is_numeric($part['quantity']) ||
                (int) $part['quantity'] < 1
            ) {
                $this->addError(
                    'selectedParts',
                    'Please check the selected parts and quantities.'
                );

                return;
            }
        }

        DB::transaction(function () use ($validated) {

            $serviceTask = ServiceTask::create([
                'name' => $validated['serviceName'],
                'slug' => Str::slug($validated['serviceName']),
                'part_category_id' => $validated['serviceCategory'] ?: null,
                'department_id' => $validated['serviceDepartment'],
                'description' => $validated['serviceDescription'] ?: null,
                'instructions' => $validated['serviceInstructions'] ?: null,
                'estimated_minutes' => $validated['serviceEstimatedTime']
                    ? (int) $validated['serviceEstimatedTime']
                    : null,
                'is_active' => true,
            ]);

            foreach ($this->selectedParts as $part) {
                $serviceTask->taskParts()->create([
                    'part_id' => (int) $part['id'],
                    'default_quantity' => (int) $part['quantity'],
                    'is_required' => (bool) $part['is_required'],
                ]);
            }
        });

        $this->resetServiceForm();

        $this->showAddServiceModal = false;

        // session()->flash(
        //     'success',
        //     'Service task created successfully.'
        // );
        $this->toast()->success('Service task created successfully.')->send();
    }

    private function resetServiceForm(): void
    {
        $this->serviceName = '';
        $this->serviceDepartment = '';
        $this->serviceCategory = '';
        $this->serviceEstimatedTime = '';
        $this->serviceDescription = '';
        $this->serviceInstructions = '';

        $this->partSearch = '';
        $this->partResults = [];
        $this->selectedParts = [];
    }

    public function render()
    {
        $serviceTasks = ServiceTask::query()
            ->with([
                'category:id,name',
                'department:id,name',
            ])
            ->withCount('taskParts')
            ->when($this->search, function ($query) {
                $search = '%' . $this->search . '%';

                $query->where(function ($query) use ($search) {
                    $query->where('name', 'ilike', $search)
                        ->orWhere('slug', 'ilike', $search)
                        ->orWhereHas('category', function ($query) use ($search) {
                            $query->where('name', 'ilike', $search);
                        })
                        ->orWhereHas('department', function ($query) use ($search) {
                            $query->where('name', 'ilike', $search);
                        });
                });
            })
            ->latest('id')
            ->paginate(20);

        return view('livewire.service-tasks.index', [
            'serviceTasks' => $serviceTasks,
        ])->layout('components.layouts.management', [
            'title' => 'Service Tasks',
        ]);
    }
}
