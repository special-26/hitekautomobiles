<?php

namespace App\Livewire\Employees;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Role;
use App\Models\Shift;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
    public Employee $employee;

    // Account
    public string $name = '';
    public string $email = '';
    public string $role = '';

    // Employment
    public string $employee_code = '';
    public string $department_id = '';
    public string $designation = '';
    public string $joining_date = '';
    public string $shift_id = '';

    // Personal
    public string $phone = '';
    public string $date_of_birth = '';
    public string $gender = '';
    public string $address = '';
    public string $city = '';
    public string $state = '';
    public string $pincode = '';

    // Emergency contact
    public string $emergency_contact_name = '';
    public string $emergency_contact_phone = '';

    public function mount(Employee $employee): void
    {
        $this->employee = $employee->load([
            'user.roles',
            'department',
        ]);

        $this->name = $employee->user->name;
        $this->email = $employee->user->email;

        $this->role = $employee->user->roles
            ->first()?->name ?? '';

        $this->employee_code = $employee->employee_code;
        $this->department_id = (string) ($employee->department_id ?? '');
        $this->designation = $employee->designation ?? '';
        $this->joining_date = $employee->joining_date?->format('Y-m-d') ?? '';
        $this->shift_id = (string) ($employee->shift_id ?? '');

        $this->phone = $employee->phone ?? '';
        $this->date_of_birth = $employee->date_of_birth?->format('Y-m-d') ?? '';
        $this->gender = $employee->gender ?? '';
        $this->address = $employee->address ?? '';
        $this->city = $employee->city ?? '';
        $this->state = $employee->state ?? '';
        $this->pincode = $employee->pincode ?? '';

        $this->emergency_contact_name = $employee->emergency_contact_name ?? '';
        $this->emergency_contact_phone = $employee->emergency_contact_phone ?? '';
    }

    public function save(): void
    {
        $userId = $this->employee->user_id;
        $employeeId = $this->employee->id;

        $validated = $this->validate([
            // Account
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId, 'id'),
            ],

            'role' => [
                'required',
                'string',
                Rule::exists('roles', 'name')->where(
                    fn($query) => $query
                        ->where('guard_name', 'web')
                        ->whereNotIn('name', ['Super Admin', 'Customer'])
                ),
            ],

            // Employment
            'employee_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('employees', 'employee_code')->ignore($employeeId),
            ],

            'department_id' => ['required', 'exists:departments,id'],
            'designation' => ['nullable', 'string', 'max:255'],
            'joining_date' => ['nullable', 'date'],
            'shift_id' => ['required', 'integer', 'exists:shifts,id'],

            // Personal
            'phone' => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', Rule::in(['Male', 'Female', 'Other'])],
            'address' => ['nullable', 'string', 'max:2000'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'pincode' => ['nullable', 'string', 'max:10'],

            // Emergency contact
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:20'],
        ]);

        DB::transaction(function () use ($validated) {
            $user = $this->employee->user;

            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            // Replace the employee's assigned role.
            $user->syncRoles([$validated['role']]);

            $this->employee->update([
                'employee_code' => $validated['employee_code'],
                'department_id' => $validated['department_id'],
                'designation' => $validated['designation'] ?: null,
                'joining_date' => $validated['joining_date'] ?: null,
                'shift_id' => $validated['shift_id'],

                'phone' => $validated['phone'] ?: null,
                'date_of_birth' => $validated['date_of_birth'] ?: null,
                'gender' => $validated['gender'] ?: null,
                'address' => $validated['address'] ?: null,
                'city' => $validated['city'] ?: null,
                'state' => $validated['state'] ?: null,
                'pincode' => $validated['pincode'] ?: null,

                'emergency_contact_name' =>
                $validated['emergency_contact_name'] ?: null,

                'emergency_contact_phone' =>
                $validated['emergency_contact_phone'] ?: null,
            ]);
        });

        session()->flash('success', 'Employee updated successfully.');

        $this->redirectRoute('employees.show', [
            'employee' => $this->employee->id,
        ]);
    }

    public function render()
    {
        return view('livewire.employees.edit', [
            'departments' => Department::orderBy('name')->get(),
            'shifts' => Shift::where('is_active', true)
                ->orderBy('start_time')
                ->get(),
            'roles' => Role::query()
                ->where('guard_name', 'web')
                ->whereNotIn('name', ['Super Admin', 'Customer'])
                ->orderBy('name')
                ->get(),
        ])->layout('components.layouts.management', [
            'title' => 'Edit Employee',
        ]);
    }
}
