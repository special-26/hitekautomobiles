
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">
            Payroll Settings
        </h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            Configure working days and salary deduction rules for Hitek Automobiles.
        </p>
    </div>

    @if (session()->has('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 dark:border-green-900 dark:bg-green-950 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit="save" class="space-y-6">
        <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
                Working Week
            </h2>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Select the regular weekly holidays. These days will be excluded
                when calculating actual working days.
            </p>

            @php
                $days = [
                    0 => 'Sunday',
                    1 => 'Monday',
                    2 => 'Tuesday',
                    3 => 'Wednesday',
                    4 => 'Thursday',
                    5 => 'Friday',
                    6 => 'Saturday',
                ];
            @endphp

            <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-4">
                @foreach ($days as $number => $day)
                    <label wire:key="weekly-off-{{ $number }}"
                        class="flex cursor-pointer items-center gap-3 rounded-lg border border-slate-200 p-3 dark:border-slate-700">
                        <input
                            type="checkbox"
                            wire:model="weekly_off_days"
                            value="{{ $number }}"
                            class="rounded border-slate-300 text-hitek-red focus:ring-hitek-red"
                        >
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-200">
                            {{ $day }}
                        </span>
                    </label>
                @endforeach
            </div>

            @error('weekly_off_days')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror

            @error('weekly_off_days.*')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </section>

        <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
                Salary Calculation
            </h2>

            <div class="mt-4 grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Salary proration method
                    </label>

                    <select
                        wire:model="proration_method"
                        class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-hitek-red focus:ring-hitek-red dark:border-slate-600 dark:bg-slate-800 dark:text-white"
                    >
                        <option value="actual_working_days">
                            Actual working days in the month
                        </option>
                    </select>

                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        Monthly salary is divided by the month's working days.
                    </p>

                    @error('proration_method')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Half-day deduction
                    </label>

                    <select
                        wire:model="half_day_deduction_fraction"
                        class="mt-1 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 focus:border-hitek-red focus:ring-hitek-red dark:border-slate-600 dark:bg-slate-800 dark:text-white"
                    >
                        <option value="0.25">25% of one day's salary</option>
                        <option value="0.50">50% of one day's salary</option>
                        <option value="0.75">75% of one day's salary</option>
                        <option value="1.00">100% of one day's salary</option>
                        <option value="0.00">No deduction</option>
                    </select>

                    @error('half_day_deduction_fraction')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </section>

        <section class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
                Deduction Policies
            </h2>

            <div class="mt-4 space-y-4">
                <label class="flex items-start justify-between gap-4">
                    <span>
                        <span class="block text-sm font-medium text-slate-800 dark:text-slate-200">
                            Deduct absent days
                        </span>
                        <span class="text-xs text-slate-500 dark:text-slate-400">
                            Deduct one day's salary for each eligible absence.
                        </span>
                    </span>
                    <input
                        type="checkbox"
                        wire:model="deduct_absent_days"
                        class="mt-1 rounded border-slate-300 text-hitek-red focus:ring-hitek-red"
                    >
                </label>

                <div class="border-t border-slate-100 dark:border-slate-800"></div>

                <label class="flex items-start justify-between gap-4">
                    <span>
                        <span class="block text-sm font-medium text-slate-800 dark:text-slate-200">
                            Deduct half days
                        </span>
                        <span class="text-xs text-slate-500 dark:text-slate-400">
                            Apply the configured half-day deduction fraction.
                        </span>
                    </span>
                    <input
                        type="checkbox"
                        wire:model="deduct_half_days"
                        class="mt-1 rounded border-slate-300 text-hitek-red focus:ring-hitek-red"
                    >
                </label>

                <div class="border-t border-slate-100 dark:border-slate-800"></div>

                <label class="flex items-start justify-between gap-4">
                    <span>
                        <span class="block text-sm font-medium text-slate-800 dark:text-slate-200">
                            Late-arrival deductions
                        </span>
                        <span class="text-xs text-slate-500 dark:text-slate-400">
                            Policy setting only; no late deduction will be applied until its calculation rules are implemented.
                        </span>
                    </span>
                    <input
                        type="checkbox"
                        wire:model="late_deduction_enabled"
                        class="mt-1 rounded border-slate-300 text-hitek-red focus:ring-hitek-red"
                    >
                </label>
            </div>
        </section>

        <div class="flex justify-end">
            <button
                type="submit"
                wire:loading.attr="disabled"
                class="inline-flex items-center rounded-lg bg-hitek-red px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-hitek-red-hover disabled:opacity-50"
            >
                <span wire:loading.remove wire:target="save">Save Settings</span>
                <span wire:loading wire:target="save">Saving...</span>
            </button>
        </div>
    </form>
</div>
