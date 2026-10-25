<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">

        <div class="flex items-center gap-4">

            <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-red-100 text-xl font-bold text-red-600">
                {{ strtoupper(substr($employee->user->name, 0, 1)) }}
            </div>

            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-semibold text-slate-900">
                        {{ $employee->user->name }}
                    </h1>

                    <span class="rounded-full px-2.5 py-1 text-xs font-medium
                        {{ $employee->status === 'active'
                            ? 'bg-green-100 text-green-700'
                            : 'bg-slate-100 text-slate-600' }}">
                        {{ ucfirst(str_replace('_', ' ', $employee->status)) }}
                    </span>
                </div>

                <p class="mt-1 text-sm text-slate-500">
                    {{ $employee->employee_code }}
                    @if($employee->designation)
                        · {{ $employee->designation }}
                    @endif
                </p>
            </div>

        </div>

        <div class="flex gap-2">

            <a
                href="{{ route('employees.index') }}"
                class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm
                       font-medium text-slate-700 hover:bg-slate-50"
            >
                ← Employees
            </a>

            @if (auth()->user()->can('employees.status.update'))
                @if ($employee->status === 'active')
                    <button
                        type="button"
                        wire:click="toggleStatus"
                        wire:confirm="Deactivate this employee? They will no longer be able to log in."
                        class="rounded-lg border border-red-200 bg-white px-4 py-2
                            text-sm font-semibold text-red-600 hover:bg-red-50"
                    >
                        Deactivate Employee
                    </button>
                @else
                    <button
                        type="button"
                        wire:click="toggleStatus"
                        wire:confirm="Reactivate this employee's account?"
                        class="rounded-lg bg-green-600 px-4 py-2 text-sm
                            font-semibold text-white hover:bg-green-700"
                    >
                        Activate Employee
                    </button>
                @endif
            @endif

            <a
                href="{{ route('employees.edit', $employee) }}"
                class="rounded-lg bg-hitek-red px-4 py-2 text-sm font-semibold text-white
                       hover:bg-hitek-red-hover"
            >
                Edit Employee
            </a>

        </div>

    </div>


    {{-- Main grid --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- ====================================================== --}}
        {{-- BASIC INFORMATION --}}
        {{-- ====================================================== --}}

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white lg:col-span-2">

            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="font-semibold text-slate-900">
                    Employee Information
                </h2>
            </div>

            <div class="grid grid-cols-1 gap-5 p-6 sm:grid-cols-2">

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Full Name
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-900">
                        {{ $employee->user->name }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Employee Code
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-900">
                        {{ $employee->employee_code }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Email
                    </p>

                    <p class="mt-1 text-sm text-slate-700">
                        {{ $employee->user->email }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Phone
                    </p>

                    <p class="mt-1 text-sm text-slate-700">
                        {{ $employee->phone ?: '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Role
                    </p>

                    <p class="mt-1 text-sm font-medium text-slate-900">
                        {{ $employee->user->roles->pluck('name')->join(', ') ?: '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Department
                    </p>

                    <p class="mt-1 text-sm text-slate-700">
                        {{ $employee->department?->name ?: '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Designation
                    </p>

                    <p class="mt-1 text-sm text-slate-700">
                        {{ $employee->designation ?: '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Joining Date
                    </p>

                    <p class="mt-1 text-sm text-slate-700">
                        {{ $employee->joining_date?->format('d M Y') ?: '—' }}
                    </p>
                </div>

            </div>
        </div>


        {{-- ====================================================== --}}
        {{-- PERSONAL --}}
        {{-- ====================================================== --}}

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="font-semibold text-slate-900">
                    Personal Details
                </h2>
            </div>

            <div class="space-y-5 p-6">

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Date of Birth
                    </p>

                    <p class="mt-1 text-sm text-slate-700">
                        {{ $employee->date_of_birth?->format('d M Y') ?: '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Gender
                    </p>

                    <p class="mt-1 text-sm text-slate-700">
                        {{ $employee->gender ?: '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Address
                    </p>

                    <p class="mt-1 text-sm text-slate-700">
                        {{ $employee->address ?: '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Location
                    </p>

                    <p class="mt-1 text-sm text-slate-700">
                        {{ collect([
                            $employee->city,
                            $employee->state,
                            $employee->pincode,
                        ])->filter()->join(', ') ?: '—' }}
                    </p>
                </div>

            </div>
        </div>

    </div>


    {{-- ========================================================== --}}
    {{-- EMERGENCY CONTACT --}}
    {{-- ========================================================== --}}

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="font-semibold text-slate-900">
                Emergency Contact
            </h2>
        </div>

        <div class="grid grid-cols-1 gap-5 p-6 sm:grid-cols-2">

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Contact Name
                </p>

                <p class="mt-1 text-sm text-slate-700">
                    {{ $employee->emergency_contact_name ?: '—' }}
                </p>
            </div>

            <div>
                <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                    Contact Phone
                </p>

                <p class="mt-1 text-sm text-slate-700">
                    {{ $employee->emergency_contact_phone ?: '—' }}
                </p>
            </div>

        </div>
    </div>

    {{-- ========================================================== --}}
    {{-- Bank Account --}}
    {{-- ========================================================== --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
            <div>
                <h2 class="font-semibold text-slate-900">Bank Details</h2>
                <p class="mt-1 text-xs text-slate-500">
                    Salary payment account information.
                </p>
            </div>

            @can('employees.bank-details.manage')
                <button
                    type="button"
                    wire:click="openBankModal"
                    class="rounded-lg bg-hitek-red px-4 py-2 text-sm font-semibold text-white hover:bg-hitek-red-hover"
                >
                    + Add Bank Account
                </button>
            @endcan
        </div>

        <div class="p-6">
            @if ($employee->bankAccounts->isNotEmpty())
                <div class="space-y-4">
                    @foreach ($employee->bankAccounts as $account)
                        <div class="flex flex-col gap-4 rounded-lg border border-slate-200 p-4 sm:flex-row sm:items-center sm:justify-between">
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="font-medium text-slate-900">
                                        {{ $account->bank_name }}
                                    </h3>

                                    @if ($account->is_primary)
                                        <span class="rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700">
                                            Primary
                                        </span>
                                    @endif
                                </div>

                                <p class="mt-1 text-sm text-slate-600">
                                    {{ $account->account_holder_name }}
                                </p>

                                <p class="mt-1 text-sm text-slate-500">
                                    Account: ••••{{ substr($account->account_number, -4) }}
                                    <span class="mx-1">·</span>
                                    IFSC: {{ $account->ifsc_code }}
                                </p>

                                @if ($account->branch_name)
                                    <p class="mt-1 text-xs text-slate-500">
                                        Branch: {{ $account->branch_name }}
                                    </p>
                                @endif
                            </div>

                            @can('employees.bank-details.manage')
                                <div class="flex shrink-0 gap-2">
                                    <button
                                        type="button"
                                        wire:click="openBankModal({{ $account->id }})"
                                        class="rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50"
                                    >
                                        Edit
                                    </button>

                                    <button
                                        type="button"
                                        wire:click="deleteBankAccount({{ $account->id }})"
                                        wire:confirm="Delete this bank account?"
                                        class="rounded-lg border border-red-200 px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50"
                                    >
                                        Delete
                                    </button>
                                </div>
                            @endcan
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-8 text-center">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100">
                        <icon name="landmark" size="xl"/>
                    </div>

                    <h3 class="mt-3 text-sm font-semibold text-slate-900">
                        No bank account added
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Add the employee's bank account for future salary payments.
                    </p>
                </div>
            @endif
        </div>
    </div>


    {{-- ========================================================== --}}
    {{-- SALARY STRUCTURE --}}
    {{-- ========================================================== --}}
    @php
        $today = now()->toDateString();

        $currentSalary = $employee->salaryHistories->first(
            fn ($salary) =>
                $salary->effective_from->toDateString() <= $today
                && (
                    $salary->effective_to === null
                    || $salary->effective_to->toDateString() >= $today
                )
        );
    @endphp
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

        <div class="flex flex-col gap-3 border-b border-slate-200 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-slate-900">Salary Structure</h2>
                <p class="mt-1 text-xs text-slate-500">
                    Monthly salary components and salary history.
                </p>
            </div>

            @can('employees.salary.manage')
                <button
                    type="button"
                    wire:click="openSalaryModal"
                    class="rounded-lg bg-hitek-red px-4 py-2 text-sm font-semibold text-white hover:bg-hitek-red-hover"
                >
                    + Add Salary Structure
                </button>
            @endcan
        </div>

        <div class="p-6">
            @if (session()->has('success'))
                <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if ($currentSalary)
                @php
                    $grossSalary =
                        (float) $currentSalary->basic_salary
                        + (float) $currentSalary->hra
                        + (float) $currentSalary->transport_allowance
                        + (float) $currentSalary->other_allowances;

                    $netSalary = $grossSalary
                        - (float) $currentSalary->other_deductions;
                @endphp

                <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-5">
                        <p class="text-sm text-slate-500">Monthly Gross Salary</p>
                        <p class="mt-2 text-2xl font-bold text-slate-900">
                            ₹{{ number_format($grossSalary, 2) }}
                        </p>
                        <p class="mt-1 text-xs text-slate-500">
                            Before deductions
                        </p>
                    </div>

                    <div class="rounded-xl border border-green-200 bg-green-50 p-5">
                        <p class="text-sm text-green-700">Fixed Net Salary</p>
                        <p class="mt-2 text-2xl font-bold text-green-800">
                            ₹{{ number_format($netSalary, 2) }}
                        </p>
                        <p class="mt-1 text-xs text-green-700">
                            After configured deductions, before any other payroll adjustments
                        </p>
                    </div>
                </div>

                <div class="mb-6">
                    <div class="mb-3 flex flex-wrap items-center justify-between gap-2">
                        <h3 class="font-semibold text-slate-900">Current Breakdown</h3>
                        <span class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">
                            Effective {{ $currentSalary->effective_from->format('d M Y') }}
                        </span>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-slate-200">
                        <table class="w-full text-sm">
                            <tbody class="divide-y divide-slate-100">
                                <tr>
                                    <td class="px-4 py-3 text-slate-600">Basic Salary</td>
                                    <td class="px-4 py-3 text-right font-medium text-slate-900">
                                        ₹{{ number_format((float) $currentSalary->basic_salary, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 text-slate-600">HRA</td>
                                    <td class="px-4 py-3 text-right font-medium text-slate-900">
                                        ₹{{ number_format((float) $currentSalary->hra, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 text-slate-600">Transport Allowance</td>
                                    <td class="px-4 py-3 text-right font-medium text-slate-900">
                                        ₹{{ number_format((float) $currentSalary->transport_allowance, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 text-slate-600">Other Allowances</td>
                                    <td class="px-4 py-3 text-right font-medium text-slate-900">
                                        ₹{{ number_format((float) $currentSalary->other_allowances, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 text-slate-600">Other Deductions</td>
                                    <td class="px-4 py-3 text-right font-medium text-red-600">
                                        −₹{{ number_format((float) $currentSalary->other_deductions, 2) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    @if ($currentSalary->notes)
                        <p class="mt-3 text-sm text-slate-500">
                            <span class="font-medium">Notes:</span>
                            {{ $currentSalary->notes }}
                        </p>
                    @endif
                </div>
            @else
                <div class="rounded-lg border border-dashed border-slate-300 px-6 py-10 text-center">
                    <h3 class="font-semibold text-slate-900">No current salary structure</h3>
                    <p class="mt-2 text-sm text-slate-500">
                        No salary record is effective today.
                        @if (auth()->user()->can('employees.salary.manage'))
                            Add a salary structure to get started.
                        @endif
                    </p>
                </div>
            @endif

            {{-- Salary history --}}
            <div class="mt-6">
                <h3 class="mb-3 font-semibold text-slate-900">Salary History</h3>

                @if ($employee->salaryHistories->isNotEmpty())
                    <div class="overflow-x-auto rounded-lg border border-slate-200">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                                <tr>
                                    <th class="px-4 py-3">Effective From</th>
                                    <th class="px-4 py-3">Effective To</th>
                                    <th class="px-4 py-3 text-right">Gross / Month</th>
                                    <th class="px-4 py-3 text-right">Net / Month</th>
                                    <th class="px-4 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($employee->salaryHistories as $salary)
                                    @php
                                        $gross =
                                            (float) $salary->basic_salary
                                            + (float) $salary->hra
                                            + (float) $salary->transport_allowance
                                            + (float) $salary->other_allowances;

                                        $net = $gross - (float) $salary->other_deductions;

                                        $isCurrent =
                                            $salary->effective_from->toDateString() <= $today
                                            && (
                                                $salary->effective_to === null
                                                || $salary->effective_to->toDateString() >= $today
                                            );

                                        $isFuture = $salary->effective_from->toDateString() > $today;
                                    @endphp

                                    <tr class="hover:bg-slate-50">
                                        <td class="whitespace-nowrap px-4 py-3 text-slate-700">
                                            {{ $salary->effective_from->format('d M Y') }}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 text-slate-600">
                                            {{ $salary->effective_to?->format('d M Y') ?? '—' }}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 text-right font-medium text-slate-900">
                                            ₹{{ number_format($gross, 2) }}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 text-right font-medium text-slate-900">
                                            ₹{{ number_format($net, 2) }}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3">
                                            @if ($isCurrent)
                                                <span class="rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700">
                                                    Current
                                                </span>
                                            @elseif ($isFuture)
                                                <span class="rounded-full bg-blue-100 px-2 py-1 text-xs font-medium text-blue-700">
                                                    Upcoming
                                                </span>
                                            @else
                                                <span class="rounded-full bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600">
                                                    Historical
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="rounded-lg bg-slate-50 px-4 py-5 text-sm text-slate-500">
                        No salary history recorded yet.
                    </p>
                @endif
            </div>
        </div>
    </div>

    {{-- ========================================================== --}}
    {{-- DOCUMENTS --}}
    {{-- ========================================================== --}}
    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">

            <div>
                <h2 class="font-semibold text-slate-900">
                    Documents & ID
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Employee identification and employment documents.
                </p>
            </div>

            <button
                type="button"
                wire:click="openUploadModal"
                class="rounded-lg bg-hitek-red px-4 py-2 text-sm font-semibold text-white
                       hover:bg-hitek-red-hover"
            >
                + Upload Document
            </button>

        </div>

        <div class="p-6">

            @if($employee->documents->count())

                <div class="divide-y divide-slate-100 grid grid-cols-4 gap-6">

                    @foreach($employee->documents as $document)

                        <x-card color="primary" accent>
                            <x-slot:header>
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24"><!-- Icon from Huge Icons by Hugeicons - undefined --><g fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linejoin="round" d="M14 3.5c3.771 0 5.657 0 6.828 1.245S22 7.993 22 12s0 6.01-1.172 7.255S17.771 20.5 14 20.5h-4c-3.771 0-5.657 0-6.828-1.245S2 16.007 2 12s0-6.01 1.172-7.255S6.229 3.5 10 3.5z"/><path stroke-linecap="round" d="M5 15.5c1.609-2.137 5.354-2.254 7 0m-1.751-5.25a1.75 1.75 0 1 1-3.5 0a1.75 1.75 0 0 1 3.5 0ZM15 9.5h4m-4 4h2"/></g></svg>
                                    {{ $document->document_type }}
                                </div>
                            </x-slot:header>
                            <div class="flex">
                                <div>    
                                    @if($document->document_number)
                                        <p class="text-xs text-slate-500">
                                            {{ $document->document_number }}
                                        </p>
                                    @endif

                                    @if($document->expires_at)
                                        <p class="mt-1 text-xs text-slate-400">
                                            Expires:
                                            {{ $document->expires_at->format('d M Y') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <x-slot:footer>
                                <div class="flex items-center gap-2">
                                    <a
                                        href="{{ route('employee-documents.download', $document) }}"
                                        class="rounded-lg border border-slate-300 bg-white px-3 py-1.5
                                            text-xs font-medium text-slate-700 hover:bg-slate-50"
                                    >
                                        View / Download
                                    </a>

                                    <button
                                        type="button"
                                        wire:click="deleteDocument({{ $document->id }})"
                                        wire:confirm="Are you sure you want to delete this document?"
                                        class="rounded-lg border border-red-200 bg-white px-3 py-1.5
                                            text-xs font-medium text-red-600 hover:bg-red-50"
                                    >
                                        Delete
                                    </button>

                                </div>
                            </x-slot:footer>
                        </x-card>

                    @endforeach

                </div>

            @else

                <div class="py-10 text-center">

                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100 text-xl">
                        📄
                    </div>

                    <h3 class="mt-3 text-sm font-semibold text-slate-900">
                        No documents uploaded
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Upload Aadhaar, PAN, driving licence and other employee documents.
                    </p>

                </div>

            @endif

        </div>

    </div>

    {{-- Add Document upload Modal --}}
    @if($showUploadModal)

        <div
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4"
            wire:click.self="closeUploadModal"
        >

            <div class="w-full max-w-2xl overflow-hidden rounded-xl bg-white shadow-xl">

                {{-- Header --}}
                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">

                    <div>
                        <h2 class="font-semibold text-slate-900">
                            Upload Employee Document
                        </h2>

                        <p class="mt-1 text-xs text-slate-500">
                            Upload an identification or employment document.
                        </p>
                    </div>

                    <button
                        type="button"
                        wire:click="closeUploadModal"
                        class="text-xl text-slate-400 hover:text-slate-600"
                    >
                        ×
                    </button>

                </div>


                {{-- Form --}}
                <form wire:submit="uploadDocument">

                    <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2">

                        {{-- Document Type --}}
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                Document Type <span class="text-red-600">*</span>
                            </label>

                            <select
                                wire:model="document_type"
                                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5
                                    text-sm outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100"
                            >
                                <option value="">Select document</option>
                                <option value="Aadhaar Card">Aadhaar Card</option>
                                <option value="PAN Card">PAN Card</option>
                                <option value="Driving Licence">Driving Licence</option>
                                <option value="Passport">Passport</option>
                                <option value="Address Proof">Address Proof</option>
                                <option value="Offer Letter">Offer Letter</option>
                                <option value="Joining Letter">Joining Letter</option>
                                <option value="Other">Other</option>
                            </select>

                            @error('document_type')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>


                        {{-- Document Number --}}
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                Document Number
                            </label>

                            <input
                                type="text"
                                wire:model="document_number"
                                placeholder="Document number"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                                    outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100"
                            >

                            @error('document_number')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>


                        {{-- File --}}
                        <div class="md:col-span-2">

                            <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                Document File <span class="text-red-600">*</span>
                            </label>

                            <input
                                type="file"
                                wire:model="document_file"
                                accept=".pdf,.jpg,.jpeg,.png"
                                class="block w-full rounded-lg border border-slate-300 bg-white text-sm
                                    file:mr-4 file:border-0 file:bg-slate-100 file:px-4 file:py-2.5
                                    file:text-sm file:font-medium"
                            >

                            <p class="mt-1.5 text-xs text-slate-500">
                                PDF, JPG, JPEG or PNG. Maximum size: 10 MB.
                            </p>

                            @error('document_file')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror

                            <div
                                wire:loading
                                wire:target="document_file"
                                class="mt-2 text-xs text-slate-500"
                            >
                                Uploading file...
                            </div>

                        </div>


                        {{-- Issue Date --}}
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                Issue Date
                            </label>

                            <input
                                type="date"
                                wire:model="issued_at"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                                    outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100"
                            >

                            @error('issued_at')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>


                        {{-- Expiry Date --}}
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                Expiry Date
                            </label>

                            <input
                                type="date"
                                wire:model="expires_at"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                                    outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100"
                            >

                            @error('expires_at')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>


                        {{-- Notes --}}
                        <div class="md:col-span-2">

                            <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                Notes
                            </label>

                            <textarea
                                wire:model="notes"
                                rows="3"
                                placeholder="Optional notes"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                                    outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100"
                            ></textarea>

                            @error('notes')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror

                        </div>

                    </div>


                    {{-- Footer --}}
                    <div class="flex justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4">

                        <button
                            type="button"
                            wire:click="closeUploadModal"
                            class="rounded-lg border border-slate-300 bg-white px-4 py-2.5
                                text-sm font-medium text-slate-700 hover:bg-slate-50"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="rounded-lg bg-hitek-red px-5 py-2.5 text-sm font-semibold
                                text-white hover:bg-hitek-red-hover
                                disabled:cursor-not-allowed disabled:opacity-60"
                        >
                            <span wire:loading.remove wire:target="uploadDocument">
                                Upload Document
                            </span>

                            <span wire:loading wire:target="uploadDocument">
                                Uploading...
                            </span>
                        </button>

                    </div>

                </form>

            </div>

        </div>

    @endif

    {{-- BANK ACCOUNT MODAL --}}
    @if ($showBankModal)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4"
        >
            <div class="w-full max-w-xl overflow-hidden rounded-xl bg-white shadow-xl">
                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                    <div>
                        <h2 class="font-semibold text-slate-900">
                            {{ $editingBankAccountId ? 'Edit Bank Account' : 'Add Bank Account' }}
                        </h2>
                        <p class="mt-1 text-xs text-slate-500">
                            Enter the employee's bank details carefully.
                        </p>
                    </div>

                    <button
                        type="button"
                        wire:click="closeBankModal"
                        class="text-xl text-slate-400 hover:text-slate-600"
                    >
                        ×
                    </button>
                </div>

                <form wire:submit="saveBankAccount">
                    <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                Account Holder Name *
                            </label>
                            <input
                                type="text"
                                wire:model="account_holder_name"
                                autocomplete="off"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100"
                            >
                            @error('account_holder_name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                Bank Name *
                            </label>
                            <input
                                type="text"
                                wire:model="bank_name"
                                autocomplete="off"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100"
                            >
                            @error('bank_name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                Account Number *
                            </label>
                            <input
                                type="password"
                                wire:model="account_number"
                                autocomplete="new-password"
                                placeholder="{{ $editingBankAccountId ? 'Re-enter account number' : 'Enter account number' }}"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100"
                            >
                            @error('account_number')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-slate-500">
                                For security, the account number is masked in the profile.
                            </p>
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                IFSC Code *
                            </label>
                            <input
                                type="text"
                                wire:model="ifsc_code"
                                maxlength="11"
                                autocomplete="off"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm uppercase focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100"
                            >
                            @error('ifsc_code')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                Branch Name
                            </label>
                            <input
                                type="text"
                                wire:model="branch_name"
                                autocomplete="off"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100"
                            >
                            @error('branch_name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="flex items-center gap-2 text-sm text-slate-700">
                                <input
                                    type="checkbox"
                                    wire:model="is_primary"
                                    class="rounded border-slate-300 text-red-600 focus:ring-red-500"
                                >
                                Use as primary salary account
                            </label>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4">
                        <button
                            type="button"
                            wire:click="closeBankModal"
                            class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="rounded-lg bg-hitek-red px-5 py-2.5 text-sm font-semibold text-white hover:bg-hitek-red-hover disabled:opacity-60"
                        >
                            <span wire:loading.remove wire:target="saveBankAccount">
                                Save Bank Details
                            </span>
                            <span wire:loading wire:target="saveBankAccount">
                                Saving...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif


    {{-- SALARY STRUCTURE MODAL --}}
    @if ($showSalaryModal)
        <div
            class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-slate-900/50 p-4"
            wire:click.self="closeSalaryModal"
        >
            <div class="my-auto w-full max-w-2xl overflow-hidden rounded-xl bg-white shadow-xl">

                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                    <div>
                        <h2 class="font-semibold text-slate-900">Add Salary Structure</h2>
                        <p class="mt-1 text-xs text-slate-500">
                            Enter monthly salary amounts in Indian rupees.
                        </p>
                    </div>

                    <button
                        type="button"
                        wire:click="closeSalaryModal"
                        class="text-xl text-slate-400 hover:text-slate-600"
                    >
                        ×
                    </button>
                </div>

                <form wire:submit="saveSalaryStructure">
                    <div class="grid grid-cols-1 gap-5 p-6 sm:grid-cols-2">

                        @foreach ([
                            'basic_salary' => 'Basic Salary',
                            'hra' => 'HRA',
                            'transport_allowance' => 'Transport Allowance',
                            'other_allowances' => 'Other Allowances',
                            'other_deductions' => 'Other Deductions',
                        ] as $field => $label)
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                    {{ $label }} (₹) *
                                </label>

                                <input
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    wire:model.live="{{ $field }}"
                                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100"
                                >

                                @error($field)
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach

                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                Effective From *
                            </label>

                            <input
                                type="date"
                                wire:model="effective_from"
                                required
                                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100"
                            >

                            @error('effective_from')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label class="mb-1.5 block text-sm font-medium text-slate-700">
                                Notes
                            </label>

                            <textarea
                                wire:model="salary_notes"
                                rows="3"
                                placeholder="Optional reason for salary revision"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100"
                            ></textarea>

                            @error('salary_notes')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        @php
                            $previewGross =
                                (float) ($basic_salary ?: 0)
                                + (float) ($hra ?: 0)
                                + (float) ($transport_allowance ?: 0)
                                + (float) ($other_allowances ?: 0);

                            $previewNet = $previewGross - (float) ($other_deductions ?: 0);
                        @endphp

                        <div class="sm:col-span-2 grid grid-cols-1 gap-3 sm:grid-cols-2">
                            <div class="rounded-lg bg-slate-50 p-4">
                                <p class="text-xs text-slate-500">Gross Monthly Salary</p>
                                <p class="mt-1 text-lg font-bold text-slate-900">
                                    ₹{{ number_format($previewGross, 2) }}
                                </p>
                            </div>

                            <div class="rounded-lg bg-green-50 p-4">
                                <p class="text-xs text-green-700">Fixed Net Monthly Salary</p>
                                <p class="mt-1 text-lg font-bold text-green-800">
                                    ₹{{ number_format($previewNet, 2) }}
                                </p>
                            </div>
                        </div>

                        <div class="sm:col-span-2 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-xs text-amber-800">
                            Saving a new salary record closes the previous salary period.
                            Existing salary history cannot be edited through this form.
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 border-t border-slate-200 bg-slate-50 px-6 py-4">
                        <button
                            type="button"
                            wire:click="closeSalaryModal"
                            class="rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            wire:target="saveSalaryStructure"
                            class="rounded-lg bg-hitek-red px-5 py-2.5 text-sm font-semibold text-white hover:bg-hitek-red-hover disabled:cursor-not-allowed disabled:opacity-60"
                        >
                            <span wire:loading.remove wire:target="saveSalaryStructure">
                                Save Salary Structure
                            </span>
                            <span wire:loading wire:target="saveSalaryStructure">
                                Saving...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>