<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                Service Tasks
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Manage predefined services used when creating job card tasks.
            </p>
        </div>

        <button
            type="button"
            wire:click="$set('showAddServiceModal', true)"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-hitek-red px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-hitek-red-hover"
        >
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 5v14M5 12h14"/>
            </svg>

            Add Service
        </button>

    </div>

    {{-- Search --}}
    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">

        <div class="relative max-w-xl">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z"/>
            </svg>

            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search service, category or department..."
                class="w-full rounded-lg border border-slate-200 py-2.5 pl-10 pr-3 text-sm outline-none transition focus:border-hitek-red focus:ring-2 focus:ring-red-100"
            >

        </div>

    </div>

    {{-- Service Tasks --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        {{-- Table Header --}}
        <div class="hidden border-b border-slate-200 bg-slate-50 px-5 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500 md:grid md:grid-cols-12 md:gap-4">

            <div class="col-span-4">
                Service
            </div>

            <div class="col-span-2">
                Category
            </div>

            <div class="col-span-2">
                Department
            </div>

            <div class="col-span-1">
                Time
            </div>

            <div class="col-span-1">
                Parts
            </div>

            <div class="col-span-1">
                Status
            </div>

            <div class="col-span-1 text-right">
                Action
            </div>

        </div>

        @forelse ($serviceTasks as $serviceTask)

            <div
                wire:key="service-task-{{ $serviceTask->id }}"
                class="border-b border-slate-100 px-5 py-4 last:border-b-0"
            >

                <div class="grid gap-3 md:grid-cols-12 md:items-center md:gap-4">

                    {{-- Service --}}
                    <div class="md:col-span-4">

                        <div class="font-semibold text-slate-900">
                            {{ $serviceTask->name }}
                        </div>

                        @if ($serviceTask->description)
                            <div class="mt-1 line-clamp-1 text-xs text-slate-500">
                                {{ $serviceTask->description }}
                            </div>
                        @endif

                    </div>

                    {{-- Category --}}
                    <div class="md:col-span-2">

                        <span class="text-sm text-slate-600">
                            {{ $serviceTask->category?->name ?? '—' }}
                        </span>

                    </div>

                    {{-- Department --}}
                    <div class="md:col-span-2">

                        <span class="text-sm text-slate-600">
                            {{ $serviceTask->department?->name ?? '—' }}
                        </span>

                    </div>

                    {{-- Time --}}
                    <div class="md:col-span-1">

                        @if ($serviceTask->estimated_minutes)
                            <span class="text-sm text-slate-600">
                                @if ($serviceTask->estimated_minutes < 60)
                                    {{ $serviceTask->estimated_minutes }} min
                                @else
                                    {{ intdiv($serviceTask->estimated_minutes, 60) }} hr
                                    @if ($serviceTask->estimated_minutes % 60)
                                        {{ $serviceTask->estimated_minutes % 60 }} min
                                    @endif
                                @endif
                            </span>
                        @else
                            <span class="text-sm text-slate-400">
                                —
                            </span>
                        @endif

                    </div>

                    {{-- Parts --}}
                    <div class="md:col-span-1">

                        <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                            {{ $serviceTask->task_parts_count }}
                        </span>

                    </div>

                    {{-- Status --}}
                    <div class="md:col-span-1">

                        @if ($serviceTask->is_active)

                            <span class="inline-flex rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">
                                Active
                            </span>

                        @else

                            <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">
                                Inactive
                            </span>

                        @endif

                    </div>

                    {{-- Action --}}
                    <div class="md:col-span-1 md:text-right">

                        <button
                            type="button"
                            class="text-sm font-semibold text-hitek-red hover:text-hitek-red-hover"
                        >
                            Edit
                        </button>

                    </div>

                </div>

            </div>

        @empty

            <div class="px-5 py-12 text-center">

                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6 text-slate-400"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M9 13h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V20a2 2 0 0 1-2 2Z"/>
                    </svg>
                </div>

                <h3 class="mt-3 text-sm font-semibold text-slate-900">
                    No service tasks found
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Try changing your search or add a new predefined service.
                </p>

            </div>

        @endforelse

    </div>

    {{-- Pagination --}}
    @if ($serviceTasks->hasPages())
        <div>
            {{ $serviceTasks->links() }}
        </div>
    @endif


    {{-- Add new service - Modal --}}
    @if ($showAddServiceModal)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4"
        >
            <div class="w-full max-w-2xl overflow-hidden rounded-2xl bg-white shadow-2xl">

                {{-- Header --}}
                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">
                            Add Service
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Create a predefined service for Advisors to use on job cards.
                        </p>
                    </div>

                    <button
                        type="button"
                        wire:click="$set('showAddServiceModal', false)"
                        class="rounded-lg p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-700"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Body --}}
                <div class="max-h-[75vh] overflow-y-auto px-6 py-5">

                    {{-- Basic Information --}}
                    <div>
                        <h3 class="text-sm font-semibold text-slate-900">
                            Basic Information
                        </h3>

                        <div class="mt-4 space-y-4">

                            {{-- Service Name --}}
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                    Service Name
                                </label>

                                <input
                                    type="text"
                                    wire:model="serviceName"
                                    placeholder="e.g. Front Brake Pad Replacement"
                                    class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm outline-none focus:border-hitek-red focus:ring-2 focus:ring-red-100"
                                >
                            </div>
                            @error('serviceName')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror

                            {{-- Department + Category --}}
                            <div class="grid gap-4 sm:grid-cols-2">
                                {{-- Department --}}
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                        Department
                                    </label>

                                    <select
                                        wire:model="serviceDepartment"
                                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-hitek-red focus:ring-2 focus:ring-red-100"
                                    >
                                        <option value="">
                                            Select department
                                        </option>

                                        @foreach ($departments as $department)
                                            <option value="{{ $department['id'] }}">
                                                {{ $department['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('serviceDepartment')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror

                                {{-- Category --}}
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                        Category
                                    </label>

                                    <select
                                        wire:model="serviceCategory"
                                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-hitek-red focus:ring-2 focus:ring-red-100"
                                    >
                                        <option value="">
                                            Select category
                                        </option>

                                        @foreach ($categories as $category)
                                            <option value="{{ $category['id'] }}">
                                                {{ $category['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('serviceCategory')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror

                            </div>

                            {{-- Estimated Time --}}
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                    Estimated Time
                                </label>

                                <select
                                    wire:model="serviceEstimatedTime"
                                    class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none focus:border-hitek-red focus:ring-2 focus:ring-red-100"
                                >
                                    <option value="">
                                        Select estimated time
                                    </option>

                                    <option value="15">15 minutes</option>
                                    <option value="30">30 minutes</option>
                                    <option value="45">45 minutes</option>
                                    <option value="60">1 hour</option>
                                    <option value="90">1 hour 30 minutes</option>
                                    <option value="120">2 hours</option>
                                    <option value="180">3 hours</option>
                                    <option value="240">4 hours</option>
                                    <option value="480">8 hours</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    {{-- Details --}}
                    <div class="mt-6 border-t border-slate-200 pt-5">

                        <h3 class="text-sm font-semibold text-slate-900">
                            Service Details
                        </h3>

                        <div class="mt-4 space-y-4">

                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                    Description
                                </label>

                                <textarea
                                    wire:model="serviceDescription"
                                    rows="3"
                                    placeholder="Describe what this service includes..."
                                    class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm outline-none focus:border-hitek-red focus:ring-2 focus:ring-red-100"
                                ></textarea>
                            </div>

                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                    Instructions
                                </label>

                                <textarea
                                    wire:model="serviceInstructions"
                                    rows="3"
                                    placeholder="Add instructions for the technician or coordinator..."
                                    class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm outline-none focus:border-hitek-red focus:ring-2 focus:ring-red-100"
                                ></textarea>
                            </div>

                        </div>

                    </div>

                    {{-- Suggested Parts --}}
                    <div class="mt-6 border-t border-slate-200 pt-5">

                        <div>
                            <h3 class="text-sm font-semibold text-slate-900">
                                Suggested Parts
                            </h3>

                            <p class="mt-1 text-xs text-slate-500">
                                These parts will be suggested automatically when this service is added to a job card.
                            </p>
                        </div>

                        {{-- Search --}}
                        <div class="relative mt-4">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z"/>
                            </svg>

                            <input
                                type="text"
                                wire:model.live.debounce.300ms="partSearch"
                                placeholder="Search part name, part number or brand..."
                                class="w-full rounded-lg border border-slate-200 py-2.5 pl-10 pr-3 text-sm outline-none focus:border-hitek-red focus:ring-2 focus:ring-red-100"
                            >

                            @if (count($partResults))
                                <div class="absolute left-0 right-0 top-full z-20 mt-1 overflow-hidden rounded-lg border border-slate-200 bg-white shadow-lg">

                                    @foreach ($partResults as $part)

                                        <button
                                            type="button"
                                            wire:click="addPart({{ $part['id'] }})"
                                            class="flex w-full items-center justify-between gap-4 border-b border-slate-100 px-4 py-3 text-left transition last:border-b-0 hover:bg-slate-50"
                                        >

                                            <div class="min-w-0">

                                                <div class="truncate text-sm font-semibold text-slate-900">
                                                    {{ $part['name'] }}
                                                </div>

                                                <div class="mt-0.5 text-xs text-slate-500">
                                                    {{ $part['part_number'] }}

                                                    @if ($part['brand'])
                                                        · {{ $part['brand'] }}
                                                    @endif
                                                </div>

                                            </div>

                                            <div class="shrink-0 text-right">

                                                <div class="text-xs text-slate-500">
                                                    Stock: {{ $part['current_stock'] }} {{ $part['unit'] }}
                                                </div>

                                                <div class="mt-1 text-xs font-semibold text-hitek-red">
                                                    + Add
                                                </div>

                                            </div>

                                        </button>

                                    @endforeach

                                </div>
                            @endif

                        </div>

                        {{-- Selected Parts --}}
                        @if (count($selectedParts))

                            <div class="mt-4 overflow-hidden rounded-lg border border-slate-200">

                                <div class="grid grid-cols-12 gap-3 bg-slate-50 px-4 py-2.5 text-xs font-semibold uppercase tracking-wide text-slate-500">
                                    <div class="col-span-5">
                                        Part
                                    </div>

                                    <div class="col-span-2">
                                        Qty
                                    </div>

                                    <div class="col-span-3">
                                        Required
                                    </div>

                                    <div class="col-span-2 text-right">
                                        Action
                                    </div>
                                </div>

                                @foreach ($selectedParts as $index => $part)

                                    <div
                                        wire:key="selected-part-{{ $part['id'] }}"
                                        class="grid grid-cols-12 items-center gap-3 border-t border-slate-100 px-4 py-3"
                                    >

                                        <div class="col-span-5 min-w-0">
                                            <div class="truncate text-sm font-medium text-slate-900">
                                                {{ $part['name'] }}
                                            </div>

                                            <div class="mt-0.5 text-xs text-slate-500">
                                                {{ $part['part_number'] }}
                                            </div>
                                        </div>

                                        <div class="col-span-2">
                                            <input
                                                type="number"
                                                min="1"
                                                wire:model="selectedParts.{{ $index }}.quantity"
                                                class="w-full rounded-md border border-slate-200 px-2 py-1.5 text-sm outline-none focus:border-hitek-red focus:ring-1 focus:ring-red-100"
                                            >
                                        </div>

                                        <div class="col-span-3">
                                            <label class="inline-flex items-center gap-2 text-sm text-slate-600">
                                                <input
                                                    type="checkbox"
                                                    wire:model="selectedParts.{{ $index }}.is_required"
                                                    class="h-4 w-4 rounded border-slate-300 text-hitek-red focus:ring-hitek-red"
                                                >

                                                Required
                                            </label>
                                        </div>

                                        <div class="col-span-2 text-right">
                                            <button
                                                type="button"
                                                wire:click="removePart({{ $index }})"
                                                class="text-sm font-medium text-red-600 hover:text-red-700"
                                            >
                                                Remove
                                            </button>
                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        @else

                            <div class="mt-4 rounded-lg border border-dashed border-slate-300 px-4 py-6 text-center">
                                <p class="text-sm text-slate-500">
                                    No parts added yet.
                                </p>

                                <p class="mt-1 text-xs text-slate-400">
                                    Search above to add suggested parts.
                                </p>
                            </div>

                        @endif

                        @error('selectedParts')
                            <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                        @enderror

                    </div>

                </div>

                {{-- Footer --}}
                <div class="flex items-center justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4">

                    <button
                        type="button"
                        wire:click="$set('showAddServiceModal', false)"
                        class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50"
                    >
                        Cancel
                    </button>

                    <button
                        type="button"
                        wire:click="saveService"
                        wire:loading.attr="disabled"
                        wire:target="saveService"
                        class="rounded-lg bg-hitek-red px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-hitek-red-hover disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        <span wire:loading.remove wire:target="saveService">
                            Save Service
                        </span>

                        <span wire:loading wire:target="saveService">
                            Saving...
                        </span>
                    </button>

                </div>

            </div>
        </div>
    @endif

</div>