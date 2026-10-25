<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Component;

class Edit extends Component
{
    public Customer $customer;

    public string $name = '';
    public string $phone = '';
    public string $email = '';
    public string $address = '';
    public string $city = '';
    public string $state = '';
    public string $pincode = '';
    public string $date_of_birth = '';

    public function mount(Customer $customer): void
    {
        $this->customer = $customer;

        $this->name = $customer->name ?? '';
        $this->phone = $customer->phone ?? '';
        $this->email = $customer->email ?? '';
        $this->address = $customer->address ?? '';
        $this->city = $customer->city ?? '';
        $this->state = $customer->state ?? '';
        $this->pincode = $customer->pincode ?? '';
        $this->date_of_birth = $customer->date_of_birth?->format('Y-m-d') ?? '';
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'pincode' => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['nullable', 'date'],
        ]);

        $this->customer->update($validated);

        session()->flash('success', 'Customer details updated successfully.');

        $this->redirect(
            route('customers.show', $this->customer),
            navigate: true
        );
    }

    public function render()
    {
        return view('livewire.customers.edit')
            ->layout('components.layouts.management', [
                'title' => 'Edit Customer',
            ]);
    }
}
