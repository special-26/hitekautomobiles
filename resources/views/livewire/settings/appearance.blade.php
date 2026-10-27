<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<section class="w-full dark:bg-gray-800">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Appearance')" :subheading="__('Update the appearance settings for your account')">
        <radio.group x-data variant="segmented" x-model="$flux.appearance">
            <radio value="light" icon="sun">{{ __('Light') }}</radio>
            <radio value="dark" icon="moon">{{ __('Dark') }}</radio>
            <radio value="system" icon="computer-desktop">{{ __('System') }}</radio>
        </radio.group>
    </x-settings.layout>
</section>
