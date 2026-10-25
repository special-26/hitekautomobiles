
<div class="min-h-screen bg-gray-50 text-gray-900">

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-[#111111] text-white">
        <div class="absolute -right-24 -top-24 h-80 w-80 rounded-full bg-red-600/20 blur-3xl"></div>

        <div class="relative mx-auto grid max-w-7xl gap-10 px-5 py-14 sm:px-8 sm:py-20 lg:grid-cols-2 lg:items-center lg:py-24">
            <div>
                <p class="mb-4 text-sm font-bold uppercase tracking-[0.25em] text-red-500">
                    Hitek Automobiles · Chandigarh
                </p>

                <h1 class="max-w-xl text-4xl font-black leading-tight sm:text-5xl lg:text-6xl">
                    Your car deserves
                    <span class="text-red-500">better care.</span>
                </h1>

                <p class="mt-5 max-w-lg leading-7 text-gray-400">
                    Book your preferred service with Hitek Automobiles.
                    From regular maintenance to detailing, paint protection
                    and bodywork, our team is here to help.
                </p>

                <div class="mt-8 flex flex-wrap gap-4 text-sm text-gray-300">
                    <span>✓ Multiple services</span>
                    <span>✓ Convenient booking</span>
                    <span>✓ Personal assistance</span>
                </div>
            </div>

            <div class="rounded-2xl border border-white/10 bg-white/[0.05] p-6 sm:p-8">
                <p class="text-sm font-semibold text-red-500">BOOK YOUR VISIT</p>
                <h2 class="mt-2 text-2xl font-bold sm:text-3xl">
                    Let's get started.
                </h2>
                <p class="mt-2 text-sm leading-6 text-gray-400">
                    Fill in your details and preferred appointment time.
                </p>

                <a href="#booking-form"
                   class="mt-6 inline-flex w-full items-center justify-center rounded-lg bg-red-600 px-6 py-3.5 font-bold text-white transition hover:bg-red-700">
                    Start Your Booking
                    <span class="ml-2" aria-hidden="true">↓</span>
                </a>

                <p class="mt-4 text-center text-xs text-gray-500">
                    No account required.
                </p>
            </div>
        </div>
    </section>

    {{-- Booking form --}}
    <section id="booking-form" class="mx-auto max-w-5xl scroll-mt-8 px-5 py-12 sm:px-8 sm:py-16">

        <div class="mb-8">
            <p class="text-sm font-bold uppercase tracking-widest text-red-600">
                Appointment request
            </p>
            <h2 class="mt-2 text-3xl font-black sm:text-4xl">
                Book a service
            </h2>
            <p class="mt-3 text-sm leading-6 text-gray-500">
                Fields marked with * are required. Choose your preferred
                time; final availability will be verified by the workshop.
            </p>
        </div>

        @if ($submitted)
            <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-5 text-green-800">
                Your details have been validated.
            </div>
        @endif

        <form wire:submit="submit" id="booking-form-fields" class="space-y-8">

            {{-- Customer details --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-8">
                <div class="mb-6 flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-50 font-bold text-red-600">01</span>
                    <div>
                        <h3 class="text-lg font-bold">Your details</h3>
                        <p class="text-sm text-gray-500">How can we contact you?</p>
                    </div>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="customerName" class="mb-2 block text-sm font-semibold">
                            Full name *
                        </label>
                        <input id="customerName" type="text"
                               wire:model="customerName"
                               autocomplete="name"
                               placeholder="Enter your full name"
                               class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-100">
                        @error('customerName')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="mb-2 block text-sm font-semibold">
                            Mobile number *
                        </label>
                        <input id="phone" type="tel"
                               wire:model="phone"
                               inputmode="numeric"
                               maxlength="10"
                               autocomplete="tel-national"
                               placeholder="10-digit mobile number"
                               class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-100">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="email" class="mb-2 block text-sm font-semibold">
                            Email address <span class="font-normal text-gray-400">(optional)</span>
                        </label>
                        <input id="email" type="email"
                               wire:model="email"
                               autocomplete="email"
                               placeholder="you@example.com"
                               class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-100">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Vehicle details --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-8">
                <div class="mb-6 flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-50 font-bold text-red-600">02</span>
                    <div>
                        <h3 class="text-lg font-bold">Vehicle details</h3>
                        <p class="text-sm text-gray-500">Tell us which car needs attention.</p>
                    </div>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="vehicleMake" class="mb-2 block text-sm font-semibold">
                            Car make *
                        </label>
                        <input id="vehicleMake" type="text"
                               wire:model="vehicleMake"
                               placeholder="e.g. Maruti Suzuki, Hyundai"
                               class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100">
                        @error('vehicleMake')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="vehicleModel" class="mb-2 block text-sm font-semibold">
                            Model / variant *
                        </label>
                        <input id="vehicleModel" type="text"
                               wire:model="vehicleModel"
                               placeholder="e.g. Swift VXi, Creta SX"
                               class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100">
                        @error('vehicleModel')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="registrationNumber" class="mb-2 block text-sm font-semibold">
                            Registration number <span class="font-normal text-gray-400">(optional)</span>
                        </label>
                        <input id="registrationNumber" type="text"
                               wire:model="registrationNumber"
                               placeholder="e.g. CH01AB1234"
                               class="w-full rounded-lg border border-gray-300 px-4 py-3 uppercase outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100">
                        @error('registrationNumber')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Service selection --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-8">
                <div class="mb-6 flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-50 font-bold text-red-600">03</span>
                    <div>
                        <h3 class="text-lg font-bold">What does your car need?</h3>
                        <p class="text-sm text-gray-500">Select the service you want to discuss.</p>
                    </div>
                </div>

                <div class="grid gap-3 sm:grid-cols-2">
                    @php
                        $serviceOptions = [
                            'regular-service' => 'Regular Service & Maintenance',
                            'denting-painting' => 'Denting & Painting',
                            'car-washing' => 'Car Washing',
                            'detailing' => 'Car Detailing',
                            'ceramic-coating' => 'Ceramic Coating',
                            'ppf' => 'Paint Protection Film (PPF)',
                            'insurance' => 'Insurance Assistance / Claims',
                            'other' => 'Other / Multiple Services',
                        ];
                    @endphp

                    @foreach ($serviceOptions as $value => $label)
                        <label class="flex cursor-pointer items-start gap-3 rounded-xl border p-4 transition
                            {{ $serviceCategory === $value ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-gray-400' }}">
                            <input type="radio"
                                   wire:model.live="serviceCategory"
                                   value="{{ $value }}"
                                   class="mt-1 accent-red-600">
                            <span class="text-sm font-semibold">{{ $label }}</span>
                        </label>
                    @endforeach
                </div>

                @error('serviceCategory')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <div class="mt-5">
                    <label for="serviceDetails" class="mb-2 block text-sm font-semibold">
                        Additional requirements
                        <span class="font-normal text-gray-400">(optional)</span>
                    </label>
                    <textarea id="serviceDetails"
                              wire:model="serviceDetails"
                              rows="4"
                              placeholder="Describe the issue, work required, or any special requests..."
                              class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100"></textarea>
                    @error('serviceDetails')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Appointment preferences --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-8">
                <div class="mb-6 flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-50 font-bold text-red-600">04</span>
                    <div>
                        <h3 class="text-lg font-bold">Preferred appointment</h3>
                        <p class="text-sm text-gray-500">Choose your preferred date and time.</p>
                    </div>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="preferredDate" class="mb-2 block text-sm font-semibold">
                            Preferred date *
                        </label>
                        <input id="preferredDate"
                               type="date"
                               wire:model="preferredDate"
                               min="{{ now()->toDateString() }}"
                               class="w-full rounded-lg border border-gray-300 px-4 py-3 outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100">
                        @error('preferredDate')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="preferredTime" class="mb-2 block text-sm font-semibold">
                            Preferred time *
                        </label>
                        <select id="preferredTime"
                                wire:model="preferredTime"
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100">
                            <option value="">Choose a preferred time</option>
                            <option value="09:00">9:00 AM</option>
                            <option value="10:00">10:00 AM</option>
                            <option value="11:00">11:00 AM</option>
                            <option value="12:00">12:00 PM</option>
                            <option value="13:00">1:00 PM</option>
                            <option value="14:00">2:00 PM</option>
                            <option value="15:00">3:00 PM</option>
                            <option value="16:00">4:00 PM</option>
                            <option value="17:00">5:00 PM</option>
                        </select>
                        @error('preferredTime')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <p class="mt-4 rounded-lg bg-amber-50 p-4 text-sm leading-6 text-amber-800">
                    Your selected date and time are preferences, not a confirmed
                    reservation. Final availability must be checked by Hitek
                    Automobiles before the appointment is confirmed.
                </p>
            </div>

            {{-- Submit --}}
            <div class="rounded-2xl bg-[#111111] p-6 text-white sm:p-8">
                <h3 class="text-xl font-bold">Ready to take the next step?</h3>
                <p class="mt-2 text-sm leading-6 text-gray-400">
                    Review your information before submitting your appointment request.
                </p>

                <button type="submit"
                        wire:loading.attr="disabled"
                        wire:target="submit"
                        class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-red-600 px-6 py-4 font-bold text-white transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-60 sm:w-auto">
                    <span wire:loading.remove wire:target="submit">
                        Submit Booking Request →
                    </span>
                    <span wire:loading wire:target="submit">
                        Validating details...
                    </span>
                </button>

                <p class="mt-4 text-xs leading-5 text-gray-500">
                    By submitting, you agree that Hitek Automobiles may contact
                    you about this service request.
                </p>
            </div>

        </form>
    </section>

    {{-- Contact strip --}}
    <section class="border-t border-gray-200 bg-white">
        <div class="mx-auto flex max-w-7xl flex-col gap-4 px-5 py-8 sm:px-8 md:flex-row md:items-center md:justify-between">
            <div>
                <h3 class="font-bold">Need help choosing a service?</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Speak directly with the Hitek Automobiles team.
                </p>
            </div>

            <a href="https://wa.me/919216111868?text={{ urlencode('Hi Hitek Automobiles, I need help booking a car service.') }}"
               target="_blank"
               rel="noopener noreferrer"
               class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-5 py-3 text-sm font-bold transition hover:border-red-500 hover:text-red-600">
                Contact us on WhatsApp
            </a>
        </div>
    </section>

</div>
