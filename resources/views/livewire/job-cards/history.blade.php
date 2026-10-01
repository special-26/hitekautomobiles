<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        <div>
            <div class="flex items-center gap-3">

                <a
                    href="{{ route('job-cards.show', $jobCard['id']) }}"
                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:bg-slate-50 hover:text-slate-900"
                >
                    ←
                </a>

                <div>
                    <h1 class="text-xl font-bold text-slate-900">
                        Job Card History
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Job Card #{{ $jobCard['id'] }}
                        · {{ $jobCard['vehicle_no'] }}
                        · {{ $jobCard['customer'] }}
                    </p>
                </div>

            </div>
        </div>


        <div class="flex flex-wrap items-center gap-2">

            <button
                type="button"
                class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
            >
                Export History
            </button>

        </div>

    </div>


    {{-- Job Card Navigation --}}
    <x-hitek.job-card-navigation
        :job-card-id="$jobCard['id']"
        active="history"
    />


    {{-- Summary --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        <div class="rounded-xl border border-slate-200 bg-white p-5">

            <p class="text-sm font-medium text-slate-500">
                Total Activities
            </p>

            <p class="mt-3 text-2xl font-bold text-slate-900">
                {{ count($history) }}
            </p>

            <p class="mt-1 text-xs text-slate-500">
                Recorded activities
            </p>

        </div>


        <div class="rounded-xl border border-slate-200 bg-white p-5">

            <p class="text-sm font-medium text-slate-500">
                Job Card Created
            </p>

            <p class="mt-3 text-lg font-bold text-slate-900">
                {{ $history[0]['date'] }}
            </p>

            <p class="mt-1 text-xs text-slate-500">
                {{ $history[0]['time'] }}
            </p>

        </div>


        <div class="rounded-xl border border-slate-200 bg-white p-5">

            <p class="text-sm font-medium text-slate-500">
                Last Activity
            </p>

            <p class="mt-3 text-lg font-bold text-slate-900">
                {{ $history[count($history) - 1]['date'] }}
            </p>

            <p class="mt-1 text-xs text-slate-500">
                {{ $history[count($history) - 1]['time'] }}
            </p>

        </div>


        <div class="rounded-xl border border-green-100 bg-green-50 p-5">

            <p class="text-sm font-medium text-green-700">
                Current Stage
            </p>

            <p class="mt-3 text-lg font-bold text-green-700">
                Vehicle Ready
            </p>

            <p class="mt-1 text-xs text-green-600">
                Latest recorded status
            </p>

        </div>

    </div>


    {{-- Filters --}}
    <div class="rounded-xl border border-slate-200 bg-white p-4">

        <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">

            <div class="flex flex-1 flex-col gap-3 sm:flex-row">

                <div class="relative flex-1">

                    <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                        🔍
                    </span>

                    <input
                        type="text"
                        placeholder="Search activity..."
                        class="w-full rounded-lg border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                    >

                </div>


                <select
                    class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-600 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                >
                    <option>All Activities</option>
                    <option>Job Card</option>
                    <option>Customer</option>
                    <option>Task</option>
                    <option>Assignment</option>
                    <option>Parts</option>
                    <option>Billing</option>
                    <option>Payment</option>
                    <option>Status</option>
                </select>


                <select
                    class="rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-600 outline-none focus:border-hitek-red focus:ring-2 focus:ring-hitek-red/10"
                >
                    <option>All Users</option>
                    <option>Advisor</option>
                    <option>Mechanic</option>
                    <option>Mechanic Coordinator</option>
                    <option>Store Manager</option>
                </select>

            </div>


            <button
                type="button"
                class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50"
            >
                Reset
            </button>

        </div>

    </div>


    {{-- Timeline --}}
    <div class="rounded-xl border border-slate-200 bg-white">

        <div class="border-b border-slate-200 px-5 py-4">

            <h2 class="font-semibold text-slate-900">
                Activity Timeline
            </h2>

            <p class="mt-1 text-xs text-slate-500">
                Complete chronological history of this job card
            </p>

        </div>


        <div class="p-6">

            <div class="relative">

                {{-- Timeline Line --}}
                <div class="absolute bottom-0 left-[19px] top-0 w-px bg-slate-300"></div>


                <div class="space-y-8">

                    @foreach ($history as $item)

                        @php
                            $iconClasses = match ($item['type']) {
                                'Job Card' => 'bg-red-50 text-red-600 border-red-100',
                                'Customer' => 'bg-blue-50 text-blue-600 border-blue-100',
                                'Task' => 'bg-purple-50 text-purple-600 border-purple-100',
                                'Assignment' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                'Parts' => 'bg-orange-50 text-orange-600 border-orange-100',
                                'Billing' => 'bg-green-50 text-green-600 border-green-100',
                                'Payment' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                'Status' => 'bg-amber-50 text-amber-600 border-amber-100',
                                default => 'bg-slate-50 text-slate-600 border-slate-100',
                            };

                            $icon = match ($item['icon']) {
                                'plus' => '+',
                                'user' => 'U',
                                'task' => 'T',
                                'wrench' => 'W',
                                'parts' => 'P',
                                'check' => '✓',
                                'billing' => '₹',
                                'payment' => '₹',
                                'status' => 'S',
                                default => '•',
                            };
                        @endphp


                        <div class="relative flex gap-4">

                            {{-- Icon --}}
                            <div class="relative z-10 flex h-10 w-10 shrink-0 items-center justify-center rounded-full border {{ $iconClasses }} text-sm font-bold">
                                {{ $icon }}
                            </div>


                            {{-- Content --}}
                            <div class="min-w-0 flex-1 pb-1">

                                <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">

                                    <div>

                                        <div class="flex flex-wrap items-center gap-2">

                                            <h3 class="font-semibold text-slate-900">
                                                {{ $item['action'] }}
                                            </h3>

                                            <span class="rounded-full bg-slate-300 px-2 py-0.5 text-xs font-medium text-slate-600">
                                                {{ $item['type'] }}
                                            </span>

                                        </div>

                                        <p class="mt-1 text-sm leading-6 text-slate-600">
                                            {{ $item['description'] }}
                                        </p>

                                    </div>


                                    <div class="shrink-0 text-left sm:text-right">

                                        <p class="text-xs font-medium text-slate-600">
                                            {{ $item['date'] }}
                                        </p>

                                        <p class="mt-1 text-xs text-slate-400">
                                            {{ $item['time'] }}
                                        </p>

                                    </div>

                                </div>


                                {{-- User --}}
                                <div class="mt-3 flex flex-wrap items-center gap-x-3 gap-y-1">

                                    <div class="flex items-center gap-2">

                                        <div class="flex h-6 w-6 items-center justify-center rounded-full bg-slate-300 text-xs font-semibold text-slate-600">
                                            {{ strtoupper(substr($item['user'], 0, 1)) }}
                                        </div>

                                        <span class="text-xs font-medium text-slate-700">
                                            {{ $item['user'] }}
                                        </span>

                                    </div>

                                    <span class="text-slate-300">
                                        ·
                                    </span>

                                    <span class="text-xs text-slate-500">
                                        {{ $item['role'] }}
                                    </span>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        </div>

    </div>

</div>