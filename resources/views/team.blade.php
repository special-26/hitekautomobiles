<x-layouts.app>
    <x-main-navbar></x-main-navbar>

    <div class="w-full py-20">
        <section class="head-text text-center py-12 max-w-4xl mx-auto">
            <h1 class="text-gray-800 font-bold text-3xl">The Hands That Keep You Rolling</h1>
            <h3 class="text-gray-800 mb-4">Decades of experience, a lifetime of passion, and the tools to get the job done right.</h3>
            <p class="text-gray-600">At Hitek Automobiles, we don’t just swap parts; we solve problems. Our team is comprised technicians who treat every vehicle like it’s their own. When you leave your keys with us, you’re leaving them with experts who know cars inside and out.</p>
        </section>

        <section class="grid grid-cols-4 gap-5 max-w-7xl mx-auto">
            <div class="card h-[320px] rounded-2xl overflow-hidden relative shadow-xl border-4">
                <img src="https://images.pexels.com/photos/2379004/pexels-photo-2379004.jpeg" alt="" class="object-cover w-full h-full">
                <div class="absolute bottom-0 left-0 right-0 p-2">
                    <div class="bg-white/95 rounded-xl p-3">
                        <h4 class="text-gray-900 font-bold text-lg">Tarun Joshi</h4>
                        <h5 class="text-gray-700 text-sm"></h5>
                    </div>
                </div>
            </div>
            <div class="card h-[320px] rounded-2xl overflow-hidden relative shadow-xl border-4">
                <img src="https://images.pexels.com/photos/2379004/pexels-photo-2379004.jpeg" alt="" class="object-cover w-full h-full">
                <a href="{{ route('nagender') }}" class="absolute bottom-0 left-0 right-0 p-2">
                    <div class="bg-white/95 rounded-xl p-3">
                        <h4 class="text-gray-900 font-bold text-lg">Nagender Sharma</h4>
                        <h5 class="text-gray-700 text-sm">Body Shop Advisor</h5>
                    </div>
                </a>
            </div>
            <div class="card h-[320px] rounded-2xl overflow-hidden relative shadow-xl border-4">
                <img src="https://images.pexels.com/photos/2379004/pexels-photo-2379004.jpeg" alt="" class="object-cover w-full h-full">
                <div class="absolute bottom-0 left-0 right-0 p-2">
                    <div class="bg-white/95 rounded-xl p-3">
                        <h4 class="text-gray-900 font-bold text-lg">Basant Joshi</h4>
                        <h5 class="text-gray-700 text-sm">Bodyshop Incharge</h5>
                    </div>
                </div>
            </div>
            <div class="card h-[320px] rounded-2xl overflow-hidden relative shadow-xl border-4">
                <img src="https://images.pexels.com/photos/2379004/pexels-photo-2379004.jpeg" alt="" class="object-cover w-full h-full">
                <div class="absolute bottom-0 left-0 right-0 p-2">
                    <div class="bg-white/95 rounded-xl p-3">
                        <h4 class="text-gray-900 font-bold text-lg">Ankit Sandhu</h4>
                        <h5 class="text-gray-700 text-sm">Service Advisor</h5>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-layouts.app>
