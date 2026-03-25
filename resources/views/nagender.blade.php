<x-layouts.app>

    <x-slot name="title">
        Rahul Sharma - Service Advisor
    </x-slot>

    <x-slot name="meta">
        <meta property="og:title" content="Rahul Sharma - Service Advisor | Hitek Automobiles">
        <meta property="og:description" content="📞 98XXXXXXX | Your dedicated service advisor">
        <meta property="og:image" content="{{ asset('images/vb.png') }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="profile">
    </x-slot>

    <x-mobile-navbar></x-mobile-navbar>

    <div class="w-full h-full bg-gray-50">
        <div class="w-full bg-white max-w-3xl py-16 mx-auto">
            <div class="header-card relative">
                <img src="{{ asset('images/slide-2.jpg') }}" alt="hitek automobiles" class="h-[30vh] w-full object-cover">
                <div class="absolute -bottom-16 left-0 right-0 flex items-center justify-center">
                    <img src="https://images.pexels.com/photos/2379004/pexels-photo-2379004.jpeg" alt="" class="h-40 w-40 rounded-3xl object-cover border-4 border-white">
                </div>
            </div>
            <div class="card-details mt-20 px-6 text-center">
                <h4 class="text-gray-900 font-bold text-xl">Nagender Sharma</h4>
                <h5 class="text-gray-700 text-sm">Body Shop Advisor</h5>
            </div>

            <div class="card-links p-6 max-w-sm mx-auto">
                <button class="border border-gray-300 shadow-lg rounded-xl text-gray-700 w-full py-3">
                    <a href="tel:+919216721868" class="flex items-center justify-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" viewBox="0 0 24 24"><!-- Icon from Material Symbols by Google - https://github.com/google/material-design-icons/blob/master/LICENSE --><path fill="currentColor" d="m18 10l-1.45-1.4l1.6-1.6H13V5h5.15L16.6 3.45L18 2l4 4.05zm1.95 11q-3.125 0-6.187-1.35T8.2 15.8t-3.85-5.55T3 4.05V3h5.9l.925 5.025l-2.85 2.875q.55.975 1.225 1.85t1.45 1.625q.725.725 1.588 1.388T13.1 17l2.9-2.9l5 1.025V21z"/></svg>
                        Call Now
                    </a>
                </button>
                <button class="border border-gray-300 shadow-lg rounded-xl text-gray-700 w-full py-3 mt-5">
                    <a href="https://maps.app.goo.gl/VLQVu9eaikCVyoat6" target="_blank" class="flex items-center justify-center gap-3">
                        📍 Get Workshop Direction
                    </a>
                </button>
            </div>

            <div class="card-actions px-5 py-5 border-t">
                <h2 class="text-gray-800 text-xl font-bold mb-2">Map Location</h2>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3430.437418242554!2d76.80559837500729!3d30.706101174597134!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390fed9e85891a69%3A0xddf568be8cf5b0c7!2sHitek%20Automobiles!5e0!3m2!1sen!2sin!4v1774345510229!5m2!1sen!2sin" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</x-layouts.app>
