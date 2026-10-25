<x-layouts.auth>
    <div class="flex flex-col gap-6 border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-neutral-950 sm:rounded-xl sm:p-10">
        <x-auth-header :title="__('Forgot password')" :description="__('Enter your email to receive a password reset link')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <x:input
                name="email"
                :label="__('Email Address')"
                type="email"
                required
                autofocus
                placeholder="email@example.com"
            />

            <x:button variant="primary" type="submit" class="w-full" data-test="email-password-reset-link-button">
                {{ __('Email password reset link') }}
            </x:button>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-400">
            <span>{{ __('Or, return to') }}</span>
            <x:link :href="route('login')" wire:navigate>{{ __('log in') }}</x:link>
        </div>
    </div>
</x-layouts.auth>
