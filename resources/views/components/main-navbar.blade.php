<nav class="bg-white fixed w-full z-20 top-0 start-0 border-b border-default">
    <div class="max-w-screen-2xl flex flex-wrap items-center justify-between mx-auto py-4 px-3 md:px-12">
        <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('images/logo.jpg') }}" class="h-12" alt="Flowbite Logo">
        </a>
        {{-- <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            <button type="button" class=" bg-primary box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-lg text-sm px-3 py-2 focus:outline-none">Get started</button>
            <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-body rounded-base md:hidden hover:bg-neutral-secondary-soft hover:text-heading focus:outline-none focus:ring-2 focus:ring-neutral-tertiary" aria-controls="navbar-sticky" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14"/></svg>
            </button>
        </div> --}}

        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
            <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-default rounded-base md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 text-gray-800">
                <li>
                <a href="#" class="block py-2 px-3  bg-brand rounded-sm md:bg-transparent md:p-0" aria-current="page">Home</a>
                </li>
                <li>
                <a href="#" class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">About</a>
                </li>
                <li>
                <a href="#" class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">Services</a>
                </li>
                <li>
                <a href="#" class="block py-2 px-3 text-heading rounded hover:bg-neutral-tertiary md:hover:bg-transparent md:border-0 md:hover:text-fg-brand md:p-0 md:dark:hover:bg-transparent">Contact</a>
                </li>
            </ul>
        </div>

        <div class="md:order-2 hidden md:flex items-center justify-between gap-8">
            <div class="flex items-center justify-center gap-3">
                <button class="rounded-full bg-primary text-white w-11 h-11 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24"><!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE --><path fill="currentColor" d="M19.95 21q-3.125 0-6.175-1.362t-5.55-3.863t-3.862-5.55T3 4.05q0-.45.3-.75t.75-.3H8.1q.35 0 .625.238t.325.562l.65 3.5q.05.4-.025.675T9.4 8.45L6.975 10.9q.5.925 1.187 1.787t1.513 1.663q.775.775 1.625 1.438T13.1 17l2.35-2.35q.225-.225.588-.337t.712-.063l3.45.7q.35.1.575.363T21 15.9v4.05q0 .45-.3.75t-.75.3"/></svg>
                </button>
                <div>
                    <h4 class="text-gray-800">we are always 24/7</h4>
                    <h3 class="text-primary font-bold">+91-9216111868</h3>
                </div>
            </div>
            <button class="border border-primary rounded-full text-primary font-bold px-5 py-2 flex items-center justify-between gap-2 hover:bg-primary hover:text-white cursor-pointer">
                Call Now
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24"><!-- Icon from Solar by 480 Design - https://creativecommons.org/licenses/by/4.0/ --><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m6 18l2.5-2.5M18 6H9m9 0v9m0-9l-6.5 6.5"/></svg>
            </button>
        </div>


    </div>
</nav>