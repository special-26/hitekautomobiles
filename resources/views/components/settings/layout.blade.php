<div class="flex items-start max-md:flex-col">
    <div class="me-10 w-full pb-4 md:w-[220px]">
        <navlist>
            <navlist.item :href="route('profile.edit')" wire:navigate>{{ __('Profile') }}</navlist.item>
            <navlist.item :href="route('user-password.edit')" wire:navigate>{{ __('Password') }}</navlist.item>
            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <navlist.item :href="route('two-factor.show')" wire:navigate>{{ __('Two-Factor Auth') }}</navlist.item>
            @endif
            <navlist.item :href="route('appearance.edit')" wire:navigate>{{ __('Appearance') }}</navlist.item>
        </navlist>
    </div>

    <separator class="md:hidden" />

    <div class="flex-1 self-stretch max-md:pt-6">
        <heading>{{ $heading ?? '' }}</heading>
        <subheading>{{ $subheading ?? '' }}</subheading>

        <div class="mt-5 w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>
