<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                Bays
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Manage workshop bays and their status.
            </p>
        </div>

        <button
            type="button"
            wire:click="$set('showAddBayModal', true)"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-hitek-red px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-hitek-red-hover"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 4v16m8-8H4"
                />
            </svg>

            Add Bay
        </button>

    </div>


    {{-- Filters --}}
    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">

        <div class="grid grid-cols-1 gap-3 md:grid-cols-3">

            {{-- Search --}}
            <div class="relative">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m21 21-4.35-4.35m2.35-5.65a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z"
                    />
                </svg>

                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search bay, code or type..."
                    class="w-full rounded-lg border border-slate-200 bg-white py-2.5 pl-10 pr-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-hitek-red focus:ring-2 focus:ring-red-100"
                >

            </div>


            {{-- Department --}}
            <select
                wire:model.live="department"
                class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-hitek-red focus:ring-2 focus:ring-red-100"
            >
                <option value="">
                    All Departments
                </option>

                @foreach ($departments as $item)
                    <option value="{{ $item->id }}">
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>


            {{-- Status --}}
            <select
                wire:model.live="status"
                class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-hitek-red focus:ring-2 focus:ring-red-100"
            >
                <option value="">
                    All Status
                </option>

                <option value="active">
                    Active
                </option>

                <option value="inactive">
                    Inactive
                </option>
            </select>

        </div>

    </div>


    {{-- Bays Table --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm">

                <thead class="border-b border-slate-200 bg-slate-50">

                    <tr>

                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Bay
                        </th>

                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Code
                        </th>

                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Department
                        </th>

                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Type
                        </th>

                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Status
                        </th>

                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    {{-- Loading --}}
                    <tr wire:loading>

                        <td
                            colspan="6"
                            class="px-5 py-12 text-center"
                        >

                            <div class="inline-flex items-center gap-2 text-sm text-slate-500">

                                <svg
                                    class="h-5 w-5 animate-spin"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4"
                                    />

                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                                    />

                                </svg>

                                Loading bays...

                            </div>

                        </td>

                    </tr>


                    {{-- Empty --}}
                    @if ($bays->isEmpty())

                        <tr wire:loading.remove>

                            <td
                                colspan="6"
                                class="px-5 py-16 text-center"
                            >

                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100">

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-6 w-6 text-slate-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M3 21h18M5 21V8l7-5 7 5v13M9 21v-6h6v6M9 10h.01M12 10h.01M15 10h.01"
                                        />
                                    </svg>

                                </div>

                                <p class="mt-3 font-semibold text-slate-700">
                                    No bays found
                                </p>

                                <p class="mt-1 text-sm text-slate-500">
                                    Create your first workshop bay.
                                </p>

                            </td>

                        </tr>

                    @endif


                    {{-- Bays --}}
                    @foreach ($bays as $bay)

                        <tr
                            wire:key="bay-{{ $bay->id }}"
                            wire:loading.remove
                            class="transition hover:bg-slate-50"
                        >

                            {{-- Bay --}}
                            <td class="px-5 py-4">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-50">

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-hitek-red"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M3 21h18M5 21V8l7-5 7 5v13M9 21v-6h6v6M9 10h.01M12 10h.01M15 10h.01"
                                            />
                                        </svg>

                                    </div>

                                    <div>

                                        <div class="font-semibold text-slate-800">
                                            {{ $bay->name }}
                                        </div>

                                        <div class="text-xs text-slate-400">
                                            ID: {{ $bay->id }}
                                        </div>

                                    </div>

                                </div>

                            </td>


                            {{-- Code --}}
                            <td class="px-5 py-4">

                                <code class="rounded-md bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-700">
                                    {{ $bay->code }}
                                </code>

                            </td>


                            {{-- Department --}}
                            <td class="px-5 py-4 text-slate-600">

                                {{ $bay->department?->name ?? '—' }}

                            </td>


                            {{-- Type --}}
                            <td class="px-5 py-4 text-slate-600">

                                {{ $bay->type }}

                            </td>


                            {{-- Status --}}
                            <td class="px-5 py-4">

                                @if ($bay->is_active)

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-2.5 py-1 text-xs font-semibold text-green-700">

                                        <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>

                                        Active

                                    </span>

                                @else

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-700">

                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>

                                        Inactive

                                    </span>

                                @endif

                            </td>


                            {{-- Actions --}}
                            <td class="px-5 py-4">

                                <div class="flex justify-end gap-1">

                                    {{-- Edit --}}
                                    <button
                                        type="button"
                                        wire:click="editBay({{ $bay->id }})"
                                        class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-800"
                                        title="Edit"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="m16.862 4.487 2.651 2.651M4.5 19.5l4.125-.825L19.513 7.787a1.875 1.875 0 0 0-2.65-2.65L6 16.025 4.5 19.5Z"
                                            />
                                        </svg>
                                    </button>


                                    {{-- Status --}}
                                    <button
                                        type="button"
                                        wire:click="confirmBayStatus({{ $bay->id }})"
                                        class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-800"
                                        title="{{ $bay->is_active ? 'Deactivate' : 'Activate' }}"
                                    >

                                        @if ($bay->is_active)

                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M9 9V5m6 4V5m-9 7a6 6 0 1 0 12 0m-9 0a3 3 0 0 1 6 0"
                                                />
                                            </svg>

                                        @else

                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M12 6v6l4 2m5-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                                                />
                                            </svg>

                                        @endif

                                    </button>

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if ($bays->hasPages())

            <div class="border-t border-slate-200 px-5 py-4">
                {{ $bays->links() }}
            </div>

        @endif

    </div>

    {{-- Add Bay Modals --}}
    @if ($showAddBayModal)

        <div
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/50 px-4"
            wire:click.self="$set('showAddBayModal', false)"
        >

            <div class="w-full max-w-lg overflow-hidden rounded-xl bg-white shadow-xl">

                {{-- Header --}}
                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">

                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">
                            Add Bay
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-500">
                            Create a new workshop bay.
                        </p>
                    </div>

                    <button
                        type="button"
                        wire:click="$set('showAddBayModal', false)"
                        class="rounded-lg p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-600"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18 18 6M6 6l12 12"
                            />
                        </svg>
                    </button>

                </div>


                {{-- Form --}}
                <form wire:submit="saveBay">

                    <div class="space-y-5 px-6 py-5">

                        {{-- Name + Code --}}
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                    Bay Name
                                </label>

                                <input
                                    type="text"
                                    wire:model="bayName"
                                    placeholder="Mechanical Bay 1"
                                    class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm outline-none transition focus:border-hitek-red focus:ring-2 focus:ring-red-100"
                                >

                                @error('bayName')
                                    <p class="mt-1 text-xs text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>


                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                    Code
                                </label>

                                <input
                                    type="text"
                                    wire:model="bayCode"
                                    placeholder="MECH-01"
                                    class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm uppercase outline-none transition focus:border-hitek-red focus:ring-2 focus:ring-red-100"
                                >

                                @error('bayCode')
                                    <p class="mt-1 text-xs text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                        </div>


                        {{-- Department --}}
                        <div>

                            <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                Department
                            </label>

                            <select
                                wire:model="bayDepartment"
                                class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-hitek-red focus:ring-2 focus:ring-red-100"
                            >
                                <option value="">
                                    Select department
                                </option>

                                @foreach ($departments as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('bayDepartment')
                                <p class="mt-1 text-xs text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Type --}}
                        <div>

                            <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                Bay Type
                            </label>

                            <input
                                type="text"
                                wire:model="bayType"
                                placeholder="General, Lift, AC, Paint Booth..."
                                class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm outline-none transition focus:border-hitek-red focus:ring-2 focus:ring-red-100"
                            >

                            @error('bayType')
                                <p class="mt-1 text-xs text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Status --}}
                        <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-slate-200 p-3">

                            <input
                                type="checkbox"
                                wire:model="bayIsActive"
                                class="h-4 w-4 rounded border-slate-300 text-hitek-red focus:ring-hitek-red"
                            >

                            <div>
                                <div class="text-sm font-medium text-slate-700">
                                    Active Bay
                                </div>

                                <div class="text-xs text-slate-500">
                                    This bay can be used for workshop tasks.
                                </div>
                            </div>

                        </label>

                    </div>


                    {{-- Footer --}}
                    <div class="flex justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4">

                        <button
                            type="button"
                            wire:click="$set('showAddBayModal', false)"
                            class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            wire:target="saveBay"
                            class="inline-flex items-center gap-2 rounded-lg bg-hitek-red px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-hitek-red-hover disabled:cursor-not-allowed disabled:opacity-60"
                        >

                            <svg
                                wire:loading
                                wire:target="saveBay"
                                class="h-4 w-4 animate-spin"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <circle
                                    class="opacity-25"
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="4"
                                />

                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                                />
                            </svg>

                            <span wire:loading.remove wire:target="saveBay">
                                Create Bay
                            </span>

                            <span wire:loading wire:target="saveBay">
                                Creating...
                            </span>

                        </button>

                    </div>

                </form>

            </div>

        </div>

    @endif

    {{-- Edit-Update Bay Modal --}}
    @if ($showEditBayModal)

        <div
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/50 px-4"
            wire:click.self="$set('showEditBayModal', false)"
        >

            <div class="w-full max-w-lg overflow-hidden rounded-xl bg-white shadow-xl">

                {{-- Header --}}
                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">

                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">
                            Edit Bay
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-500">
                            Update workshop bay information.
                        </p>
                    </div>

                    <button
                        type="button"
                        wire:click="$set('showEditBayModal', false)"
                        class="rounded-lg p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-600"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18 18 6M6 6l12 12"
                            />
                        </svg>
                    </button>

                </div>


                {{-- Form --}}
                <form wire:submit="updateBay">

                    <div class="space-y-5 px-6 py-5">

                        {{-- Name + Code --}}
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                            <div>

                                <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                    Bay Name
                                </label>

                                <input
                                    type="text"
                                    wire:model="editBayName"
                                    class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm outline-none transition focus:border-hitek-red focus:ring-2 focus:ring-red-100"
                                >

                                @error('editBayName')
                                    <p class="mt-1 text-xs text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            <div>

                                <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                    Code
                                </label>

                                <input
                                    type="text"
                                    wire:model="editBayCode"
                                    class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm uppercase outline-none transition focus:border-hitek-red focus:ring-2 focus:ring-red-100"
                                >

                                @error('editBayCode')
                                    <p class="mt-1 text-xs text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>


                        {{-- Department --}}
                        <div>

                            <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                Department
                            </label>

                            <select
                                wire:model="editBayDepartment"
                                class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-hitek-red focus:ring-2 focus:ring-red-100"
                            >
                                <option value="">
                                    Select department
                                </option>

                                @foreach ($departments as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('editBayDepartment')
                                <p class="mt-1 text-xs text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Type --}}
                        <div>

                            <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                Bay Type
                            </label>

                            <input
                                type="text"
                                wire:model="editBayType"
                                class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm outline-none transition focus:border-hitek-red focus:ring-2 focus:ring-red-100"
                            >

                            @error('editBayType')
                                <p class="mt-1 text-xs text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- Status --}}
                        <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-slate-200 p-3">

                            <input
                                type="checkbox"
                                wire:model="editBayIsActive"
                                class="h-4 w-4 rounded border-slate-300 text-hitek-red focus:ring-hitek-red"
                            >

                            <div>
                                <div class="text-sm font-medium text-slate-700">
                                    Active Bay
                                </div>

                                <div class="text-xs text-slate-500">
                                    This bay can be used for workshop tasks.
                                </div>
                            </div>

                        </label>

                    </div>


                    {{-- Footer --}}
                    <div class="flex justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4">

                        <button
                            type="button"
                            wire:click="$set('showEditBayModal', false)"
                            class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            wire:target="updateBay"
                            class="inline-flex items-center gap-2 rounded-lg bg-hitek-red px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-hitek-red-hover disabled:cursor-not-allowed disabled:opacity-60"
                        >

                            <svg
                                wire:loading
                                wire:target="updateBay"
                                class="h-4 w-4 animate-spin"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <circle
                                    class="opacity-25"
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="4"
                                />

                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                                />
                            </svg>

                            <span wire:loading.remove wire:target="updateBay">
                                Save Changes
                            </span>

                            <span wire:loading wire:target="updateBay">
                                Saving...
                            </span>

                        </button>

                    </div>

                </form>

            </div>

        </div>

    @endif

    {{-- Change Status --}}
    @if ($showStatusModal)

        <div
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/50 px-4"
            wire:click.self="$set('showStatusModal', false)"
        >

            <div class="w-full max-w-md overflow-hidden rounded-xl bg-white shadow-xl">

                <div class="px-6 py-6">

                    {{-- Icon --}}
                    <div class="flex h-11 w-11 items-center justify-center rounded-full
                        {{ $statusBayCurrentState ? 'bg-red-50' : 'bg-green-50' }}"
                    >

                        @if ($statusBayCurrentState)

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-hitek-red"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 9V5m6 4V5m-9 7a6 6 0 1 0 12 0"
                                />
                            </svg>

                        @else

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-green-600"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 6v6l4 2m5-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                                />
                            </svg>

                        @endif

                    </div>


                    <h2 class="mt-4 text-lg font-semibold text-slate-900">

                        @if ($statusBayCurrentState)
                            Deactivate Bay
                        @else
                            Activate Bay
                        @endif

                    </h2>


                    <p class="mt-2 text-sm leading-6 text-slate-500">

                        @if ($statusBayCurrentState)

                            Are you sure you want to deactivate
                            <span class="font-semibold text-slate-700">
                                {{ $statusBayName }}
                            </span>?

                            The bay will no longer be available for new assignments.

                        @else

                            Are you sure you want to activate
                            <span class="font-semibold text-slate-700">
                                {{ $statusBayName }}
                            </span>?

                            The bay will become available for workshop assignments.

                        @endif

                    </p>

                </div>


                {{-- Footer --}}
                <div class="flex justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4">

                    <button
                        type="button"
                        wire:click="$set('showStatusModal', false)"
                        class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
                    >
                        Cancel
                    </button>


                    <button
                        type="button"
                        wire:click="updateBayStatus"
                        wire:loading.attr="disabled"
                        wire:target="updateBayStatus"
                        class="inline-flex items-center gap-2 rounded-lg px-4 py-2.5 text-sm font-semibold text-white transition disabled:cursor-not-allowed disabled:opacity-60
                            {{ $statusBayCurrentState
                                ? 'bg-hitek-red hover:bg-hitek-red-hover'
                                : 'bg-green-600 hover:bg-green-700' }}"
                    >

                        <svg
                            wire:loading
                            wire:target="updateBayStatus"
                            class="h-4 w-4 animate-spin"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            />

                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                            />
                        </svg>


                        <span wire:loading.remove wire:target="updateBayStatus">

                            @if ($statusBayCurrentState)
                                Deactivate
                            @else
                                Activate
                            @endif

                        </span>


                        <span wire:loading wire:target="updateBayStatus">
                            Updating...
                        </span>

                    </button>

                </div>

            </div>

        </div>

    @endif

</div>