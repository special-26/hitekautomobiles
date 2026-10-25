<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#111315">
    <title>Hitek Automobiles | Expert Car Care in Chandigarh</title>
    <meta name="description" content="Professional car servicing, denting and painting, detailing, ceramic coating, PPF and insurance claim assistance at Hitek Automobiles, Chandigarh.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-zinc-900 antialiased">
@php
    $whatsappUrl = 'https://wa.me/919216111868?text=' . rawurlencode('Hello Hitek Automobiles, I would like to enquire about car service.');
    $services = [
        ['number' => '01', 'title' => 'Car Servicing', 'desc' => 'Periodic maintenance, inspections and repairs to help keep your car running smoothly.', 'image' => asset('images/services/car-service.jpg')],
        ['number' => '02', 'title' => 'Denting & Painting', 'desc' => 'Careful bodywork and professional paint finishes to restore your vehicle’s appearance.', 'image' => asset('images/services/denting-painting.jpg')],
        ['number' => '03', 'title' => 'Car Detailing', 'desc' => 'Deep interior and exterior care for a cleaner cabin and a refined finish.', 'image' => asset('images/services/detailing.jpg')],
        ['number' => '04', 'title' => 'Car Washing', 'desc' => 'A thorough clean that refreshes your car inside and out.', 'image' => asset('images/services/washing.jpg')],
        ['number' => '05', 'title' => 'Ceramic Coating & PPF', 'desc' => 'Paint protection options designed to help preserve your car’s finish.', 'image' => asset('images/services/ppf.jpg')],
        ['number' => '06', 'title' => 'Insurance Assistance', 'desc' => 'Support with repair estimates, documentation and insurance claim coordination.', 'image' => asset('images/services/insurance.jpg')],
    ];
@endphp

<!-- Top contact strip -->
<div class="hidden border-b border-white/10 bg-[#111315] text-xs text-white/70 md:block">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-2.5 lg:px-8">
        <p>Professional car care in Chandigarh</p>
        <div class="flex items-center gap-6"><a class="transition hover:text-white" href="tel:9216111868">+91 9216111668</a><span>Mon–Sat · 9:00 AM–7:00 PM</span></div>
    </div>
</div>

<!-- Navigation -->
<x-main-navbar />

