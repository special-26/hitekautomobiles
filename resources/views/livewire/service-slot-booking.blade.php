<div class="max-w-2xl mx-auto p-4 text-gray-800">
    <h2 class="text-2xl font-bold mb-4">Book a Car Service Slot</h2>

    @if($successMessage)
        <div class="mb-4 rounded p-3 bg-green-100 text-green-800">
            {{ $successMessage }}
        </div>
    @endif

    <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Select Date</label>
        <input type="date" wire:model.live="service_date" class="w-full border rounded p-2">
        @error('service_date') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Available Slots</label>

        @if(empty($availableSlots))
            <div class="rounded p-3 bg-gray-100">
                No slots available for this date. Please choose another date.
            </div>
        @else
            <div class="grid grid-cols-2 gap-2">
                @foreach($availableSlots as $slot)
                    <label class="border rounded p-2 flex items-center gap-2 cursor-pointer">
                        <input type="radio" wire:model.live="slot_key" value="{{ $slot }}">
                        <span>{{ $slot }}</span>
                    </label>
                @endforeach
            </div>
        @endif

        @error('slot_key') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <div>
            <label class="block text-sm font-medium mb-1">Name</label>
            <input type="text" wire:model="customer_name" class="w-full border rounded p-2" placeholder="Customer name">
            @error('customer_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Phone</label>
            <input type="text" wire:model="phone" class="w-full border rounded p-2" placeholder="Mobile number">
            @error('phone') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Email (optional)</label>
            <input type="email" wire:model="email" class="w-full border rounded p-2" placeholder="Email">
            @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Service Type (optional)</label>
            <input type="text" wire:model="service_type" class="w-full border rounded p-2" placeholder="General / Detailing / AC / etc.">
            @error('service_type') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Car Number (optional)</label>
            <input type="text" wire:model="car_number" class="w-full border rounded p-2" placeholder="PBxx...">
            @error('car_number') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Car Make/Model (optional)</label>
            <input type="text" wire:model="car_make" class="w-full border rounded p-2 mb-2" placeholder="Maruti / Hyundai / etc.">
            <input type="text" wire:model="car_model" class="w-full border rounded p-2" placeholder="Swift / i20 / etc.">
        </div>

        <div class="md:col-span-2">
            <label class="block text-sm font-medium mb-1">Notes (optional)</label>
            <textarea wire:model="notes" class="w-full border rounded p-2" rows="3" placeholder="Any specific issue, pickup request, etc."></textarea>
            @error('notes') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    <button
        wire:click="book"
        wire:loading.attr="disabled"
        class="mt-4 w-full rounded bg-black text-white p-3"
    >
        <span wire:loading.remove>Confirm Booking</span>
        <span wire:loading>Booking...</span>
    </button>
</div>