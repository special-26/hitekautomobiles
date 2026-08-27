<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * List roles
     */
    public function index()
    {
        $roles = Role::query()
            ->with('permissions:uuid,name')
            ->orderByRaw("
                CASE
                    WHEN name = 'Super Admin' THEN 1
                    WHEN name = 'Admin' THEN 2
                    ELSE 3
                END
            ")
            ->orderBy('name')
            ->get([
                'uuid',
                'name',
                'guard_name',
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
}