<main>
   
    <!-- Hero -->
    <section class="relative isolate overflow-hidden bg-[#111315] text-white">
        {{-- Background image --}}
        <div
            class="absolute inset-0 -z-30 bg-cover bg-center"
            style="background-image: url('{{ asset('images/hero-bg.jpg') }}')"
            aria-hidden="true"
        ></div>

        {{-- Dark overlay for readable text --}}
        <div
            class="absolute inset-0 -z-20 bg-gradient-to-r from-[#101214] via-[#101214]/90 to-[#101214]/60"
            aria-hidden="true"
        ></div>

        <div
            class="absolute inset-0 -z-10 bg-gradient-to-t from-[#101214]/80 via-transparent to-[#101214]/20"
            aria-hidden="true"
        ></div>

        <div class="mx-auto grid max-w-7xl items-center gap-12 px-5 py-14 sm:px-8 sm:py-20 lg:min-h-[660px] lg:grid-cols-2 lg:gap-14 lg:px-8 lg:py-20">

            {{-- Left: Content --}}
            <div class="relative z-10 max-w-2xl">
                <div class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/[0.06] px-4 py-2">
                    <span class="h-2 w-2 rounded-full bg-[#ff3949]"></span>
                    <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-white/80 sm:text-xs">
                        Your car. Our responsibility.
                    </span>
                </div>

                <h1 class="mt-7 text-4xl font-black leading-[1.04] tracking-tight sm:text-6xl lg:text-7xl">
                    CARE THAT<br>
                    GOES <span class="text-[#ff3949]">BEYOND</span><br>
                    THE DRIVE.
                </h1>

                <p class="mt-6 max-w-lg text-sm leading-7 text-white/75 sm:text-base sm:leading-8">
                    From everyday servicing to bodywork and paint protection,
                    give your car expert attention at Hitek Automobiles, Chandigarh.
                </p>

                {{-- Booking actions --}}
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ url('/book-service') }}" class="rounded-full bg-[#e32636] px-5 py-2.5 text-sm font-bold text-white transition hover:bg-[#c91f2d] flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                        </svg>
                        Book a service 
                    </a>

                    <a
                        href="{{ $whatsappUrl }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex min-h-12 items-center justify-center gap-3 rounded-full border border-green-600/30 bg-green-600/[0.05] px-7 py-3.5 text-sm font-bold text-white transition hover:border-green-600/60 hover:bg-green-600/10 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-white"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-green-600" viewBox="0 0 24 24"><!-- Icon from Google Material Icons by Material Design Authors - https://github.com/material-icons/material-icons/blob/master/LICENSE --><path fill="currentColor" d="M19.05 4.91A9.82 9.82 0 0 0 12.04 2c-5.46 0-9.91 4.45-9.91 9.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21c5.46 0 9.91-4.45 9.91-9.91c0-2.65-1.03-5.14-2.9-7.01m-7.01 15.24c-1.48 0-2.93-.4-4.2-1.15l-.3-.18l-3.12.82l.83-3.04l-.2-.31a8.26 8.26 0 0 1-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24c2.2 0 4.27.86 5.82 2.42a8.18 8.18 0 0 1 2.41 5.83c.02 4.54-3.68 8.23-8.22 8.23m4.52-6.16c-.25-.12-1.47-.72-1.69-.81c-.23-.08-.39-.12-.56.12c-.17.25-.64.81-.78.97c-.14.17-.29.19-.54.06c-.25-.12-1.05-.39-1.99-1.23c-.74-.66-1.23-1.47-1.38-1.72c-.14-.25-.02-.38.11-.51c.11-.11.25-.29.37-.43s.17-.25.25-.41c.08-.17.04-.31-.02-.43s-.56-1.34-.76-1.84c-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.43.06-.66.31c-.22.25-.86.85-.86 2.07s.89 2.4 1.01 2.56c.12.17 1.75 2.67 4.23 3.74c.59.26 1.05.41 1.41.52c.59.19 1.13.16 1.56.1c.48-.07 1.47-.6 1.67-1.18c.21-.58.21-1.07.14-1.18s-.22-.16-.47-.28"/></svg>
                        Chat on WhatsApp
                    </a>
                </div>

                {{-- Trust indicators --}}
                <div class="mt-10 grid max-w-lg grid-cols-3 gap-3 border-t border-white/20 pt-6 sm:mt-12 sm:gap-5">
                    <div>
                        <p class="text-2xl font-black">01</p>
                        <p class="mt-1 text-xs leading-5 text-white/60">Expert care</p>
                    </div>

                    <div>
                        <p class="text-2xl font-black">02</p>
                        <p class="mt-1 text-xs leading-5 text-white/60">Clear estimates</p>
                    </div>

                    <div>
                        <p class="text-2xl font-black">03</p>
                        <p class="mt-1 text-xs leading-5 text-white/60">Customer first</p>
                    </div>
                </div>
            </div>

            {{-- Right: Real workshop photograph --}}
            <div class="relative mx-auto w-full max-w-2xl lg:ml-auto">
                <div class="absolute -inset-3 rounded-[2rem] border border-white/10 sm:-inset-4"></div>

                <div class="relative overflow-hidden rounded-2xl border border-white/15 bg-white/5 shadow-2xl sm:rounded-3xl">
                    <img
                        src="{{ asset('images/hero-bg.jpg') }}"
                        alt="Hitek Automobiles workshop in Chandigarh"
                        class="aspect-[5/4] w-full object-cover object-right sm:aspect-[4/3] lg:aspect-[5/4]"
                        loading="eager"
                        decoding="async"
                    >

                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>

                    <div class="absolute bottom-4 left-4 right-4 rounded-xl border border-white/15 bg-[#151719]/90 p-4 backdrop-blur-md sm:bottom-6 sm:left-6 sm:right-auto sm:max-w-xs sm:p-5">
                        <p class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-[#ff3949]">
                            Hitek standard
                        </p>
                        <p class="mt-2 text-base font-bold leading-6 sm:text-lg">
                            A better experience for every drive.
                        </p>
                    </div>
                </div>

                <div class="mt-4 flex items-center justify-between gap-3 text-xs text-white/55 sm:mt-5">
                    <span>Service. Repair. Protection.</span>
                    <a href="#services" class="font-semibold text-white transition hover:text-[#ff3949]">
                        Explore our services →
                    </a>
                </div>
            </div>
        </div>

        {{-- Red accent --}}
        <div class="absolute bottom-0 left-0 h-1 w-1/3 bg-[#e32636]"></div>
    </section>
    <!-- End Hero -->

    <!-- Intro / about -->
    <section id="about" class="py-20 sm:py-24 lg:py-28">
        <div class="mx-auto grid max-w-7xl gap-12 px-5 lg:grid-cols-[.9fr_1.1fr] lg:items-end lg:px-8">
            <div><p class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#e32636]">The Hitek difference</p><h2 class="mt-5 max-w-xl text-4xl font-black leading-tight tracking-tight sm:text-5xl">Good service is more than fixing a car.</h2></div>
            <div><p class="max-w-2xl text-base leading-8 text-zinc-600">It is about knowing what your vehicle needs, understanding the work being done, and feeling confident at every step. At Hitek Automobiles, we bring service, repair and appearance care together under one roof.</p><a href="#workshop" class="mt-6 inline-flex items-center gap-3 text-sm font-bold text-zinc-900 transition hover:text-[#e32636]">Get to know our workshop <span aria-hidden="true">→</span></a></div>
        </div>
        <div class="mx-auto mt-14 grid max-w-7xl gap-4 px-5 sm:grid-cols-3 lg:px-8">
            <div class="border-t-2 border-[#e32636] bg-zinc-50 p-6 sm:p-8"><span class="text-xs font-bold tracking-[0.2em] text-zinc-400">01 / PEOPLE</span><h3 class="mt-5 text-xl font-bold">Experienced technicians</h3><p class="mt-3 text-sm leading-6 text-zinc-600">Careful workmanship and attention to the details that matter.</p></div>
            <div class="border-t-2 border-zinc-200 bg-zinc-50 p-6 sm:p-8"><span class="text-xs font-bold tracking-[0.2em] text-zinc-400">02 / PROCESS</span><h3 class="mt-5 text-xl font-bold">Clear communication</h3><p class="mt-3 text-sm leading-6 text-zinc-600">Understand the recommended work and estimate before proceeding.</p></div>
            <div class="border-t-2 border-zinc-200 bg-zinc-50 p-6 sm:p-8"><span class="text-xs font-bold tracking-[0.2em] text-zinc-400">03 / CARE</span><h3 class="mt-5 text-xl font-bold">One place for car care</h3><p class="mt-3 text-sm leading-6 text-zinc-600">From routine maintenance to appearance and paint protection services.</p></div>
        </div>
    </section>

    <!-- Services -->
    <section id="services" class="bg-[#f5f5f3] py-20 sm:py-24 lg:py-28">
        <div class="mx-auto max-w-7xl px-5 lg:px-8">
            <div class="flex flex-col justify-between gap-6 sm:flex-row sm:items-end"><div><p class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#e32636]">What we do</p><h2 class="mt-4 text-4xl font-black tracking-tight sm:text-5xl">Complete car care.<br class="hidden sm:block"> Done with purpose.</h2></div><p class="max-w-md text-sm leading-7 text-zinc-600">Choose the service your car needs. Our team can help you understand the right next step.</p></div>
            <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($services as $service)
                    <!-- Service card -->
                    <div class="flex h-full flex-col overflow-hidden rounded-2xl
                                border border-zinc-200/80 bg-white
                                transition duration-300 hover:-translate-y-1
                                hover:shadow-xl">

                        <!-- Image -->
                        <div class="aspect-video overflow-hidden bg-zinc-100">
                            <img
                                src="{{ $service['image'] }}"
                                alt="{{ $service['title'] }}"
                                loading="lazy"
                                class="h-full w-full object-contain"
                            >
                        </div>

                        <!-- Content -->
                        <div class="flex flex-1 flex-col p-5 sm:p-6">
                            <h3 class="text-lg font-bold text-zinc-900">
                                {{ $service['title'] }}
                            </h3>

                            <p class="mt-3 text-sm leading-6 text-zinc-600">
                                {{ $service['desc'] }}
                            </p>

                            <a
                                href="{{ url('/book-service') }}"
                                class="mt-auto inline-flex items-center gap-2 pt-6
                                    text-sm font-bold text-[#e32636]
                                    hover:text-[#c91f2d]"
                            >
                                Enquire about service
                                <span aria-hidden="true">→</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    
    <!-- Workshop Feature -->
    <section id="workshop" class="overflow-hidden bg-[#111315] text-white">
        <div class="mx-auto grid max-w-7xl lg:grid-cols-2">

            <!-- Left: Content -->
            <div class="flex flex-col justify-center px-5 py-16 sm:px-8 sm:py-20 lg:px-12 lg:py-24">
                <div class="flex items-center gap-3">
                    <span class="h-px w-8 bg-[#e32636]"></span>
                    <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#ff3949]">
                        Inside Hitek
                    </p>
                </div>

                <h2 class="mt-6 max-w-xl text-4xl font-black leading-[1.08] tracking-tight sm:text-5xl xl:text-6xl">
                    More than a workshop.
                    <span class="text-[#ff3949]">A commitment to your car.</span>
                </h2>

                <p class="mt-6 max-w-lg text-sm leading-7 text-white/65 sm:text-base sm:leading-8">
                    From careful inspections to dedicated service areas, our team
                    focuses on quality workmanship and a better experience for
                    every vehicle that comes through Hitek Automobiles.
                </p>

                <!-- Highlights -->
                <div class="mt-8 grid max-w-lg grid-cols-2 gap-x-6 gap-y-5">
                    <div class="flex items-start gap-3">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#e32636]/15 text-[#ff3949]">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="m9 12 2 2 4-4"/>
                                <path d="M12 3 5 6v5c0 4.5 3 7.5 7 10 4-2.5 7-5.5 7-10V6l-7-3Z"/>
                            </svg>
                        </span>
                        <div>
                            <p class="text-sm font-bold">Careful inspection</p>
                            <p class="mt-1 text-xs leading-5 text-white/50">Attention at every step</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#e32636]/15 text-[#ff3949]">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M4 19h16M6 19V8l6-4 6 4v11M9 19v-6h6v6"/>
                            </svg>
                        </span>
                        <div>
                            <p class="text-sm font-bold">Dedicated service areas</p>
                            <p class="mt-1 text-xs leading-5 text-white/50">Organized workshop spaces</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#e32636]/15 text-[#ff3949]">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1.1 6.2-5.6-3-5.6 3 1.1-6.2L3 9.6l6.2-.9L12 3Z"/>
                            </svg>
                        </span>
                        <div>
                            <p class="text-sm font-bold">Quality workmanship</p>
                            <p class="mt-1 text-xs leading-5 text-white/50">A focus on doing it right</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#e32636]/15 text-[#ff3949]">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M20 11.5a7.5 7.5 0 0 1-11.1 6.6L4 20l1.9-4.3A7.5 7.5 0 1 1 20 11.5Z"/>
                                <path d="M8.5 9.5c.7 2 2 3.3 4 4"/>
                            </svg>
                        </span>
                        <div>
                            <p class="text-sm font-bold">Customer communication</p>
                            <p class="mt-1 text-xs leading-5 text-white/50">Here when you need us</p>
                        </div>
                    </div>
                </div>

                <a
                    href="{{ $whatsappUrl }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="mt-9 inline-flex min-h-12 w-fit items-center gap-3 rounded-full bg-[#e32636] px-6 py-3.5 text-sm font-bold text-white transition hover:-translate-y-0.5 hover:bg-[#c91f2d]"
                >
                    Talk to our team
                    <span aria-hidden="true">↗</span>
                </a>
            </div>

            <!-- Right: Workshop Gallery -->
            <div class="relative p-4 sm:p-7 lg:p-10">
                <div class="grid grid-cols-2 gap-3 sm:gap-4">

                    <div class="overflow-hidden rounded-2xl border border-white/10">
                        <img
                            src="{{ asset('images/services/washing.jpg') }}"
                            alt="Hitek Automobiles workshop"
                            class="aspect-[4/5] h-full w-full object-cover object-right transition duration-500 hover:scale-105"
                            loading="lazy"
                        >
                    </div>

                    <div class="mt-8 overflow-hidden rounded-2xl border border-white/10 sm:mt-12">
                        <img
                            src="{{ asset('images/services/car-service.jpg') }}"
                            alt="Car servicing at Hitek Automobiles"
                            class="aspect-[4/5] h-full w-full object-cover object-right bg-white transition duration-500 hover:scale-[1.02]"
                            loading="lazy"
                        >
                    </div>

                    <div class="-mt-4 overflow-hidden rounded-2xl border border-white/10 sm:-mt-6">
                        <img
                            src="{{ asset('images/services/denting-painting.jpg') }}"
                            alt="Denting and painting service at Hitek Automobiles"
                            class="aspect-[4/5] h-full w-full object-cover object-right bg-white transition duration-500 hover:scale-[1.02]"
                            loading="lazy"
                        >
                    </div>

                    <div class="overflow-hidden rounded-2xl border border-white/10">
                        <img
                            src="{{ asset('images/services/detailing.jpg') }}"
                            alt="Car detailing service at Hitek Automobiles"
                            class="aspect-[4/5] h-full w-full object-cover object-right bg-white transition duration-500 hover:scale-[1.02]"
                            loading="lazy"
                        >
                    </div>

                </div>

                <!-- Hitek Brand Badge -->
                <div class="absolute bottom-5 left-5 flex items-center gap-3 rounded-xl border border-white/10 bg-[#1b1d20]/95 px-4 py-3 shadow-2xl backdrop-blur sm:bottom-9 sm:left-9">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-[#e32636] text-lg font-black italic">
                        H
                    </span>
                    <div>
                        <p class="text-sm font-black tracking-wider">HITEK</p>
                        <p class="mt-1 text-[9px] font-bold tracking-[0.25em] text-white/50">
                            AUTOMOBILES
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Workshop Feature -->

    <!-- How It Works -->
    <section id="process" class="relative overflow-hidden bg-[#fefefe] py-20 sm:py-24 lg:py-28">
        <div class="mx-auto max-w-7xl px-5 sm:px-8 lg:px-8">

            <!-- Section Heading -->
            <div class="mx-auto max-w-2xl text-center">
                <div class="inline-flex items-center gap-3">
                    <span class="h-px w-7 bg-[#e32636]"></span>
                    <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#e32636]">
                        Simple by design
                    </p>
                    <span class="h-px w-7 bg-[#e32636]"></span>
                </div>

                <h2 class="mt-5 text-3xl font-black leading-tight tracking-tight text-[#17191b] sm:text-5xl">
                    Your visit, <span class="text-[#e32636]">made easier.</span>
                </h2>

                <p class="mx-auto mt-5 max-w-xl text-sm leading-7 text-zinc-600 sm:text-base">
                    From your first enquiry to the final handover, know what to expect
                    at every step of your Hitek service experience.
                </p>
            </div>

            <!-- Process Steps -->
            <div class="relative mt-14 grid gap-5 sm:grid-cols-2 lg:mt-20 lg:grid-cols-4">

                @foreach ([
                    ['01', 'Book your visit', 'Choose online booking or contact our team to discuss your service needs.', 'calendar-check'],
                    ['02', 'Vehicle inspection', 'We listen to your concerns and inspect your vehicle to understand the work required.', 'search'],
                    ['03', 'Approve the estimate', 'Review the recommended work and estimated cost before we proceed.', 'clipboard-check'],
                    ['04', 'Service & delivery', 'We complete the agreed work and keep you informed about your vehicle.', 'check-circle'],
                ] as $index => $step)

                    <article class="group relative rounded-2xl border border-zinc-200/80 bg-white p-6 transition duration-300 hover:-translate-y-1 hover:border-[#e32636]/40 hover:shadow-xl sm:p-7">

                        <!-- Number and Icon -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-black tracking-widest text-[#e32636]">
                                STEP {{ $step[0] }}
                            </span>

                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#fce9eb] text-[#e32636] transition group-hover:bg-[#e32636] group-hover:text-white">
                                @if ($index === 0)
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <rect x="3" y="5" width="18" height="16" rx="2"/>
                                        <path d="M16 3v4M8 3v4M3 10h18"/>
                                    </svg>
                                @elseif ($index === 1)
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <circle cx="10.5" cy="10.5" r="6.5"/>
                                        <path d="m16 16 4.5 4.5"/>
                                        <path d="m8 10 1.5 1.5L13 8"/>
                                    </svg>
                                @elseif ($index === 2)
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M7 3h10l4 4v14H3V3h4Z"/>
                                        <path d="M7 3v5h10V3M7 13h10M7 17h6"/>
                                    </svg>
                                @else
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path d="m8 12 2.5 2.5L16 9"/>
                                    </svg>
                                @endif
                            </span>
                        </div>

                        <!-- Step Content -->
                        <div class="mt-8">
                            <h3 class="text-lg font-extrabold tracking-tight text-[#17191b]">
                                {{ $step[1] }}
                            </h3>

                            <p class="mt-3 text-sm leading-7 text-zinc-600">
                                {{ $step[2] }}
                            </p>
                        </div>

                        <!-- Decorative Step Number -->
                        <div class="pointer-events-none absolute bottom-3 right-5 select-none text-5xl font-black text-zinc-100">
                            {{ $step[0] }}
                        </div>
                    </article>
                @endforeach

            </div>

            <!-- Booking CTA -->
            <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
                <a
                    href="{{ url('/book-service') }}"
                    class="inline-flex min-h-12 items-center justify-center gap-3 rounded-full bg-[#e32636] px-7 py-3.5 text-sm font-bold text-white transition hover:bg-[#c91f2d]"
                >
                    Book a service
                    <span aria-hidden="true">↗</span>
                </a>

                <a
                    href="{{ $whatsappUrl }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex min-h-12 items-center justify-center rounded-full border border-zinc-300 bg-white px-7 py-3.5 text-sm font-bold text-zinc-800 transition hover:border-[#e32636] hover:text-[#e32636]"
                >
                    Ask us on WhatsApp
                </a>
            </div>

        </div>
    </section>
    <!-- End How It Works -->

    {{-- Offers & Rewards Section --}}
    <section id="offers" class="relative overflow-hidden bg-[#111111] py-20 text-white sm:py-24">
        <div class="absolute -right-32 top-10 h-80 w-80 rounded-full bg-red-600/10 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-5 sm:px-8 lg:px-10">

            <div class="mb-12 flex flex-col justify-between gap-5 md:flex-row md:items-end">
                <div class="max-w-2xl">
                    <p class="mb-3 text-sm font-bold uppercase tracking-[0.25em] text-red-500">
                        More value with Hitek
                    </p>

                    <h2 class="text-3xl font-black tracking-tight sm:text-4xl lg:text-5xl">
                        Offers & <span class="text-red-500">Rewards.</span>
                    </h2>

                    <p class="mt-4 max-w-xl text-sm leading-7 text-gray-400 sm:text-base">
                        Discover seasonal deals, reward opportunities and special
                        services designed to give you more value every time you
                        care for your car.
                    </p>
                </div>

                <a href="book-service"
                class="inline-flex w-fit items-center justify-center gap-2 rounded-lg bg-red-600 px-6 py-3 text-sm font-bold transition hover:bg-red-700">
                    Book a Service
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>

            {{-- Offer cards --}}
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

                {{-- Refer & Earn --}}
                <article class="group flex flex-col rounded-2xl border border-white/10 bg-white/[0.04] p-6 transition duration-300 hover:-translate-y-1 hover:border-red-500/50 hover:bg-white/[0.07]">
                    <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-xl bg-red-500/10 text-red-500">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m6-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm8-3v6m3-3h-6"/>
                        </svg>
                    </div>

                    <p class="mb-2 text-xs font-bold uppercase tracking-widest text-red-500">
                        Spread the word
                    </p>

                    <h3 class="text-xl font-bold">Refer & Earn</h3>

                    <p class="mt-3 flex-1 text-sm leading-6 text-gray-400">
                        Recommend Hitek Automobiles to friends and family.
                        Referral rewards and eligibility details can be added here.
                    </p>

                    <a href="https://wa.me/919216111868?text={{ urlencode('Hi Hitek Automobiles, please tell me about your Refer & Earn program.') }}"
                    target="_blank" rel="noopener noreferrer"
                    class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-white transition group-hover:text-red-500">
                        Enquire Now <span aria-hidden="true">&rarr;</span>
                    </a>
                </article>

                {{-- Reward Points --}}
                <article class="group flex flex-col rounded-2xl border border-white/10 bg-white/[0.04] p-6 transition duration-300 hover:-translate-y-1 hover:border-red-500/50 hover:bg-white/[0.07]">
                    <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-xl bg-red-500/10 text-red-500">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m12 3 2.7 5.5 6.1.9-4.4 4.3 1 6.1-5.4-2.9-5.4 2.9 1-6.1-4.4-4.3 6.1-.9L12 3Z"/>
                        </svg>
                    </div>

                    <p class="mb-2 text-xs font-bold uppercase tracking-widest text-red-500">
                        Every visit matters
                    </p>

                    <h3 class="text-xl font-bold">Hitek Reward Points</h3>

                    <p class="mt-3 flex-1 text-sm leading-6 text-gray-400">
                        Explore our planned customer rewards program and learn
                        how points may be earned and redeemed.
                    </p>

                    <a href="https://wa.me/919216111868?text={{ urlencode('Hi Hitek Automobiles, please tell me about your Reward Points program.') }}"
                    target="_blank" rel="noopener noreferrer"
                    class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-white transition group-hover:text-red-500">
                        Know More <span aria-hidden="true">&rarr;</span>
                    </a>
                </article>

                {{-- Festival Offers --}}
                <article class="group flex flex-col rounded-2xl border border-white/10 bg-white/[0.04] p-6 transition duration-300 hover:-translate-y-1 hover:border-red-500/50 hover:bg-white/[0.07]">
                    <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-xl bg-red-500/10 text-red-500">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v3m0 12v3M3 12h3m12 0h3M5.6 5.6l2.1 2.1m8.6 8.6 2.1 2.1m0-12.8-2.1 2.1m-8.6 8.6-2.1 2.1"/>
                            <circle cx="12" cy="12" r="5"/>
                        </svg>
                    </div>

                    <p class="mb-2 text-xs font-bold uppercase tracking-widest text-red-500">
                        Celebrate with Hitek
                    </p>

                    <h3 class="text-xl font-bold">Festival Offers</h3>

                    <p class="mt-3 flex-1 text-sm leading-6 text-gray-400">
                        Check for festive promotions and limited-time offers
                        throughout the year.
                    </p>

                    <a href="https://wa.me/919216111868?text={{ urlencode('Hi Hitek Automobiles, what festival offers are currently available?') }}"
                    target="_blank" rel="noopener noreferrer"
                    class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-white transition group-hover:text-red-500">
                        Check Offers <span aria-hidden="true">&rarr;</span>
                    </a>
                </article>

                {{-- Service Specials --}}
                <article class="group flex flex-col rounded-2xl border border-white/10 bg-white/[0.04] p-6 transition duration-300 hover:-translate-y-1 hover:border-red-500/50 hover:bg-white/[0.07]">
                    <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-xl bg-red-500/10 text-red-500">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13l2-6h14l2 6M5 13h14l1 7h-3v-2H7v2H4l1-7Zm2-6 1-3h8l1 3M7 13h.01M17 13h.01"/>
                        </svg>
                    </div>

                    <p class="mb-2 text-xs font-bold uppercase tracking-widest text-red-500">
                        Care for your car
                    </p>

                    <h3 class="text-xl font-bold">Service Specials</h3>

                    <p class="mt-3 flex-1 text-sm leading-6 text-gray-400">
                        Ask us about available deals on car servicing, detailing,
                        ceramic coating, PPF and more.
                    </p>

                    <a href="book-service"
                    class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-white transition group-hover:text-red-500">
                        Explore Services <span aria-hidden="true">&rarr;</span>
                    </a>
                </article>

            </div>

            {{-- Bottom note --}}
            <div class="mt-8 rounded-xl border border-white/10 bg-white/[0.03] px-5 py-4">
                <p class="text-xs leading-6 text-gray-500 sm:text-sm">
                    Offers, eligibility and terms may vary. Contact Hitek Automobiles
                    to confirm current promotions before booking.
                </p>
            </div>

        </div>
    </section>

    <!-- Booking CTA -->
    <section class="px-5 py-20 sm:px-8 sm:pb-24 lg:px-8">
        <div class="mx-auto max-w-7xl overflow-hidden rounded-3xl bg-[#e32636] text-white">
            <div class="grid gap-8 px-6 py-12 sm:px-10 sm:py-14 lg:grid-cols-[1fr_auto] lg:items-center lg:px-14">
                <div><p class="text-xs font-extrabold uppercase tracking-[0.22em] text-white/75">Let’s get you moving</p><h2 class="mt-4 max-w-2xl text-3xl font-black tracking-tight sm:text-4xl lg:text-5xl">Your car deserves the right kind of care.</h2><p class="mt-4 max-w-xl text-sm leading-7 text-white/85">Book a visit online or message our team to discuss your vehicle’s needs.</p></div>
                <div class="flex flex-col gap-3 sm:flex-row lg:flex-col"><a href="{{ url('/book-service') }}" class="inline-flex items-center justify-center gap-3 rounded-full bg-white px-6 py-4 text-sm font-extrabold text-zinc-900 transition hover:bg-zinc-100">Book a service <span aria-hidden="true">↗</span></a><a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-3 rounded-full border border-white/50 px-6 py-4 text-sm font-extrabold text-white transition hover:bg-white/10">Chat on WhatsApp</a></div>
            </div>
        </div>
    </section>

    <!-- Contact -->
    <section id="contact" class="border-t border-zinc-100 bg-[#f7f7f5] py-20 sm:py-24">
        <div class="mx-auto grid max-w-7xl gap-12 px-5 lg:grid-cols-[.8fr_1.2fr] lg:px-8">
            <div><p class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#e32636]">Visit Hitek</p><h2 class="mt-4 text-4xl font-black tracking-tight sm:text-5xl">Let’s talk about your car.</h2><p class="mt-5 max-w-md text-sm leading-7 text-zinc-600">Visit our workshop in Industrial Area Phase I, Chandigarh, or get in touch before you arrive.</p>
                <div class="mt-8 space-y-5">
                    <div class="flex gap-4"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white text-[#e32636] shadow-sm">⌖</span><div><p class="text-sm font-bold">Workshop address</p><p class="mt-1 text-sm leading-6 text-zinc-600">Plot No. 131, Industrial Area Phase I,<br>Chandigarh, 160002</p></div></div>
                    <div class="flex gap-4"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white text-[#e32636] shadow-sm">☎</span><div><p class="text-sm font-bold">Call us</p><a class="mt-1 block text-sm text-zinc-600 hover:text-[#e32636]" href="tel:9216111868">+91 9216111668</a></div></div>
                    <div class="flex gap-4"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white text-[#e32636] shadow-sm">◷</span><div><p class="text-sm font-bold">Opening hours</p><p class="mt-1 text-sm text-zinc-600">Monday–Saturday · 9:00 AM–7:00 PM</p><p class="text-sm text-zinc-600">Sunday · Please call ahead</p></div></div>
                </div>
                <div class="mt-8 flex flex-wrap gap-3"><a href="https://maps.google.com/?q=Plot+No+131+Industrial+Area+Phase+I+Chandigarh+160002" target="_blank" rel="noopener noreferrer" class="rounded-full bg-[#111315] px-5 py-3 text-sm font-bold text-white transition hover:bg-[#e32636]">Get directions ↗</a><a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="rounded-full border border-zinc-300 px-5 py-3 text-sm font-bold transition hover:border-[#e32636] hover:text-[#e32636]">Message us</a></div>
            </div>
            <div class="relative min-h-[320px] overflow-hidden rounded-2xl border border-zinc-200 bg-white p-3 sm:min-h-[440px]">
                <iframe title="Map showing Hitek Automobiles in Chandigarh" class="h-full min-h-[320px] w-full rounded-xl sm:min-h-[440px]" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3430.422177438461!2d76.80519751137683!3d30.706529786792274!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390fed9e85891a69%3A0xddf568be8cf5b0c7!2sHitek%20Automobiles!5e0!3m2!1sen!2sin!4v1792955526262!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
            </div>
        </div>
    </section>
</main>

<!-- Footer -->
<footer class="bg-[#111315] text-white">
    <div class="mx-auto grid max-w-7xl gap-10 px-5 py-14 sm:grid-cols-2 lg:grid-cols-[1.4fr_.8fr_.8fr_1fr] lg:px-8 lg:py-16">
        <div><a href="{{ route('home') }}" class="inline-flex items-center gap-3"><span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#e32636] text-lg font-black italic tracking-tighter text-white">H</span><span class="leading-none"><span class="block text-lg font-black tracking-[0.12em]">HITEK</span><span class="mt-1 block text-[9px] font-bold tracking-[0.28em] text-white/50">AUTOMOBILES</span></span></a><p class="mt-5 max-w-xs text-sm leading-7 text-white/55">Thoughtful car care, reliable service and a better workshop experience in Chandigarh.</p><a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="mt-5 inline-flex items-center gap-2 text-sm font-bold text-white transition hover:text-[#ff3949]">Talk to our team <span aria-hidden="true">↗</span></a></div>
        <div><h3 class="text-xs font-extrabold uppercase tracking-[0.18em] text-white/40">Explore</h3><ul class="mt-5 space-y-3 text-sm text-white/70"><li><a class="transition hover:text-white" href="#about">About Hitek</a></li><li><a class="transition hover:text-white" href="#services">Our services</a></li><li><a class="transition hover:text-white" href="#workshop">Our workshop</a></li><li><a class="transition hover:text-white" href="#offers">Offers</a></li></ul></div>
        <div><h3 class="text-xs font-extrabold uppercase tracking-[0.18em] text-white/40">Popular services</h3><ul class="mt-5 space-y-3 text-sm text-white/70"><li><a class="transition hover:text-white" href="{{ url('/book-service') }}">Car servicing</a></li><li><a class="transition hover:text-white" href="{{ url('/book-service') }}">Denting & painting</a></li><li><a class="transition hover:text-white" href="{{ url('/book-service') }}">Ceramic coating</a></li><li><a class="transition hover:text-white" href="{{ url('/book-service') }}">Insurance assistance</a></li></ul></div>
        <div><h3 class="text-xs font-extrabold uppercase tracking-[0.18em] text-white/40">Contact</h3><p class="mt-5 text-sm leading-6 text-white/70">Plot No. 131, Industrial Area Phase I, Chandigarh, 160002</p><a class="mt-3 block text-sm text-white/70 transition hover:text-white" href="tel:9216111868">+91 9216111668</a><a class="mt-3 block break-all text-sm text-white/70 transition hover:text-white" href="mailto:info@hitekmotorz.in">info@hitekmotorz.in</a></div>
    </div>
    <div class="border-t border-white/10"><div class="mx-auto flex max-w-7xl flex-col gap-3 px-5 py-5 text-xs text-white/40 sm:flex-row sm:items-center sm:justify-between lg:px-8"><p>© {{ date('Y') }} Hitek Automobiles. All rights reserved.</p><div class="flex gap-5"><a class="transition hover:text-white" href="#contact">Contact</a><a class="transition hover:text-white" href="{{ route('login') }}">Employee login</a></div><p>Made for better journeys.</p></div></div>
</footer>

<!-- Mobile booking shortcut -->
<div class="fixed inset-x-0 bottom-0 z-40 grid grid-cols-2 gap-2 border-t border-zinc-200 bg-white/95 p-3 backdrop-blur md:hidden">
    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center rounded-full border border-zinc-200 px-3 py-3 text-sm font-bold text-zinc-800">WhatsApp</a>
    <a href="{{ url('/book-service') }}" class="flex items-center justify-center rounded-full bg-[#e32636] px-3 py-3 text-sm font-bold text-white">Book a service</a>
</div>
<div class="h-20 md:hidden"></div>

<script>
    (() => {
        const button = document.getElementById('mobile-menu-button');
        const menu = document.getElementById('mobile-menu');
        const openIcon = document.getElementById('menu-open-icon');
        const closeIcon = document.getElementById('menu-close-icon');
        if (!button || !menu) return;
        button.addEventListener('click', () => {
            const isOpen = button.getAttribute('aria-expanded') === 'true';
            button.setAttribute('aria-expanded', String(!isOpen));
            button.setAttribute('aria-label', isOpen ? 'Open navigation menu' : 'Close navigation menu');
            menu.classList.toggle('hidden', isOpen);
            openIcon?.classList.toggle('hidden', !isOpen);
            closeIcon?.classList.toggle('hidden', isOpen);
        });
        menu.querySelectorAll('.mobile-menu-link').forEach((link) => {
            link.addEventListener('click', () => {
                menu.classList.add('hidden');
                button.setAttribute('aria-expanded', 'false');
                button.setAttribute('aria-label', 'Open navigation menu');
                openIcon?.classList.remove('hidden');
                closeIcon?.classList.add('hidden');
            });
        });
    })();
</script>
</body>
</html>
