<?php

namespace App\Livewire\Bays;

use App\Models\Bay;
use App\Models\Department;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $department = '';
    public string $status = '';

    public bool $showAddBayModal = false;
    public string $bayName = '';
    public string $bayCode = '';
    public string $bayDepartment = '';
    public string $bayType = '';
    public bool $bayIsActive = true;

    public bool $showEditBayModal = false;
    public ?int $editingBayId = null;
    public string $editBayName = '';
    public string $editBayCode = '';
    public string $editBayDepartment = '';
    public string $editBayType = '';
    public bool $editBayIsActive = true;

    public bool $showStatusModal = false;
    public ?int $statusBayId = null;
    public string $statusBayName = '';
    public bool $statusBayCurrentState = true;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedDepartment(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function saveBay(): void
    {
        $validated = $this->validate([
            'bayName' => ['required', 'string', 'max:100'],
            'bayCode' => ['required', 'string', 'max:50', 'unique:bays,code'],
            'bayDepartment' => ['required', 'integer', 'exists:departments,id'],
            'bayType' => ['required', 'string', 'max:100'],
            'bayIsActive' => ['boolean'],
        ]);

        Bay::create([
            'name' => $validated['bayName'],
            'code' => strtoupper(trim($validated['bayCode'])),
            'department_id' => $validated['bayDepartment'],
            'type' => $validated['bayType'],
            'is_active' => $validated['bayIsActive'],
        ]);

        $this->resetBayForm();

        $this->showAddBayModal = false;

        session()->flash('success', 'Bay created successfully.');
    }

    private function resetBayForm(): void
    {
        $this->bayName = '';
        $this->bayCode = '';
        $this->bayDepartment = '';
        $this->bayType = '';
        $this->bayIsActive = true;

        $this->resetValidation();
    }

    public function editBay(int $bayId): void
    {
        $bay = Bay::findOrFail($bayId);

        $this->editingBayId = $bay->id;
        $this->editBayName = $bay->name;
        $this->editBayCode = $bay->code;
        $this->editBayDepartment = (string) $bay->department_id;
        $this->editBayType = $bay->type;
        $this->editBayIsActive = $bay->is_active;

        $this->resetValidation();

        $this->showEditBayModal = true;
    }
    public function updateBay(): void
    {
        $validated = $this->validate([
            'editBayName' => ['required', 'string', 'max:100'],
            'editBayCode' => [
                'required',
                'string',
                'max:50',
                Rule::unique('bays', 'code')->ignore($this->editingBayId),
            ],
            'editBayDepartment' => [
                'required',
                'integer',
                'exists:departments,id',
            ],
            'editBayType' => ['required', 'string', 'max:100'],
            'editBayIsActive' => ['boolean'],
        ]);

        $bay = Bay::findOrFail($this->editingBayId);

        $bay->update([
            'name' => $validated['editBayName'],
            'code' => strtoupper(trim($validated['editBayCode'])),
            'department_id' => $validated['editBayDepartment'],
            'type' => $validated['editBayType'],
            'is_active' => $validated['editBayIsActive'],
        ]);

        $this->resetEditBayForm();

        $this->showEditBayModal = false;

        session()->flash('success', 'Bay updated successfully.');
    }
    private function resetEditBayForm(): void
    {
        $this->editingBayId = null;
        $this->editBayName = '';
        $this->editBayCode = '';
        $this->editBayDepartment = '';
        $this->editBayType = '';
        $this->editBayIsActive = true;

        $this->resetValidation();
    }

    // Status
    public function confirmBayStatus(int $bayId): void
    {
        $bay = Bay::findOrFail($bayId);

        $this->statusBayId = $bay->id;
        $this->statusBayName = $bay->name;
        $this->statusBayCurrentState = $bay->is_active;

        $this->resetValidation();

        $this->showStatusModal = true;
    }
    public function updateBayStatus(): void
    {
        $bay = Bay::findOrFail($this->statusBayId);

        $bay->update([
            'is_active' => ! $bay->is_active,
        ]);

        $this->resetStatusForm();

        $this->showStatusModal = false;

        session()->flash(
            'success',
            'Bay status updated successfully.'
        );
    }
    private function resetStatusForm(): void
    {
        $this->statusBayId = null;
        $this->statusBayName = '';
        $this->statusBayCurrentState = true;

        $this->resetValidation();
    }

    public function render()
    {
        $bays = Bay::query()
            ->with('department:id,name')
            ->when($this->search, function ($query) {
                $search = '%' . trim($this->search) . '%';

                $query->where(function ($query) use ($search) {
                    $query->where('name', 'ilike', $search)
                        ->orWhere('code', 'ilike', $search)
                        ->orWhere('type', 'ilike', $search);
                });
            })
            ->when($this->department, function ($query) {
                $query->where('department_id', $this->department);
            })
            ->when($this->status !== '', function ($query) {
                $query->where('is_active', $this->status === 'active');
            })
            ->orderBy('name')
            ->paginate(20);

        $departments = Department::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('livewire.bays.index', [
            'bays' => $bays,
            'departments' => $departments,
        ])->layout('components.layouts.management', [
            'title' => 'Bays',
        ]);
    }
}
