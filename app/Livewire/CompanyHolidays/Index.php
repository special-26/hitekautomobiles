<?php

namespace App\Livewire\CompanyHolidays;

use App\Models\CompanyHoliday;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public bool $showModal = false;
    public ?int $editingHolidayId = null;

    public string $name = '';
    public string $holiday_date = '';
    public bool $is_paid = true;
    public string $notes = '';

    public string $search = '';
    public string $year = '';

    public function mount(): void
    {
        Gate::authorize('company-holidays.view');

        $this->year = now()->year;
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedYear(): void
    {
        $this->resetPage();
    }

    public function openCreateModal(): void
    {
        Gate::authorize('company-holidays.manage');

        $this->resetForm();
        $this->showModal = true;
    }

    public function openEditModal(int $holidayId): void
    {
        Gate::authorize('company-holidays.manage');

        $holiday = CompanyHoliday::findOrFail($holidayId);

        $this->editingHolidayId = $holiday->id;
        $this->name = $holiday->name;
        $this->holiday_date = $holiday->holiday_date->format('Y-m-d');
        $this->is_paid = $holiday->is_paid;
        $this->notes = $holiday->notes ?? '';

        $this->resetValidation();
        $this->showModal = true;
    }

    public function save(): void
    {
        Gate::authorize('company-holidays.manage');

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'holiday_date' => [
                'required',
                'date',
                Rule::unique('company_holidays', 'holiday_date')
                    ->ignore($this->editingHolidayId),
            ],
            'is_paid' => ['required', 'boolean'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $data = [
            'name' => trim($this->name),
            'holiday_date' => $this->holiday_date,
            'is_paid' => $this->is_paid,
            'notes' => $this->notes ?: null,
        ];

        if ($this->editingHolidayId) {
            CompanyHoliday::findOrFail($this->editingHolidayId)
                ->update($data);

            session()->flash('success', 'Holiday updated successfully.');
        } else {
            $data['created_by'] = auth()->id();

            CompanyHoliday::create($data);

            session()->flash('success', 'Holiday added successfully.');
        }

        $this->closeModal();
        $this->resetPage();
    }

    public function delete(int $holidayId): void
    {
        Gate::authorize('company-holidays.manage');

        CompanyHoliday::findOrFail($holidayId)->delete();

        session()->flash('success', 'Holiday deleted successfully.');
        $this->resetPage();
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->reset([
            'editingHolidayId',
            'name',
            'holiday_date',
            'notes',
        ]);

        $this->is_paid = true;
        $this->resetValidation();
    }

    public function render()
    {
        $holidays = CompanyHoliday::query()
            ->when(
                $this->year !== '',
                fn($query) =>
                $query->whereYear('holiday_date', $this->year)
            )
            ->when(
                $this->search !== '',
                fn($query) =>
                $query->where('name', 'like', '%' . trim($this->search) . '%')
            )
            ->orderBy('holiday_date')
            ->paginate(10);

        return view('livewire.company-holidays.index', [
            'holidays' => $holidays,
        ])->layout('components.layouts.management');
    }
}
