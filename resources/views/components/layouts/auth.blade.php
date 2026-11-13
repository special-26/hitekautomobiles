<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')

    <tallstackui:script />
    @livewireStyles
</head>

<body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900 relative ">
    
    <x-toast />

    <div class="">
        {{ $slot }}
    </div>

    @livewireScripts

</body>

</html>