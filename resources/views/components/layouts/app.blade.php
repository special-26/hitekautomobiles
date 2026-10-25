<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <tallstackui:script />
        @livewireStyles
    </head>
    <body class="min-h-screen bg-white relative">
        <x-main-navbar />
        
        {{ $slot }}

        @livewireScripts

    </body>
</html>
