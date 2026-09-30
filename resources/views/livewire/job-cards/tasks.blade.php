<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div class="flex items-start gap-3">
            <a
                href="{{ route('job-cards.show', $jobCard['id']) }}"
                class="mt-1 inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-500 transition hover:bg-slate-50 hover:text-slate-900"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15 19l-7-7 7-7"/>
                </svg>
            </a>

            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                    Job Card Tasks
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    #{{ $jobCard['id'] }}
                    <span class="mx-1">•</span>
                    {{ $jobCard['vehicle_no'] }}
                    <span class="mx-1">•</span>
                    {{ $jobCard['vehicle'] }}
                </p>
            </div>
        </div>

        <button
            type="button"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-hitek-red px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-hitek-red-hover"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 5v14M5 12h14"/>
            </svg>

            Add Task
        </button>
    </div>


    {{-- Job Card Navigation --}}
    <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white">
        <div class="flex min-w-max items-center px-2">

            <a
                href="{{ route('job-cards.show', $jobCard['id']) }}"
                class="px-4 py-3 text-sm font-medium text-slate-500 transition hover:text-slate-900"
            >
                Overview
            </a>

            <a
                href="{{ route('job-cards.customer-vehicle', $jobCard['id']) }}"
                class="px-4 py-3 text-sm font-medium text-slate-500 transition hover:text-slate-900"
            >
                Customer & Vehicle
            </a>

            <div class="border-b-2 border-hitek-red px-4 py-3 text-sm font-semibold text-hitek-red">
                Tasks
            </div>

            <button class="px-4 py-3 text-sm font-medium text-slate-500 hover:text-slate-900">
                Parts
            </button>

            <button class="px-4 py-3 text-sm font-medium text-slate-500 hover:text-slate-900">
                Images
            </button>

            <button class="px-4 py-3 text-sm font-medium text-slate-500 hover:text-slate-900">
                Insurance
            </button>

            <button class="px-4 py-3 text-sm font-medium text-slate-500 hover:text-slate-900">
                Billing
            </button>

            <button class="px-4 py-3 text-sm font-medium text-slate-500 hover:text-slate-900">
                Payments
            </button>

            <button class="px-4 py-3 text-sm font-medium text-slate-500 hover:text-slate-900">
                History
            </button>

        </div>
    </div>


    {{-- Task Summary --}}
    <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">
                    Total Tasks
                </p>

                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5 text-slate-600"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 5h6M9 9h6M9 13h4M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                    </svg>
                </div>
            </div>

            <p class="mt-3 text-2xl font-bold text-slate-900">
                {{ count($tasks) }}
            </p>
        </div>


        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">
                    In Progress
                </p>

                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5 text-blue-600"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 6v6l4 2"/>
                        <circle cx="12" cy="12" r="9"/>
                    </svg>
                </div>
            </div>

            <p class="mt-3 text-2xl font-bold text-slate-900">
                {{ collect($tasks)->where('status', 'In Progress')->count() }}
            </p>
        </div>


        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">
                    Pending Parts
                </p>

                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5 text-amber-600"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 9v4m0 4h.01"/>
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M10.3 3.7L2.6 17a2 2 0 001.7 3h15.4a2 2 0 001.7-3L13.7 3.7a2 2 0 00-3.4 0z"/>
                    </svg>
                </div>
            </div>

            <p class="mt-3 text-2xl font-bold text-slate-900">
                {{ collect($tasks)->where('status', 'Pending Parts')->count() }}
            </p>
        </div>


        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">
                    Completed
                </p>

                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-50">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5 text-emerald-600"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>

            <p class="mt-3 text-2xl font-bold text-slate-900">
                {{ collect($tasks)->where('status', 'Completed')->count() }}
            </p>
        </div>

    </div>


    {{-- Filters --}}
    <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">

        <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">

            <div class="relative w-full lg:max-w-sm">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">
                    <circle cx="11" cy="11" r="7"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M20 20l-4-4"/>
                </svg>

                <input
                    type="text"
                    placeholder="Search tasks..."
                    class="w-full rounded-lg border border-slate-200 bg-white py-2.5 pl-9 pr-3 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-hitek-red focus:ring-2 focus:ring-red-100"
                >
            </div>

            <div class="flex flex-wrap gap-2">

                <button
                    type="button"
                    class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50"
                >
                    All Tasks
                </button>

                <button
                    type="button"
                    class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50"
                >
                    Status
                </button>

                <button
                    type="button"
                    class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50"
                >
                    Mechanic
                </button>

                <button
                    type="button"
                    class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50"
                >
                    Priority
                </button>

            </div>

        </div>
    </div>


    {{-- Task List --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-4">
            <div class="flex items-center justify-between gap-4">

                <div>
                    <h2 class="text-base font-semibold text-slate-900">
                        Service Tasks
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        Tasks assigned to this job card
                    </p>
                </div>

                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                    {{ count($tasks) }} Tasks
                </span>

            </div>
        </div>


        <div class="divide-y divide-slate-100">

            @foreach ($tasks as $task)

                <div class="p-5 transition hover:bg-slate-50/70">

                    <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:justify-between">

                        {{-- Task Main --}}
                        <div class="min-w-0 flex-1">

                            <div class="flex flex-wrap items-center gap-2">

                                <span class="text-xs font-semibold text-slate-400">
                                    TASK #{{ str_pad($task['id'], 2, '0', STR_PAD_LEFT) }}
                                </span>

                                @if ($task['status'] === 'Completed')
                                    <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                        Completed
                                    </span>
                                @elseif ($task['status'] === 'In Progress')
                                    <span class="rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700">
                                        In Progress
                                    </span>
                                @elseif ($task['status'] === 'Pending Parts')
                                    <span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">
                                        Pending Parts
                                    </span>
                                @else
                                    <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">
                                        Pending
                                    </span>
                                @endif

                                <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                                    {{ $task['category'] }}
                                </span>

                            </div>


                            <h3 class="mt-2 text-base font-semibold text-slate-900">
                                {{ $task['task'] }}
                            </h3>

                            <p class="mt-1 max-w-3xl text-sm leading-6 text-slate-500">
                                {{ $task['description'] }}
                            </p>


                            <div class="mt-4 flex flex-wrap items-center gap-x-6 gap-y-3 text-sm">

                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-4 w-4 text-slate-400"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/>
                                        <circle cx="9" cy="7" r="4"/>
                                    </svg>

                                    <span class="text-slate-500">Mechanic</span>

                                    <span class="font-medium text-slate-700">
                                        {{ $task['mechanic'] }}
                                    </span>
                                </div>


                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-4 w-4 text-slate-400"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M3 21h18M5 21V8l7-4 7 4v13M9 21v-4h6v4"/>
                                    </svg>

                                    <span class="text-slate-500">Bay</span>

                                    <span class="font-medium text-slate-700">
                                        {{ $task['bay'] }}
                                    </span>
                                </div>


                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-4 w-4 text-slate-400"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M12 8v4l3 2"/>
                                        <circle cx="12" cy="12" r="9"/>
                                    </svg>

                                    <span class="text-slate-500">Estimated</span>

                                    <span class="font-medium text-slate-700">
                                        {{ $task['estimated_time'] }}
                                    </span>
                                </div>

                            </div>


                            {{-- Timeline --}}
                            @if ($task['started_at'] || $task['completed_at'])

                                <div class="mt-4 flex flex-wrap gap-4 border-t border-slate-100 pt-3 text-xs text-slate-500">

                                    @if ($task['started_at'])
                                        <span>
                                            Started:
                                            <strong class="font-medium text-slate-700">
                                                {{ $task['started_at'] }}
                                            </strong>
                                        </span>
                                    @endif

                                    @if ($task['completed_at'])
                                        <span>
                                            Completed:
                                            <strong class="font-medium text-slate-700">
                                                {{ $task['completed_at'] }}
                                            </strong>
                                        </span>
                                    @endif

                                </div>

                            @endif

                        </div>


                        {{-- Right Side --}}
                        <div class="flex shrink-0 flex-col items-start gap-3 xl:items-end">

                            <div class="flex items-center gap-2">

                                @if ($task['priority'] === 'High')
                                    <span class="rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-hitek-red">
                                        High Priority
                                    </span>
                                @elseif ($task['priority'] === 'Medium')
                                    <span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">
                                        Medium Priority
                                    </span>
                                @else
                                    <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">
                                        Low Priority
                                    </span>
                                @endif

                            </div>


                            @if ($task['parts_pending'])

                                <div class="flex items-center gap-2 rounded-lg border border-amber-200 bg-amber-50 px-3 py-2 text-xs font-medium text-amber-800">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-4 w-4"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M12 9v4m0 4h.01"/>
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M10.3 3.7L2.6 17a2 2 0 001.7 3h15.4a2 2 0 001.7-3L13.7 3.7a2 2 0 00-3.4 0z"/>
                                    </svg>

                                    Parts Pending
                                </div>

                            @endif


                            <div class="flex items-center gap-2">

                                <button
                                    type="button"
                                    class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600 transition hover:bg-slate-50"
                                >
                                    View
                                </button>

                                <button
                                    type="button"
                                    class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-600 transition hover:bg-slate-50"
                                >
                                    Edit
                                </button>

                                <button
                                    type="button"
                                    class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-hitek-red transition hover:bg-red-100"
                                >
                                    Delete
                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</div>