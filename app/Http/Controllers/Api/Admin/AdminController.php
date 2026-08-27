<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * List Admin accounts
     */
    public function index()
    {
        $admins = User::role('Admin')
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'email',
                'is_active',
                'created_at',
            ]);

        return ApiResponse::success(
            $admins,
            'Admin accounts fetched successfully.'
        );
    }

    /**
     * Create Admin account
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
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
                'confirmed',
            ],
        ]);

        $admin = DB::transaction(function () use ($validated) {

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make(
                    $validated['password']
                ),
                'is_active' => true,
            ]);

            $adminRole = Role::where(
                'name',
                'Admin'
            )->firstOrFail();

            $user->assignRole($adminRole);

            return $user;
        });

        return ApiResponse::success(
            $admin->load('roles'),
            'Admin account created successfully.',
            201
        );
    }

    /**
     * Update Admin account
     */
    public function update(
        Request $request,
        User $user
    ) {
        abort_unless(
            $user->hasRole('Admin'),
            404
        );

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($user->id),
            ],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        return ApiResponse::success(
            $user->fresh()->load('roles'),
            'Admin account updated successfully.'
        );
    }

    /**
     * Activate / Deactivate Admin
     */
    public function updateStatus(
        Request $request,
        User $user
    ) {
        abort_unless(
            $user->hasRole('Admin'),
            404
        );

        $validated = $request->validate([
            'is_active' => [
                'required',
                'boolean',
            ],
        ]);

        $user->update([
            'is_active' => $validated['is_active'],
        ]);

        return ApiResponse::success(
            $user->fresh()->load('roles'),
            'Admin status updated successfully.'
        );
    }
}
