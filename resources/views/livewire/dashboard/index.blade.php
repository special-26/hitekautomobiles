
<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                Workshop Dashboard
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Here's what's happening at your workshop today.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <div class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm text-slate-600">
                Friday, 13 November 2026
            </div>
            <button class="rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-red-700">
                + Create Job Card
            </button>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Active Job Cards</p>
                <span class="rounded-lg bg-red-50 p-2 text-red-600">▣</span>
            </div>
            <div class="mt-3 flex items-end justify-between">
                <h3 class="text-3xl font-bold text-slate-900">32</h3>
                <span class="text-xs font-semibold text-emerald-600">+12% this week</span>
            </div>
            <p class="mt-2 text-xs text-slate-400">Vehicles currently in workshop</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Today's Bookings</p>
                <span class="rounded-lg bg-blue-50 p-2 text-blue-600">▦</span>
            </div>
            <div class="mt-3 flex items-end justify-between">
                <h3 class="text-3xl font-bold text-slate-900">12</h3>
                <span class="text-xs font-semibold text-emerald-600">8 confirmed</span>
            </div>
            <p class="mt-2 text-xs text-slate-400">4 bookings awaiting confirmation</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Today's Collection</p>
                <span class="rounded-lg bg-emerald-50 p-2 text-emerald-600">₹</span>
            </div>
            <div class="mt-3 flex items-end justify-between">
                <h3 class="text-3xl font-bold text-slate-900">₹84,500</h3>
                <span class="text-xs font-semibold text-emerald-600">+8.5%</span>
            </div>
            <p class="mt-2 text-xs text-slate-400">Payments received today</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Monthly Revenue</p>
                <span class="rounded-lg bg-violet-50 p-2 text-violet-600">↗</span>
            </div>
            <div class="mt-3 flex items-end justify-between">
                <h3 class="text-3xl font-bold text-slate-900">₹12.8L</h3>
                <span class="text-xs font-semibold text-emerald-600">+15.2%</span>
            </div>
            <p class="mt-2 text-xs text-slate-400">Compared with previous month</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Employees Present</p>
                <span class="rounded-lg bg-amber-50 p-2 text-amber-600">♙</span>
            </div>
            <div class="mt-3 flex items-end justify-between">
                <h3 class="text-3xl font-bold text-slate-900">18 / 22</h3>
                <span class="text-xs font-semibold text-emerald-600">82% present</span>
            </div>
            <p class="mt-2 text-xs text-slate-400">4 employees absent or on leave</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Bay Occupancy</p>
                <span class="rounded-lg bg-red-50 p-2 text-red-600">▤</span>
            </div>
            <div class="mt-3 flex items-end justify-between">
                <h3 class="text-3xl font-bold text-slate-900">8 / 10</h3>
                <span class="text-xs font-semibold text-amber-600">80% occupied</span>
            </div>
            <p class="mt-2 text-xs text-slate-400">2 bays currently available</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Ready for Delivery</p>
                <span class="rounded-lg bg-emerald-50 p-2 text-emerald-600">✓</span>
            </div>
            <div class="mt-3 flex items-end justify-between">
                <h3 class="text-3xl font-bold text-slate-900">7</h3>
                <span class="text-xs font-semibold text-emerald-600">5 unpaid</span>
            </div>
            <p class="mt-2 text-xs text-slate-400">Vehicles awaiting customer collection</p>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">Pending Payroll</p>
                <span class="rounded-lg bg-orange-50 p-2 text-orange-600">₹</span>
            </div>
            <div class="mt-3 flex items-end justify-between">
                <h3 class="text-3xl font-bold text-slate-900">₹1.45L</h3>
                <span class="text-xs font-semibold text-orange-600">Pending</span>
            </div>
            <p class="mt-2 text-xs text-slate-400">Current payroll cycle</p>
        </div>

    </div>

    <!-- Charts -->
    <div class="grid gap-6 xl:grid-cols-3">

        <!-- Revenue chart -->
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm xl:col-span-2">

            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h3 class="font-bold text-slate-900">Revenue Overview</h3>
                    <p class="mt-1 text-xs text-slate-500">Workshop collection performance</p>
                </div>

                <select class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-600">
                    <option>This Week</option>
                    <option>This Month</option>
                    <option>This Year</option>
                </select>
            </div>

            <div class="mt-6 flex items-end justify-between gap-3 border-b border-slate-100 pb-2">
                <div>
                    <p class="text-xs text-slate-500">Total Revenue</p>
                    <p class="mt-1 text-2xl font-bold text-slate-900">₹4,85,000</p>
                    <p class="mt-1 text-xs font-medium text-emerald-600">↑ 12.8% vs previous period</p>
                </div>
                <div class="text-right text-xs text-slate-400">
                    <span class="inline-block h-2 w-2 rounded-full bg-red-600"></span>
                    Revenue
                </div>
            </div>

            <!-- CSS bar chart -->
            <div class="mt-8 flex h-52 items-end justify-around gap-3 border-b border-slate-200 px-2">

                <div class="flex h-full flex-1 flex-col items-center justify-end gap-2">
                    <span class="text-xs text-slate-500">₹48k</span>
                    <div class="w-full max-w-12 rounded-t-md bg-red-300" style="height:45%"></div>
                    <span class="text-xs text-slate-500">Mon</span>
                </div>

                <div class="flex h-full flex-1 flex-col items-center justify-end gap-2">
                    <span class="text-xs text-slate-500">₹65k</span>
                    <div class="w-full max-w-12 rounded-t-md bg-red-400" style="height:62%"></div>
                    <span class="text-xs text-slate-500">Tue</span>
                </div>

                <div class="flex h-full flex-1 flex-col items-center justify-end gap-2">
                    <span class="text-xs text-slate-500">₹58k</span>
                    <div class="w-full max-w-12 rounded-t-md bg-red-400" style="height:55%"></div>
                    <span class="text-xs text-slate-500">Wed</span>
                </div>

                <div class="flex h-full flex-1 flex-col items-center justify-end gap-2">
                    <span class="text-xs text-slate-500">₹82k</span>
                    <div class="w-full max-w-12 rounded-t-md bg-red-500" style="height:78%"></div>
                    <span class="text-xs text-slate-500">Thu</span>
                </div>

                <div class="flex h-full flex-1 flex-col items-center justify-end gap-2">
                    <span class="text-xs text-slate-500">₹84k</span>
                    <div class="w-full max-w-12 rounded-t-md bg-red-600" style="height:85%"></div>
                    <span class="text-xs text-slate-500">Fri</span>
                </div>

                <div class="flex h-full flex-1 flex-col items-center justify-end gap-2">
                    <span class="text-xs text-slate-500">₹0</span>
                    <div class="w-full max-w-12 rounded-t-md bg-slate-100" style="height:4%"></div>
                    <span class="text-xs text-slate-500">Sat</span>
                </div>

                <div class="flex h-full flex-1 flex-col items-center justify-end gap-2">
                    <span class="text-xs text-slate-500">₹0</span>
                    <div class="w-full max-w-12 rounded-t-md bg-slate-100" style="height:4%"></div>
                    <span class="text-xs text-slate-500">Sun</span>
                </div>

            </div>
        </div>

        <!-- Job status -->
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <h3 class="font-bold text-slate-900">Job Card Overview</h3>
            <p class="mt-1 text-xs text-slate-500">Current job distribution</p>

            <div class="mt-8 flex items-center justify-center">
                <div class="relative flex h-40 w-40 items-center justify-center rounded-full"
                     style="background:conic-gradient(#dc2626 0% 56%, #f59e0b 56% 75%, #10b981 75% 90%, #cbd5e1 90% 100%)">
                    <div class="flex h-28 w-28 flex-col items-center justify-center rounded-full bg-white">
                        <span class="text-3xl font-bold text-slate-900">32</span>
                        <span class="text-xs text-slate-500">Total Jobs</span>
                    </div>
                </div>
            </div>

            <div class="mt-8 space-y-4">

                <div class="flex items-center justify-between text-sm">
                    <span class="flex items-center gap-2 text-slate-600">
                        <span class="h-2.5 w-2.5 rounded-full bg-red-600"></span>
                        Under Service
                    </span>
                    <span class="font-semibold text-slate-900">18</span>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <span class="flex items-center gap-2 text-slate-600">
                        <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>
                        Inspection / Pending
                    </span>
                    <span class="font-semibold text-slate-900">6</span>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <span class="flex items-center gap-2 text-slate-600">
                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                        Ready for Delivery
                    </span>
                    <span class="font-semibold text-slate-900">5</span>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <span class="flex items-center gap-2 text-slate-600">
                        <span class="h-2.5 w-2.5 rounded-full bg-slate-300"></span>
                        Other
                    </span>
                    <span class="font-semibold text-slate-900">3</span>
                </div>

            </div>
        </div>
    </div>

    <!-- Workshop Operations -->
    <div class="grid gap-6 xl:grid-cols-2">

        <!-- Bay occupancy -->
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-slate-900">Workshop Bays</h3>
                    <p class="mt-1 text-xs text-slate-500">Live bay occupancy</p>
                </div>
                <a href="#" class="text-sm font-semibold text-red-600 hover:text-red-700">
                    View Bays →
                </a>
            </div>

            <div class="mt-5 space-y-5">

                <div>
                    <div class="mb-2 flex justify-between text-sm">
                        <span class="font-medium text-slate-700">Occupied Bays</span>
                        <span class="font-semibold text-slate-900">8 / 10</span>
                    </div>
                    <div class="h-3 overflow-hidden rounded-full bg-slate-100">
                        <div class="h-full w-[80%] rounded-full bg-red-600"></div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="rounded-lg bg-red-50 p-4">
                        <p class="text-xs text-red-600">Occupied</p>
                        <p class="mt-1 text-2xl font-bold text-red-700">8</p>
                    </div>
                    <div class="rounded-lg bg-emerald-50 p-4">
                        <p class="text-xs text-emerald-600">Available</p>
                        <p class="mt-1 text-2xl font-bold text-emerald-700">2</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance -->
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-slate-900">Employee Attendance</h3>
                    <p class="mt-1 text-xs text-slate-500">Today's workforce status</p>
                </div>
                <a href="#" class="text-sm font-semibold text-red-600 hover:text-red-700">
                    View Attendance →
                </a>
            </div>

            <div class="mt-5 grid grid-cols-3 gap-3">
                <div class="rounded-lg bg-emerald-50 p-3 text-center">
                    <p class="text-2xl font-bold text-emerald-700">18</p>
                    <p class="mt-1 text-xs text-emerald-600">Present</p>
                </div>
                <div class="rounded-lg bg-red-50 p-3 text-center">
                    <p class="text-2xl font-bold text-red-700">2</p>
                    <p class="mt-1 text-xs text-red-600">Absent</p>
                </div>
                <div class="rounded-lg bg-amber-50 p-3 text-center">
                    <p class="text-2xl font-bold text-amber-700">2</p>
                    <p class="mt-1 text-xs text-amber-600">On Leave</p>
                </div>
            </div>

            <div class="mt-5">
                <div class="mb-2 flex justify-between text-xs text-slate-500">
                    <span>Attendance Rate</span>
                    <span class="font-semibold text-slate-700">82%</span>
                </div>
                <div class="h-3 overflow-hidden rounded-full bg-slate-100">
                    <div class="h-full w-[82%] rounded-full bg-emerald-500"></div>
                </div>
            </div>
        </div>

    </div>

    <!-- Recent Job Cards -->
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">

        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 p-5">
            <div>
                <h3 class="font-bold text-slate-900">Recent Job Cards</h3>
                <p class="mt-1 text-xs text-slate-500">Latest workshop activity</p>
            </div>
            <a href="#" class="text-sm font-semibold text-red-600 hover:text-red-700">
                View All Job Cards →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-3 font-semibold">Job Card</th>
                        <th class="px-5 py-3 font-semibold">Customer / Vehicle</th>
                        <th class="px-5 py-3 font-semibold">Service</th>
                        <th class="px-5 py-3 font-semibold">Advisor</th>
                        <th class="px-5 py-3 font-semibold">Amount</th>
                        <th class="px-5 py-3 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">

                    <tr class="hover:bg-slate-50">
                        <td class="whitespace-nowrap px-5 py-4 font-semibold text-red-600">#JC-0248</td>
                        <td class="px-5 py-4">
                            <p class="font-medium text-slate-900">Rahul Sharma</p>
                            <p class="mt-1 text-xs text-slate-500">Hyundai Creta · CH01AB1234</p>
                        </td>
                        <td class="px-5 py-4 text-slate-600">General Service</td>
                        <td class="px-5 py-4 text-slate-600">Amit</td>
                        <td class="whitespace-nowrap px-5 py-4 font-semibold text-slate-900">₹8,500</td>
                        <td class="px-5 py-4">
                            <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">Under Service</span>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-50">
                        <td class="whitespace-nowrap px-5 py-4 font-semibold text-red-600">#JC-0247</td>
                        <td class="px-5 py-4">
                            <p class="font-medium text-slate-900">Neha Gupta</p>
                            <p class="mt-1 text-xs text-slate-500">Honda City · CH03CD5678</p>
                        </td>
                        <td class="px-5 py-4 text-slate-600">Denting & Painting</td>
                        <td class="px-5 py-4 text-slate-600">Rohit</td>
                        <td class="whitespace-nowrap px-5 py-4 font-semibold text-slate-900">₹22,000</td>
                        <td class="px-5 py-4">
                            <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">Ready</span>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-50">
                        <td class="whitespace-nowrap px-5 py-4 font-semibold text-red-600">#JC-0246</td>
                        <td class="px-5 py-4">
                            <p class="font-medium text-slate-900">Aman Verma</p>
                            <p class="mt-1 text-xs text-slate-500">Maruti Swift · PB10EF9012</p>
                        </td>
                        <td class="px-5 py-4 text-slate-600">Car Washing</td>
                        <td class="px-5 py-4 text-slate-600">Sandeep</td>
                        <td class="whitespace-nowrap px-5 py-4 font-semibold text-slate-900">₹2,500</td>
                        <td class="px-5 py-4">
                            <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">Inspection</span>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

    <!-- Bottom section -->
    <div class="grid gap-6 xl:grid-cols-2">

        <!-- Today's bookings -->
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-slate-900">Upcoming Bookings</h3>
                    <p class="mt-1 text-xs text-slate-500">Today's scheduled appointments</p>
                </div>
                <a href="#" class="text-sm font-semibold text-red-600">View All →</a>
            </div>

            <div class="mt-5 space-y-4">
                <div class="flex items-center gap-4">
                    <div class="w-16 rounded-lg bg-slate-50 p-3 text-center">
                        <p class="font-bold text-slate-900">11:00</p>
                        <p class="text-xs text-slate-500">AM</p>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-slate-900">Vikram Singh</p>
                        <p class="text-xs text-slate-500">Toyota Fortuner · General Service</p>
                    </div>
                    <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">Confirmed</span>
                </div>

                <div class="flex items-center gap-4">
                    <div class="w-16 rounded-lg bg-slate-50 p-3 text-center">
                        <p class="font-bold text-slate-900">12:30</p>
                        <p class="text-xs text-slate-500">PM</p>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-slate-900">Priya Malhotra</p>
                        <p class="text-xs text-slate-500">Kia Seltos · Car Detailing</p>
                    </div>
                    <span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">Pending</span>
                </div>

                <div class="flex items-center gap-4">
                    <div class="w-16 rounded-lg bg-slate-50 p-3 text-center">
                        <p class="font-bold text-slate-900">02:00</p>
                        <p class="text-xs text-slate-500">PM</p>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-slate-900">Karan Mehta</p>
                        <p class="text-xs text-slate-500">Mahindra Thar · Denting & Painting</p>
                    </div>
                    <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">Confirmed</span>
                </div>
            </div>
        </div>

        <!-- Marketing performance -->
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-slate-900">Marketing Performance</h3>
                    <p class="mt-1 text-xs text-slate-500">Lead generation overview</p>
                </div>
                <a href="#" class="text-sm font-semibold text-red-600">Open Studio →</a>
            </div>

            <div class="mt-5 grid grid-cols-2 gap-4">
                <div class="rounded-lg bg-slate-50 p-4">
                    <p class="text-xs text-slate-500">Total Leads</p>
                    <p class="mt-2 text-2xl font-bold text-slate-900">146</p>
                    <p class="mt-1 text-xs text-emerald-600">+18% this month</p>
                </div>
                <div class="rounded-lg bg-slate-50 p-4">
                    <p class="text-xs text-slate-500">Converted Leads</p>
                    <p class="mt-2 text-2xl font-bold text-slate-900">38</p>
                    <p class="mt-1 text-xs text-emerald-600">26% conversion</p>
                </div>
            </div>

            <div class="mt-5">
                <div class="mb-2 flex justify-between text-sm">
                    <span class="text-slate-600">Lead Conversion</span>
                    <span class="font-semibold text-slate-900">26%</span>
                </div>
                <div class="h-3 overflow-hidden rounded-full bg-slate-100">
                    <div class="h-full w-[26%] rounded-full bg-red-600"></div>
                </div>
            </div>
        </div>

    </div>

</div>
