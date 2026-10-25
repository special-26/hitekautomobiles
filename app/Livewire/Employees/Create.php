<?php

namespace App\Livewire\Employees;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Role;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Create extends Component
{
    /*
    |--------------------------------------------------------------------------
    | Account
    |--------------------------------------------------------------------------
    */

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $role = '';


    /*
    |--------------------------------------------------------------------------
    | Employment
    |--------------------------------------------------------------------------
    */

    public string $employee_code = '';
    public string $department_id = '';
    public string $designation = '';
    public string $joining_date = '';
    public $shift_id = '';


    /*
    |--------------------------------------------------------------------------
    | Personal
    |--------------------------------------------------------------------------
    */

    public string $phone = '';
    public string $date_of_birth = '';
    public string $gender = '';
    public string $address = '';
    public string $city = '';
    public string $state = '';
    public string $pincode = '';


    /*
    |--------------------------------------------------------------------------
    | Emergency Contact
    |--------------------------------------------------------------------------
    */

    public string $emergency_contact_name = '';
    public string $emergency_contact_phone = '';


    /**
     * Create employee.
     */
    public function save(): void
    {
        $validated = $this->validate([
            /*
            | Account
            */
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
            ],

            'role' => [
                'required',
                'string',
                Rule::exists('roles', 'name')
                    ->where(function ($query) {
                        $query->where('name', '!=', 'Super Admin');
                    }),
            ],

            /*
            | Employment
            */
            'employee_code' => [
                'required',
                'string',
                'max:50',
                'unique:employees,employee_code',
            ],
            'department_id' => [
                'required',
                'exists:departments,id',
            ],
            'designation' => [
                'nullable',
                'string',
                'max:255',
            ],
            'joining_date' => [
                'nullable',
                'date',
            ],
            'shift_id' => [
                'required',
                'integer',
                'exists:shifts,id',
            ],

            /*
            | Personal
            */
            'phone' => [
                'nullable',
                'string',
                'max:20',
            ],

            'date_of_birth' => [
                'nullable',
                'date',
            ],

            'gender' => [
                'nullable',
                'string',
                'max:30',
            ],

            'address' => [
                'nullable',
                'string',
            ],

            'city' => [
                'nullable',
                'string',
                'max:100',
            ],

            'state' => [
                'nullable',
                'string',
                'max:100',
            ],

            'pincode' => [
                'nullable',
                'string',
                'max:10',
            ],

            /*
            | Emergency Contact
            */
            'emergency_contact_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'emergency_contact_phone' => [
                'nullable',
                'string',
                'max:20',
            ],
        ]);

        DB::transaction(function () use ($validated) {

            /*
            |--------------------------------------------------------------------------
            | Create User Account
            |--------------------------------------------------------------------------
            */

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'is_active' => true,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Assign Role
            |--------------------------------------------------------------------------
            */

            $user->assignRole($validated['role']);

            /*
            |--------------------------------------------------------------------------
            | Create Employee Profile
            |--------------------------------------------------------------------------
            */

            Employee::create([
                'user_id' => $user->id,

                'department_id' => $validated['department_id'],
                'employee_code' => $validated['employee_code'],
                'designation' => $validated['designation'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'joining_date' => $validated['joining_date'] ?? null,
                'shift_id' => $validated['shift_id'],

                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'gender' => $validated['gender'] ?? null,

                'address' => $validated['address'] ?? null,
                'city' => $validated['city'] ?? null,
                'state' => $validated['state'] ?? null,
                'pincode' => $validated['pincode'] ?? null,

                'emergency_contact_name' =>
                $validated['emergency_contact_name'] ?? null,

                'emergency_contact_phone' =>
                $validated['emergency_contact_phone'] ?? null,

                'status' => 'active',
            ]);
        });

        session()->flash(
            'success',
            'Employee created successfully.'
        );

        $this->redirectRoute('employees.index');
    }

    public function render()
    {
        return view('livewire.employees.create', [
            'departments' => Department::orderBy('name')->get(),
            'shifts' => Shift::where('is_active', true)
                ->orderBy('start_time')
                ->get(),
            'roles' => Role::query()
                ->where('guard_name', 'web')
                ->where('name', '!=', 'Super Admin')
                ->orderBy('name')
                ->get(),
        ])->layout('components.layouts.management', [
            'title' => 'Add Employee',
        ]);
    }
}
