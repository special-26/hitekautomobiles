<x-layouts.app>
    <x-main-navbar></x-main-navbar>

    <x-carousel></x-carousel>

    <section class="w-full py-12">
        <div class="grid grid-cols-3 px-12 items-center">
            <div class="">
                <h4 class="text-primary uppercase font-bold">/ Why choose us? /</h4>
                <h2 class="text-[3.5em] font-bold text-gray-800">What makes us <br/> <span class="text-primary">different?</span></h2>
                <p class="text-gray-700">We carefully screen all of our cleaners, so you can rest assured that your home would receive the absolute highest quality of service providing. Ultricies tristique nulla aliquet enim tortor at auctor urna nunc.</p>
                <button class="border border-primary rounded-full text-primary font-bold px-5 py-2 flex items-center justify-between gap-2 hover:bg-primary hover:text-white cursor-pointer mt-10">
                    Know More
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m6 18l2.5-2.5M18 6H9m9 0v9m0-9l-6.5 6.5"/></svg>
                </button>
            </div>

            <img src="images/car.svg" />

            <div class="space-y-6 lg:space-y-10">
                <!-- Icon Block -->
                <div class="flex gap-x-5 sm:gap-x-8">
                    <!-- Icon -->
                    <span class="shrink-0 inline-flex justify-center items-center size-11 rounded-full border border-gray-200 bg-primary text-white shadow-2xs mx-auto">
                    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    </span>
                    <div class="grow">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800">
                        Experienced Mechanics
                    </h3>
                    <p class="mt-1 text-gray-500 text-sm">
                        We had technical knowledge and physical abilities, important to practice and learn Mechanics
                    </p>
                    </div>
                </div>
                <!-- End Icon Block -->

                <!-- Icon Block -->
                <div class="flex gap-x-5 sm:gap-x-8">
                    <!-- Icon -->
                    <span class="shrink-0 inline-flex justify-center items-center size-11 rounded-full border border-gray-200 bg-primary text-white shadow-2xs mx-auto">
                    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 9a2 2 0 0 1-2 2H6l-4 4V4c0-1.1.9-2 2-2h8a2 2 0 0 1 2 2v5Z"/><path d="M18 9h2a2 2 0 0 1 2 2v11l-4-4h-6a2 2 0 0 1-2-2v-1"/></svg>
                    </span>
                    <div class="grow">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800">
                        Quality Service
                    </h3>
                    <p class="mt-1 text-gray-500 text-sm">
                        Our skilled technicians arrive equipped with the necessary tools and expertise.
                    </p>
                    </div>
                </div>
                <!-- End Icon Block -->

                <!-- Icon Block -->
                <div class="flex gap-x-5 sm:gap-x-8">
                    <!-- Icon -->
                    <span class="shrink-0 inline-flex justify-center items-center size-11 rounded-full border border-gray-200 bg-primary text-white shadow-2xs mx-auto">
                    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 10v12"/><path d="M15 5.88 14 10h5.83a2 2 0 0 1 1.92 2.56l-2.33 8A2 2 0 0 1 17.5 22H4a2 2 0 0 1-2-2v-8a2 2 0 0 1 2-2h2.76a2 2 0 0 0 1.79-1.11L12 2h0a3.13 3.13 0 0 1 3 3.88Z"/></svg>
                    </span>
                    <div class="grow">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800">
                        Quality Equipment
                    </h3>
                    <p class="mt-1 text-gray-500 text-sm">
                        Choosing the right equipment for your auto can spell the difference between other service.
                    </p>
                    </div>
                </div>
                <!-- End Icon Block -->
            </div>
            <!-- End Col -->
        </div>
    </section>

    {{-- rotating service row --}}
    <div class="relative flex overflow-x-hidden text-gray-800 shadow border-y">
        <div class="py-5 animate-marquee whitespace-nowrap">
            <span class="text-4xl mx-4 pbmit-element-title">Insurance</span>
            <span class="text-4xl mx-4 pbmit-element-title">Battery</span>
            <span class="text-4xl mx-4 pbmit-element-title">Alignment</span>
            <span class="text-4xl mx-4 pbmit-element-title">Repair</span>
            <span class="text-4xl mx-4 pbmit-element-title">Engine</span>
        </div>

        <div class="absolute top-0 py5 animate-marquee2 whitespace-nowrap">
            <span class="text-4xl mx-4 pbmit-element-title">Insurance</span>
            <span class="text-4xl mx-4 pbmit-element-title">Battery</span>
            <span class="text-4xl mx-4 pbmit-element-title">Alignment</span>
            <span class="text-4xl mx-4 pbmit-element-title">Repair</span>
            <span class="text-4xl mx-4 pbmit-element-title">Engine</span>
        </div>
    </div>

    {{-- Our service --}}
    <section class="w-full p-12">
        <div class="mb-12 ">
            <h4 class="text-primary uppercase font-bold">/ Our Service /</h4>
            <h2 class="text-[3.5em] font-bold text-gray-800 leading-none">We offer a <span class="text-primary">wide range</span> <br/> of car serives</h2>
        </div>
        <!-- Card Blog -->
        <div class="mx-auto">
            <!-- Grid -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Card -->
                <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-2xs rounded-2xl">
                    <div class="h-52 flex flex-col justify-center items-center bg-blue-600 rounded-t-xl mb-6 relative">
                        <img src="https://karsfix-demo.pbminfotech.com/demo1/wp-content/uploads/sites/2/2024/09/service-img-01-880x520.jpg" class="rounded-2xl"/>
                        <button class="h-14 w-14 rounded-full text-white bg-primary flex items-center justify-center absolute right-2 -bottom-12 border-6 border-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m13.292 12l-4.6-4.6l.708-.708L14.708 12L9.4 17.308l-.708-.708z"/></svg>
                        </button>
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold text-gray-800">Maintenance</h3>
                        <p class="mt-3 text-gray-500 dark:text-neutral-500">Some routine car care tasks can be done at home, while other may require a trained technician or</p>
                    </div>
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-2xs rounded-2xl">
                    <div class="h-52 flex flex-col justify-center items-center bg-blue-600 rounded-t-xl mb-6 relative">
                        <img src="https://karsfix-demo.pbminfotech.com/demo1/wp-content/uploads/sites/2/2024/09/service-img-01-880x520.jpg" class="rounded-2xl"/>
                        <button class="h-14 w-14 rounded-full text-white bg-primary flex items-center justify-center absolute right-2 -bottom-12 border-6 border-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m13.292 12l-4.6-4.6l.708-.708L14.708 12L9.4 17.308l-.708-.708z"/></svg>
                        </button>
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold text-gray-800">Wheel Aligment</h3>
                        <p class="mt-3 text-gray-500 dark:text-neutral-500">Wheel aligment refers to the adjustment of car's suspension the system connecting the wheels to the</p>
                    </div>
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-2xs rounded-2xl">
                    <div class="h-52 flex flex-col justify-center items-center bg-blue-600 rounded-t-xl mb-6 relative">
                        <img src="https://karsfix-demo.pbminfotech.com/demo1/wp-content/uploads/sites/2/2024/09/service-img-01-880x520.jpg" class="rounded-2xl"/>
                        <button class="h-14 w-14 rounded-full text-white bg-primary flex items-center justify-center absolute right-2 -bottom-12 border-6 border-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m13.292 12l-4.6-4.6l.708-.708L14.708 12L9.4 17.308l-.708-.708z"/></svg>
                        </button>
                    </div>
                    <div class="p-4">
                        <h3 class="text-xl font-semibold text-gray-800">Engine Service</h3>
                        <p class="mt-3 text-gray-500 dark:text-neutral-500">Engine oil is an integral part of your car engine's system help to maintain the temprature of the</p>
                    </div>
                </div>
                <!-- End Card -->

        </div>
        <!-- End Card Blog --> 

    </section>

    {{-- Testimonials --}}
    <section class="w-full p-12">
        <div class="mb-12 ">
            <h4 class="text-primary uppercase font-bold">/ Testimonials /</h4>
            <h2 class="text-[3.5em] font-bold text-gray-800 leading-none">What our <span class="text-primary">cleints say</span> <br/> about us</h2>
        </div>
        <!-- Card Blog -->
        
        <!-- Testimonials -->
        <div class="py-10 md:py-16 lg:py-20 bg-blue-50 rounded-2xl">
            <div class="px-4 sm:px-6 lg:px-8">
                <!-- Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 md:items-center">
                <div class="relative h-80 md:h-150 bg-gray-100 rounded-2xl">
                    <img class="absolute inset-0 size-full object-cover rounded-2xl" src="https://images.unsplash.com/photo-1507914464562-6ff4ac29692f?q=80&w=768&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Testimonials Image">
                </div>
                <!-- End Col -->

                <div class="pt-10 md:p-10">
                    <blockquote class="max-w-4xl mx-auto">
                    <p class="mb-6 md:text-lg text-gray-700">
                        A Family Tradition of Rich, Aromatic Coffee
                    </p>

                    <p class="text-xl sm:text-2xl lg:text-3xl lg:leading-normal text-gray-800">
                        Coffee has the power to connect generations – whether it's learning grandma's brewing techniques and trying to perfect them just like her or the intense memories triggered by the rich flavors and aromas of our favorite coffee blends.
                    </p>

                    <footer class="mt-6 md:mt-10">
                        <div class="border-neutral-700">
                        <button type="button" class="group inline-flex items-center gap-x-3 text-gray-800 text-sm focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none">
                            <span class="size-8 md:size-10 flex flex-col justify-center items-center bg-black text-white rounded-full group-hover:scale-105 group-focus:scale-105 transition-transform duration-300 ease-in-out">
                            <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393"/></svg>
                            </span>
                            Watch the Video
                        </button>
                        </div>
                    </footer>
                    </blockquote>
                </div>
                <!-- End Col -->
                </div>
                <!-- End Grid -->
            </div>
        </div>
        <!-- End Testimonials -->

    </section>

    {{-- Cost Calculator --}}
    <section class="w-full">
        <!-- Hero -->
        <div 
            style="background-image: url('{{ asset('images/cost-bg.jpg') }}')" 
            class="relative bg-cover bg-center bg-no-repeat"
        >
            <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
                <!-- Grid -->
                <div class="grid items-center md:grid-cols-2 gap-8 lg:gap-12">

                    <!-- Form -->
                    <form>
                        <div class="lg:max-w-lg lg:mx-auto lg:me-0 ms-auto">
                            <!-- Card -->
                            <div class="p-8 flex flex-col bg-white rounded-3xl shadow-lg dark:bg-neutral-900">
                                <div class="">
                                    <h4 class="text-primary uppercase font-bold text-sm mb-3">/ Cost calculator /</h4>
                                    <h2 class="text-[3em] font-bold text-white leading-none">What our <span class="text-primary">cleints say</span> <br/> about us</h2>
                                </div>

                                <div class="mt-5">

                                    <!-- Grid -->
                                    <div class="grid grid-cols-2 gap-4">
                                    <!-- Input Group -->
                                    <div>
                                        <input class="rounded-full px-5 py-4 border border-gray-600 text-sm w-full" placeholder="Choose a Service" />
                                    </div>
                                    <!-- End Input Group -->

                                    <!-- Input Group -->
                                    <div>
                                    <input class="rounded-full px-5 py-4 border border-gray-600 text-sm w-full" placeholder="dd/mm/yyyy" />
                                    </div>
                                    <!-- End Input Group -->

                                    <!-- Input Group -->
                                    <div>
                                        <input class="rounded-full px-5 py-4 border border-gray-600 text-sm w-full" placeholder="Your Name" />
                                    </div>
                                    <!-- End Input Group -->

                                    <!-- Input Group -->
                                    <div>
                                    <input class="rounded-full px-5 py-4 border border-gray-600 text-sm w-full" placeholder="Phone Number" />
                                    </div>
                                    <!-- End Input Group -->

                                    <!-- Input Group -->
                                    <div class="relative col-span-full">
                                    <input class="rounded-full px-5 py-4 w-full border border-gray-600 text-sm" placeholder="Email Address" />
                                    </div>
                                    <!-- End Input Group -->

                                    </div>
                                    <!-- End Grid -->

                                    <div class="mt-5">
                                        <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-full border border-transparent bg-white text-gray-800 hover:bg-blue-700 hover:text-white cursor-pointer focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">Get started</button>
                                    </div>
                                </div>
                            </div>
                            <!-- End Card -->
                        </div>
                    </form>
                    <!-- End Form -->

                    <div></div>
                </div>
                <!-- End Grid -->
            </div>
        </div>
        <!-- End Hero -->
    </section>

    {{-- Latest Blogs --}}
    <x-latest-blog />

    <x-main-footer />

</x-layouts.app>