<x-layouts.auth>
    <div class="flex flex-col gap-6 border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-neutral-950 sm:rounded-xl sm:p-10">
        <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <x-input
                name="email"
                label="Email address" 
                icon="users"
                :value="old('email')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Password -->
            <div class="relative">
                <x-password 
                    label="Password" 
                    name="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('Password')"
                />

                @if (Route::has('password.request'))
                    <x:link class="absolute top-0 text-sm end-0" :href="route('password.request')" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </x:link>
                @endif
            </div>

            <!-- Remember Me -->
            <x:checkbox name="remember" :label="__('Remember me')" :checked="old('remember')" />

            <div class="flex items-center justify-end">
                <x:button variant="primary" type="submit" class="w-full" data-test="login-button">
                    {{ __('Log in') }}
                </x:button>
            </div>
        </form>

        @if (Route::has('register'))
            <div class="space-x-1 text-sm text-center rtl:space-x-reverse text-zinc-600 dark:text-zinc-400">
                <span>{{ __('Don\'t have an account?') }}</span>
                <x:link :href="route('register')" wire:navigate>{{ __('Sign up') }}</x:link>
            </div>
        @endif
    </div>
</x-layouts.auth>
