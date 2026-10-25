<x-layouts.auth>
    <div class="flex flex-col gap-6 border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-neutral-950 sm:rounded-xl sm:p-10">
        <x-auth-header
            :title="__('Confirm password')"
            :description="__('This is a secure area of the application. Please confirm your password before continuing.')"
        />

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.confirm.store') }}" class="flex flex-col gap-6">
            @csrf

            <x:input
                name="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Password')"
                viewable
            />

            <x:button variant="primary" type="submit" class="w-full" data-test="confirm-password-button">
                {{ __('Confirm') }}
            </x:button>
        </form>
    </div>
</x-layouts.auth>
