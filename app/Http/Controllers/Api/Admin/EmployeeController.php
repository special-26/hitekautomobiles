<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    /**
     * List employees.
     */
    public function index(Request $request)
    {
        $employees = Employee::query()
            ->with([
                'user:id,name,email,is_active',
                'department:id,name',
            ])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->trim();

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
                $request->filled('department_id'),
                fn($query) => $query->where(
                    'department_id',
                    $request->department_id
                )
            )
            ->when(
                $request->filled('status'),
                fn($query) => $query->where(
                    'status',
                    $request->status
                )
            )
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return ApiResponse::success(
            $employees,
            'Employees fetched successfully.'
        );
    }

    /**
     * Create employee.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],

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

            'designation' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'joining_date' => ['nullable', 'date'],

            'role' => [
                'required',
                'string',
                Rule::exists('roles', 'name')
                    ->where(function ($query) {
                        $query->where('name', '!=', 'Super Admin');
                    }),
            ],
        ]);

        $employee = DB::transaction(function () use ($validated) {

            // Create login account
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
            ]);

            // Assign Spatie role
            $user->assignRole($validated['role']);

            // Create employee profile
            return Employee::create([
                'user_id' => $user->id,
                'department_id' => $validated['department_id'],
                'employee_code' => $validated['employee_code'],
                'phone' => $validated['phone'] ?? null,
                'designation' => $validated['designation'] ?? null,
                'joining_date' => $validated['joining_date'] ?? null,
                'status' => 'active',
            ]);
        });

        $employee->load([
            'user:id,name,email,is_active',
            'department:id,name',
        ]);

        return ApiResponse::success(
            $employee,
            'Employee created successfully.',
            201
        );
    }

    /**
     * Show employee.
     */
    public function show(Employee $employee)
    {
        $employee->load([
            'user:id,name,email,is_active',
            'user.roles:uuid,name,guard_name',
            'department:id,name',
        ]);

        return ApiResponse::success(
            $employee,
            'Employee fetched successfully.'
        );
    }

    /**
     * Update employee.
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($employee->user_id),
            ],

            'employee_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('employees', 'employee_code')
                    ->ignore($employee->id),
            ],

            'department_id' => [
                'required',
                'exists:departments,id',
            ],

            'designation' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'joining_date' => ['nullable', 'date'],
            'role' => [
                'required',
                'string',
                'exists:roles,name',
            ],
        ]);

        DB::transaction(function () use ($validated, $employee) {

            $employee->update([
                'employee_code' => $validated['employee_code'],
                'department_id' => $validated['department_id'],
                'designation' => $validated['designation'] ?? null,
                'phone' => $validated['phone'] ?? null,
                'joining_date' => $validated['joining_date'] ?? null,
            ]);

            $employee->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            $employee->user->syncRoles(
                $validated['role']
            );
        });

        return ApiResponse::success(
            $employee->fresh()->load([
                'user.roles',
                'department',
            ]),
            'Employee updated successfully.'
        );
    }

    /**
     * Activate / deactivate employee.
     */
    public function updateStatus(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'active',
                    'inactive',
                    'terminated',
                    'on_leave',
                ]),
            ],
        ]);

        DB::transaction(function () use ($validated, $employee) {

            $employee->update([
                'status' => $validated['status'],
            ]);

            // Only active employees can login.
            $employee->user->update([
                'is_active' => $validated['status'] === 'active',
            ]);
        });

        return ApiResponse::success(
            $employee->fresh()->load('user'),
            'Employee status updated successfully.'
        );
    }
}
