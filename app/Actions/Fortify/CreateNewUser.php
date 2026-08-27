<?php

namespace App\Actions\Fortify;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'phone' => [
                'required',
                'string',
                'max:30',
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        return DB::transaction(function () use ($input) {

            /*
            |--------------------------------------------------------------------------
            | Create User
            |--------------------------------------------------------------------------
            */

            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => $input['password'],
                'is_active' => true,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Generate Customer Code
            |--------------------------------------------------------------------------
            */

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


            /*
            |--------------------------------------------------------------------------
            | Create Customer Profile
            |--------------------------------------------------------------------------
            */

            Customer::create([
                'user_id' => $user->id,
                'customer_code' => $customerCode,
                'name' => $input['name'],
                'phone' => $input['phone'],
                'email' => $input['email'],
                'is_active' => true,
            ]);


            return $user;
        });
    }
}
