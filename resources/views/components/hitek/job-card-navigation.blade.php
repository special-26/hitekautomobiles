@props([
    'jobCardId',
    'active' => 'overview',
])

@php
    $tabs = [
        [
            'key' => 'overview',
            'label' => 'Overview',
            'route' => 'job-cards.show',
            'available' => true,
        ],
        [
            'key' => 'customer-vehicle',
            'label' => 'Customer & Vehicle',
            'route' => 'job-cards.customer-vehicle',
            'available' => true,
        ],
        [
            'key' => 'tasks',
            'label' => 'Tasks',
            'route' => 'job-cards.tasks',
            'available' => true,
        ],
        [
            'key' => 'parts',
            'label' => 'Parts',
            'route' => 'job-cards.parts',
            'available' => true,
        ],
        [
            'key' => 'images',
            'label' => 'Images',
            'route' => 'job-cards.images',
            'available' => true,
        ],
        [
            'key' => 'insurance',
            'label' => 'Insurance',
            'route' => 'job-cards.insurance',
            'available' => true,
        ],
        [
            'key' => 'billing',
            'label' => 'Billing',
            'route' => 'job-cards.billing',
            'available' => true,
        ],
        [
            'key' => 'payments',
            'label' => 'Payments',
            'route' => 'job-cards.payments',
            'available' => true,
        ],
        [
            'key' => 'history',
            'label' => 'History',
            'route' => 'job-cards.history',
            'available' => true,
        ],
    ];
@endphp

<div class="overflow-x-auto rounded-xl border border-slate-300 bg-white">
    <div class="flex min-w-max items-center px-2">

        @foreach ($tabs as $tab)

            @php
                $isActive = $active === $tab['key'];
            @endphp

            @if ($isActive)

                <div
                    class="border-b-2 border-hitek-red px-4 py-3 text-sm font-semibold text-hitek-red"
                >
                    {{ $tab['label'] }}
                </div>

            @elseif ($tab['available'])

                <a
                    href="{{ route($tab['route'], $jobCardId) }}"
                    class="border-b-2 border-transparent px-4 py-3 text-sm font-medium text-slate-500 transition hover:text-slate-900"
                >
                    {{ $tab['label'] }}
                </a>

            @else

                <span
                    class="cursor-not-allowed border-b-2 border-transparent px-4 py-3 text-sm font-medium text-slate-300"
                    title="Coming soon"
                >
                    {{ $tab['label'] }}
                </span>

            @endif

        @endforeach

    </div>
</div>