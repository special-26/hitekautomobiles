<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * List roles
     */
    public function index()
    {
        $roles = Role::query()
            ->where('name', '!=', 'Super Admin')
            ->orderBy('name')
            ->get([
                'uuid',
                'name',
            ]);

        return ApiResponse::success(
            $roles,
            'Roles fetched successfully.'
        );
    }

    /**
     * Show role
     */
    public function show(Role $role)
    {
        $role->load('permissions:uuid,name');

        return ApiResponse::success(
            $role,
            'Role fetched successfully.'
        );
    }

    /**
     * Create role.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:roles,name',
            ],

            'permissions' => [
                'nullable',
                'array',
            ],

            'permissions.*' => [
                'string',
                'exists:permissions,uuid',
            ],
        ]);

        $role = DB::transaction(function () use ($validated) {

            $role = Role::create([
                'name' => $validated['name'],
                'guard_name' => 'web',
            ]);

            if (! empty($validated['permissions'])) {
                $permissions = Permission::whereIn(
                    'uuid',
                    $validated['permissions']
                )->get();

                $role->syncPermissions($permissions);
            }

            return $role;
        });

        $role->load('permissions:uuid,name');

        return ApiResponse::success(
            $role,
            'Role created successfully.',
            201
        );
    }

    /**
     * Update role.
     */
    public function update(Request $request, Role $role)
    {
        if ($role->name === 'Super Admin') {
            return ApiResponse::error(
                'The Super Admin role cannot be modified.',
                403
            );
        }

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')
                    ->ignore($role->uuid, 'uuid'),
            ],

            'permissions' => [
                'nullable',
                'array',
            ],

            'permissions.*' => [
                'string',
                'exists:permissions,uuid',
            ],
        ]);

        DB::transaction(function () use ($validated, $role) {

            $role->update([
                'name' => $validated['name'],
            ]);

            $permissions = Permission::whereIn(
                'uuid',
                $validated['permissions'] ?? []
            )->get();

            $role->syncPermissions($permissions);
        });

        $role->load('permissions:uuid,name');

        return ApiResponse::success(
            $role,
            'Role updated successfully.'
        );
    }
}
