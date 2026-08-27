<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return ApiResponse::error(
                'Invalid email or password.',
                null,
                401
            );
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if (!$user->is_active) {
            Auth::logout();

            return ApiResponse::error(
                'Your account is inactive.',
                null,
                403
            );
        }

        // $user->update([
        //     'last_login_at' => now(),
        // ]);

        return ApiResponse::success(
            [
                'user' => $user,
                'roles' => $user->getRoleNames(),
                'permissions' => $user->getAllPermissions()->pluck('name'),
            ],
            'Login successful.'
        );
    }

    public function user(Request $request): JsonResponse
    {
        $user = $request->user();

        return ApiResponse::success([
            'user' => $user,
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions()->pluck('name'),
        ], 'Authenticated user.');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return ApiResponse::success(
            null,
            'Logout successful.'
        );
    }
}
