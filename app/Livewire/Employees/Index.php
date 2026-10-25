<?php

namespace App\Livewire\Employees;

use App\Models\Department;
use App\Models\Employee;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $department = '';

    public string $role = '';

    public string $status = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'department' => ['except' => ''],
        'role' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedDepartment(): void
    {
        $this->resetPage();
    }

    public function updatedRole(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset([
            'search',
            'department',
            'role',
            'status',
        ]);

        $this->resetPage();
    }

    public function render()
    {
        $employees = Employee::query()
            ->with([
                'user.roles',
                'department',
            ])
            ->when($this->search !== '', function ($query) {
                $search = trim($this->search);

                $query->where(function ($query) use ($search) {
                    $query
                        ->where('employee_code', 'ilike', "%{$search}%")
                        ->orWhere('phone', 'ilike', "%{$search}%")
                        ->orWhere('designation', 'ilike', "%{$search}%")
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query
                                ->where('name', 'ilike', "%{$search}%")
                                ->orWhere('email', 'ilike', "%{$search}%");
                        });
                });
            })
            ->when(
                $this->department !== '',
                fn($query) => $query->where(
                    'department_id',
                    $this->department
                )
            )
            ->when(
                $this->role !== '',
                fn($query) => $query->whereHas(
                    'user',
                    fn($query) => $query->role($this->role)
                )
            )
            ->when(
                $this->status !== '',
                fn($query) => $query->where(
                    'status',
                    $this->status
                )
            )
            ->latest()
            ->paginate(20);

        return view('livewire.employees.index', [
            'employees' => $employees,
            'departments' => Department::orderBy('name')->get(),
        ])->layout('components.layouts.management', [
            'title' => 'Employees',
        ]);
    }
}
