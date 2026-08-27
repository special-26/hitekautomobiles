<x-layouts.app :title="__('Dashboard')">
    <x-main-navbar></x-main-navbar>

    <div class="flex flex-col gap-6 bg-gray-800 pt-20">

        <div>
            <div size="xl">
                Welcome, {{ auth()->user()->name }}
            </div>

            <div class="mt-2">
                Customer Portal
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-3">

            <div>
                <div size="lg">
                    Customer Code
                </div>

                <div class="mt-2">
                    {{ auth()->user()->customer?->customer_code ?? 'N/A' }}
                </div>
            </div>

            <div>
                <div size="lg">
                    Vehicles
                </div>

                <div class="mt-2">
                    0
                </div>
            </div>

            <div>
                <div size="lg">
                    Service History
                </div>

                <div class="mt-2">
                    0
                </div>
            </div>

        </div>

        <div>
            <a href="{{ route('customer.profile') }}">Go to Customer Profile</a>
        </div>

    </div>

    <x-main-footer />
</x-layouts.app>
