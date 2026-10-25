
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">
                Company Holidays
            </h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Manage company holidays and paid or unpaid days for payroll.
            </p>
        </div>

        @can('company-holidays.manage')
            <button
                type="button"
                wire:click="openCreateModal"
                class="inline-flex items-center justify-center rounded-lg bg-hitek-red px-4 py-2.5 text-sm font-semibold text-white hover:bg-hitek-red-hover"
            >
                + Add Holiday
            </button>
        @endcan
    </div>

    @if (session()->has('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 dark:border-green-800 dark:bg-green-950 dark:text-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div>
            <label for="holidaySearch" class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">
                Search holiday
            </label>
            <input
                id="holidaySearch"
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search by holiday name..."
                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-hitek-red focus:outline-none dark:border-slate-700 dark:bg-slate-900 dark:text-white"
            >
        </div>

        <div>
            <label for="holidayYear" class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">
                Year
            </label>
            <select
                id="holidayYear"
                wire:model.live="year"
                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-hitek-red focus:outline-none dark:border-slate-700 dark:bg-slate-900 dark:text-white"
            >
                @for ($y = now()->year - 2; $y <= now()->year + 3; $y++)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endfor
            </select>
        </div>
    </div>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
                <thead class="bg-slate-50 dark:bg-slate-800/60">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                            Holiday
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                            Date
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                            Day
                        </th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                            Payment
                        </th>
                        @can('company-holidays.manage')
                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                                Actions
                            </th>
                        @endcan
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    @forelse ($holidays as $holiday)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40">
                            <td class="px-5 py-4">
                                <div class="font-medium text-slate-900 dark:text-white">
                                    {{ $holiday->name }}
                                </div>
                                @if ($holiday->notes)
                                    <div class="mt-1 max-w-sm text-xs text-slate-500 dark:text-slate-400">
                                        {{ $holiday->notes }}
                                    </div>
                                @endif
                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-700 dark:text-slate-300">
                                {{ $holiday->holiday_date->format('d M Y') }}
                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-700 dark:text-slate-300">
                                {{ $holiday->holiday_date->format('l') }}
                            </td>

                            <td class="whitespace-nowrap px-5 py-4">
                                @if ($holiday->is_paid)
                                    <span class="inline-flex rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-800 dark:bg-green-900/40 dark:text-green-300">
                                        Paid
                                    </span>
                                @else
                                    <span class="inline-flex rounded-full bg-amber-100 px-2.5 py-1 text-xs font-medium text-amber-800 dark:bg-amber-900/40 dark:text-amber-300">
                                        Unpaid
                                    </span>
                                @endif
                            </td>

                            @can('company-holidays.manage')
                                <td class="whitespace-nowrap px-5 py-4 text-right">
                                    <button
                                        type="button"
                                        wire:click="openEditModal({{ $holiday->id }})"
                                        class="text-sm font-medium text-hitek-red hover:underline"
                                    >
                                        Edit
                                    </button>

                                    <button
                                        type="button"
                                        wire:click="delete({{ $holiday->id }})"
                                        wire:confirm="Are you sure you want to delete this holiday?"
                                        class="ml-3 text-sm font-medium text-red-600 hover:underline dark:text-red-400"
                                    >
                                        Delete
                                    </button>
                                </td>
                            @endcan
                        </tr>
                    @empty
                        <tr>
                            <td colspan="@can('company-holidays.manage') 5 @else 4 @endcan" class="px-5 py-12 text-center">
                                <p class="font-medium text-slate-700 dark:text-slate-300">
                                    No holidays found
                                </p>
                                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                    Try another year or add a company holiday.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-200 px-5 py-4 dark:border-slate-800">
            {{ $holidays->links() }}
        </div>
    </div>

    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-black/60 p-4">
            <div
                class="my-auto w-full max-w-xl rounded-xl border border-slate-200 bg-white shadow-xl dark:border-slate-700 dark:bg-slate-900"
                wire:key="company-holiday-modal"
            >
                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4 dark:border-slate-800">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
                        {{ $editingHolidayId ? 'Edit Holiday' : 'Add Holiday' }}
                    </h2>

                    <button
                        type="button"
                        wire:click="closeModal"
                        class="text-2xl leading-none text-slate-400 hover:text-slate-700 dark:hover:text-white"
                        aria-label="Close"
                    >
                        &times;
                    </button>
                </div>

                <form wire:submit="save" class="space-y-5 p-6">
                    <div>
                        <label for="holidayName" class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Holiday Name *
                        </label>
                        <input
                            id="holidayName"
                            type="text"
                            wire:model="name"
                            placeholder="e.g. Diwali"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-hitek-red focus:outline-none dark:border-slate-700 dark:bg-slate-950 dark:text-white"
                        >
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="holidayDate" class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Holiday Date *
                        </label>
                        <input
                            id="holidayDate"
                            type="date"
                            wire:model="holiday_date"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-hitek-red focus:outline-none dark:border-slate-700 dark:bg-slate-950 dark:text-white"
                        >
                        @error('holiday_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="holidayPayment" class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Holiday Payment
                        </label>
                        <select
                            id="holidayPayment"
                            wire:model="is_paid"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-hitek-red focus:outline-none dark:border-slate-700 dark:bg-slate-950 dark:text-white"
                        >
                            <option value="1">Paid Holiday</option>
                            <option value="0">Unpaid Holiday</option>
                        </select>
                        @error('is_paid')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="holidayNotes" class="mb-1.5 block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Notes
                        </label>
                        <textarea
                            id="holidayNotes"
                            wire:model="notes"
                            rows="3"
                            placeholder="Optional details..."
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 focus:border-hitek-red focus:outline-none dark:border-slate-700 dark:bg-slate-950 dark:text-white"
                        ></textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3 border-t border-slate-200 pt-4 dark:border-slate-800">
                        <button
                            type="button"
                            wire:click="closeModal"
                            class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="rounded-lg bg-hitek-red px-4 py-2 text-sm font-semibold text-white hover:bg-hitek-red-hover disabled:opacity-50"
                        >
                            <span wire:loading.remove wire:target="save">
                                {{ $editingHolidayId ? 'Save Changes' : 'Add Holiday' }}
                            </span>
                            <span wire:loading wire:target="save">Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
