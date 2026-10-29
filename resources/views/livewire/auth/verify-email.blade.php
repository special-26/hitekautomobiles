<x-layouts.auth>
    <div class="mt-4 flex flex-col gap-6 border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-neutral-950 sm:rounded-xl sm:p-10">
        <p class="text-center">
            {{ __('Please verify your email address by clicking on the link we just emailed to you.') }}
        </p>

        @if (session('status') == 'verification-link-sent')
            <p class="text-center font-medium !dark:text-green-400 !text-green-600">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </p>
        @endif

        <div class="flex flex-col items-center justify-between space-y-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x:button type="submit" variant="primary" class="w-full">
                    {{ __('Resend verification email') }}
                </x:button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x:button variant="ghost" type="submit" class="text-sm cursor-pointer" data-test="logout-button">
                    {{ __('Log out') }}
                </x:button>
            </form>
        </div>
    </div>
</x-layouts.auth>
