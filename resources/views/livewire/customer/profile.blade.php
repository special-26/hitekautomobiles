<?php

use Livewire\Volt\Component;
use Illuminate\Validation\Rule;

new class extends Component
{
    public string $name = '';
    public string $phone = '';
    public string $email = '';
    public string $address = '';
    public string $city = '';
    public string $state = '';
    public string $pincode = '';

    public function mount(): void
    {
        $customer = auth()->user()->customer;

        abort_if(!$customer, 404);

        $this->name = $customer->name ?? '';
        $this->phone = $customer->phone ?? '';
        $this->email = $customer->email ?? '';
        $this->address = $customer->address ?? '';
        $this->city = $customer->city ?? '';
        $this->state = $customer->state ?? '';
        $this->pincode = $customer->pincode ?? '';
    }

    public function updateProfile(): void
    {
        $user = auth()->user();
        $customer = $user->customer;

        abort_if(!$customer, 404);

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'address' => ['nullable', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'pincode' => ['nullable', 'string', 'max:20'],
        ]);

        $customer->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'pincode' => $validated['pincode'],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        session()->flash(
            'success',
            'Profile updated successfully.'
        );
    }
};
?>

<div class="max-w-4xl mx-auto px-4 py-8 dark:bg-gray-900 dark:text-white">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            My Profile
        </h1>

        <p class="mt-1 text-sm text-gray-600">
            Manage your personal information.
        </p>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @php
        $customer = auth()->user()->customer;
    @endphp

    <div class="rounded-xl border border-gray-200 dark:bg-gray-900 p-6 shadow-sm">

        <form wire:submit="updateProfile">

            <div class="space-y-6">

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Customer Code
                    </label>

                    <input
                        type="text"
                        value="{{ $customer->customer_code }}"
                        disabled
                        class="mt-1 block w-full rounded-lg border border-gray-300 bg-gray-100 px-3 py-2.5 text-gray-500"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Full Name
                    </label>

                    <input
                        type="text"
                        wire:model="name"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2.5"
                    >

                    @error('name')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Phone Number
                    </label>

                    <input
                        type="tel"
                        wire:model="phone"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2.5"
                    >

                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Email Address
                    </label>

                    <input
                        type="email"
                        wire:model="email"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2.5"
                    >

                    @error('email')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Address
                    </label>

                    <textarea
                        wire:model="address"
                        rows="3"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2.5"
                    ></textarea>

                    @error('address')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            City
                        </label>

                        <input
                            type="text"
                            wire:model="city"
                            class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2.5"
                        >

                        @error('city')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            State
                        </label>

                        <input
                            type="text"
                            wire:model="state"
                            class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2.5"
                        >

                        @error('state')
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Pincode
                    </label>

                    <input
                        type="text"
                        wire:model="pincode"
                        class="mt-1 block w-full rounded-lg border border-gray-300 px-3 py-2.5"
                    >

                    @error('pincode')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <button
                        type="submit"
                        class="rounded-lg bg-blue-600 px-5 py-2.5 font-medium text-white hover:bg-blue-700"
                    >
                        Save Changes
                    </button>
                </div>

            </div>

        </form>

    </div>

</div>