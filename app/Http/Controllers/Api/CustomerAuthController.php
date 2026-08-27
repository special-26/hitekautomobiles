<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CustomerAuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:150',
            ],

            'email' => [
                'required',
                'email',
                'max:150',
                'unique:users,email',
            ],

            'phone' => [
                'required',
                'string',
                'max:30',
            ],

            'password' => [
                'required',
                'confirmed',
                Password::defaults(),
            ],
        ]);

        $customer = DB::transaction(function () use ($validated) {

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make(
                    $validated['password']
                ),
                'is_active' => true,
            ]);

            $user->assignRole('Customer');

            $lastCustomer = Customer::query()
                ->orderByDesc('id')
                ->lockForUpdate()
                ->first();

            $nextNumber = $lastCustomer
                ? $lastCustomer->id + 1
                : 1;

            $customerCode = 'CUS-' . str_pad(
                $nextNumber,
                6,
                '0',
                STR_PAD_LEFT
            );

            return Customer::create([
                'user_id' => $user->id,
                'customer_code' => $customerCode,
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'is_active' => true,
            ]);
        });

        return ApiResponse::success(
            $customer->load('user'),
            'Customer registered successfully.',
            201
        );
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where(
            'email',
            $validated['email']
        )->first();

        if (
            !$user ||
            !Hash::check(
                $validated['password'],
                $user->password
            )
        ) {
            return response()->json([
                'message' => 'Invalid email or password.',
            ], 422);
        }

        if (!$user->is_active) {
            return response()->json([
                'message' => 'Your account is inactive.',
            ], 403);
        }

        if (!$user->hasRole('Customer')) {
            return response()->json([
                'message' => 'This account is not a customer account.',
            ], 403);
        }

        $customer = $user->customer;

        if (!$customer || !$customer->is_active) {
            return response()->json([
                'message' => 'Customer account is inactive.',
            ], 403);
        }

        Auth::login($user);

        $request->session()->regenerate();

        return ApiResponse::success([
            'user' => $user,
            'customer' => $customer,
        ], 'Customer login successful.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return ApiResponse::success(
            null,
            'Customer logged out successfully.'
        );
    }

    public function me(Request $request)
    {
        $user = $request->user();

        return ApiResponse::success([
            'user' => $user,
            'customer' => $user->customer,
        ], 'Customer profile fetched successfully.');
    }
}
