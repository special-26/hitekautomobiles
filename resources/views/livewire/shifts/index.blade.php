<div class="space-y-6">
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Shift Management</h1>
            <p class="mt-1 text-sm text-slate-500">
                Configure working hours for your employees.
            </p>
        </div>

        @can('shifts.manage')
            <button
                type="button"
                wire:click="createShift"
                class="rounded-lg bg-hitek-red px-4 py-2.5 text-sm font-semibold text-white hover:bg-hitek-red-hover"
            >
                + Add Shift
            </button>
        @endcan
    </div>

    @if (session()->has('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($shifts as $shift)
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">
                            {{ $shift->name }}
                        </h2>
                        <p class="mt-1 text-xs text-slate-500">
                            {{ strtoupper(str_replace('_', ' ', $shift->code)) }}
                        </p>
                    </div>

                    <span @class([
                        'rounded-full px-2.5 py-1 text-xs font-medium',
                        'bg-green-100 text-green-700' => $shift->is_active,
                        'bg-slate-100 text-slate-600' => !$shift->is_active,
                    ])>
                        {{ $shift->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-3">
                    <div class="rounded-lg bg-slate-50 p-3">
                        <p class="text-xs text-slate-500">Start Time</p>
                        <p class="mt-1 text-base font-semibold text-slate-900">
                            {{ \Carbon\Carbon::parse($shift->start_time)->format('g:i A') }}
                        </p>
                    </div>

                    <div class="rounded-lg bg-slate-50 p-3">
                        <p class="text-xs text-slate-500">End Time</p>
                        <p class="mt-1 text-base font-semibold text-slate-900">
                            {{ \Carbon\Carbon::parse($shift->end_time)->format('g:i A') }}
                        </p>
                    </div>
                </div>

                @can('shifts.manage')
                    <div class="mt-5 border-t border-slate-100 pt-4">
                        <button
                            type="button"
                            wire:click="editShift({{ $shift->id }})"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"
                        >
                            Edit Shift
                        </button>
                    </div>
                @endcan
            </div>
        @empty
            <div class="rounded-xl border border-dashed border-slate-300 bg-white p-10 text-center md:col-span-2 xl:col-span-3">
                <p class="font-medium text-slate-700">No shifts found</p>
                <p class="mt-1 text-sm text-slate-500">
                    Create a shift to configure employee working hours.
                </p>
            </div>
        @endforelse
    </div>

    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-slate-900/50 p-4">
            <div
                class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl"
                wire:key="shift-modal-{{ $editingShiftId ?? 'new' }}"
            >
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900">
                            {{ $editingShiftId ? 'Edit Shift' : 'Create Shift' }}
                        </h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Set the name and daily working hours.
                        </p>
                    </div>

                    <button
                        type="button"
                        wire:click="closeModal"
                        class="text-xl text-slate-400 hover:text-slate-700"
                        aria-label="Close modal"
                    >
                        &times;
                    </button>
                </div>

                <form wire:submit="saveShift" class="mt-6 space-y-5">
                    <div>
                        <label for="shift-name" class="mb-1.5 block text-sm font-medium text-slate-700">
                            Shift Name
                        </label>
                        <input
                            id="shift-name"
                            type="text"
                            wire:model="name"
                            placeholder="e.g. General"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red"
                        />
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="shift-start" class="mb-1.5 block text-sm font-medium text-slate-700">
                                Start Time
                            </label>
                            <input
                                id="shift-start"
                                type="time"
                                wire:model="start_time"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red"
                            />
                            @error('start_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="shift-end" class="mb-1.5 block text-sm font-medium text-slate-700">
                                End Time
                            </label>
                            <input
                                id="shift-end"
                                type="time"
                                wire:model="end_time"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red"
                            />
                            @error('end_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    @if ($editingShiftId)
                        <label class="flex items-center gap-3 rounded-lg border border-slate-200 p-3">
                            <input
                                type="checkbox"
                                wire:model="is_active"
                                class="h-4 w-4 rounded border-slate-300 text-hitek-red focus:ring-hitek-red"
                            />
                            <span>
                                <span class="block text-sm font-medium text-slate-800">Active shift</span>
                                <span class="block text-xs text-slate-500">
                                    Inactive shifts should not be assigned to new attendance records.
                                </span>
                            </span>
                        </label>
                    @endif

                    <div class="flex justify-end gap-3 border-t border-slate-100 pt-5">
                        <button
                            type="button"
                            wire:click="closeModal"
                            class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            wire:target="saveShift"
                            class="rounded-lg bg-hitek-red px-4 py-2.5 text-sm font-semibold text-white hover:bg-hitek-red-hover disabled:opacity-50"
                        >
                            <span wire:loading.remove wire:target="saveShift">Save Shift</span>
                            <span wire:loading wire:target="saveShift">Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>