<x-layouts.app>

    <div class="space-y-6">

        {{-- Page heading --}}
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                Dashboard
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Overview of your workshop operations.
            </p>
        </div>

        {{-- Stats --}}
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

            <div class="rounded-xl border border-slate-200 bg-white p-5">
                <p class="text-sm text-slate-500">
                    Active Job Cards
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    32
                </p>

                <p class="mt-2 text-xs text-emerald-600">
                    +8% from last week
                </p>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-5">
                <p class="text-sm text-slate-500">
                    Under Service
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    18
                </p>

                <p class="mt-2 text-xs text-slate-500">
                    Currently in workshop
                </p>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-5">
                <p class="text-sm text-slate-500">
                    Ready for Delivery
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    7
                </p>

                <p class="mt-2 text-xs text-amber-600">
                    Requires attention
                </p>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-5">
                <p class="text-sm text-slate-500">
                    Today's Collection
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    ₹84,500
                </p>

                <p class="mt-2 text-xs text-emerald-600">
                    Today's total
                </p>
            </div>

        </div>

        {{-- Recent Job Cards --}}
        <div class="rounded-xl border border-slate-200 bg-white">

            <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">

                <div>
                    <h3 class="text-sm font-semibold text-slate-900">
                        Recent Job Cards
                    </h3>

                    <p class="mt-1 text-xs text-slate-500">
                        Latest workshop activity
                    </p>
                </div>

                <button
                    class="rounded-lg bg-hitek-red px-3 py-2 text-xs font-semibold text-white transition hover:bg-hitek-red-hover"
                >
                    View All
                </button>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full text-left text-sm">

                    <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">

                        <tr>
                            <th class="px-5 py-3 font-medium">
                                Job Card
                            </th>

                            <th class="px-5 py-3 font-medium">
                                Vehicle
                            </th>

                            <th class="px-5 py-3 font-medium">
                                Customer
                            </th>

                            <th class="px-5 py-3 font-medium">
                                Status
                            </th>

                            <th class="px-5 py-3 text-right font-medium">
                                Amount
                            </th>
                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        <tr class="transition hover:bg-slate-50">
                            <td class="px-5 py-4 font-semibold text-slate-900">
                                #JC-13887
                            </td>

                            <td class="px-5 py-4">
                                Hyundai Creta
                                <div class="text-xs text-slate-500">
                                    CH01BT9020
                                </div>
                            </td>

                            <td class="px-5 py-4">
                                Customer Name
                            </td>

                            <td class="px-5 py-4">
                                <span class="inline-flex rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700">
                                    Under Service
                                </span>
                            </td>

                            <td class="px-5 py-4 text-right font-semibold">
                                ₹47,234
                            </td>
                        </tr>

                        <tr class="transition hover:bg-slate-50">
                            <td class="px-5 py-4 font-semibold text-slate-900">
                                #JC-13888
                            </td>

                            <td class="px-5 py-4">
                                Maruti Swift
                                <div class="text-xs text-slate-500">
                                    PB39M2956
                                </div>
                            </td>

                            <td class="px-5 py-4">
                                Customer Name
                            </td>

                            <td class="px-5 py-4">
                                <span class="inline-flex rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700">
                                    Ready
                                </span>
                            </td>

                            <td class="px-5 py-4 text-right font-semibold">
                                ₹12,500
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-layouts.app>