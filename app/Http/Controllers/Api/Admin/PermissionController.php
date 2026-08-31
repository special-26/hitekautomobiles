<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Permission;

class PermissionController extends Controller
{
    /**
     * List permissions.
     */
    public function index()
    {
        $permissions = Permission::query()
            ->where('name', 'not like', 'owner.%')
            ->orderBy('name')
            ->get([
                'uuid',
                'name',
            ]);

        return ApiResponse::success(
            $permissions,
            'Permissions fetched successfully.'
        );
    }
}
