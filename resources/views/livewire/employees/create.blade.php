<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">
                Add Employee
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Create an employee account and profile.
            </p>
        </div>

        <a
            href="{{ route('employees.index') }}"
            class="inline-flex items-center gap-2 rounded-lg border border-slate-300
                   bg-white px-4 py-2 text-sm font-medium text-slate-700
                   hover:bg-slate-50"
        >
            ← Back
        </a>
    </div>


    {{-- Validation Summary --}}
    @if ($errors->any())
        <div class="rounded-lg border border-red-200 bg-red-50 p-4">
            <div class="flex gap-3">
                <div class="text-red-600">
                    ⚠
                </div>

                <div>
                    <p class="font-medium text-red-800">
                        Please fix the following errors:
                    </p>

                    <ul class="mt-2 list-disc pl-5 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif


    <form wire:submit="save" class="space-y-6">

        {{-- ========================================================= --}}
        {{-- ACCOUNT --}}
        {{-- ========================================================= --}}

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="font-semibold text-slate-900">
                    Account Information
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Login credentials and system access.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2">

                {{-- Name --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Full Name <span class="text-red-600">*</span>
                    </label>

                    <input
                        type="text"
                        wire:model="name"
                        placeholder="Enter full name"
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5
                               text-sm text-slate-900 outline-none
                               focus:border-red-500 focus:ring-2 focus:ring-red-100"
                    >

                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Email --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Email <span class="text-red-600">*</span>
                    </label>

                    <input
                        type="email"
                        wire:model="email"
                        placeholder="employee@example.com"
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5
                               text-sm text-slate-900 outline-none
                               focus:border-red-500 focus:ring-2 focus:ring-red-100"
                    >

                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Password --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Password <span class="text-red-600">*</span>
                    </label>

                    <input
                        type="password"
                        wire:model="password"
                        placeholder="Minimum 8 characters"
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5
                               text-sm text-slate-900 outline-none
                               focus:border-red-500 focus:ring-2 focus:ring-red-100"
                    >

                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Role --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Role <span class="text-red-600">*</span>
                    </label>

                    <select
                        wire:model="role"
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5
                               text-sm text-slate-900 outline-none
                               focus:border-red-500 focus:ring-2 focus:ring-red-100"
                    >
                        <option value="">Select role</option>

                        @foreach ($roles as $item)
                            <option value="{{ $item->name }}">
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('role')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>


        {{-- ========================================================= --}}
        {{-- EMPLOYMENT --}}
        {{-- ========================================================= --}}

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="font-semibold text-slate-900">
                    Employment Information
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Basic employment details.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2 lg:grid-cols-5">

                {{-- Employee Code --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Employee Code <span class="text-red-600">*</span>
                    </label>

                    <input
                        type="text"
                        wire:model="employee_code"
                        placeholder="EMP-001"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                               outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100"
                    >

                    @error('employee_code')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Department --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Department <span class="text-red-600">*</span>
                    </label>

                    <select
                        wire:model="department_id"
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5
                               text-sm outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100"
                    >
                        <option value="">Select department</option>

                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('department_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                {{-- Designation --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Designation
                    </label>

                    <input
                        type="text"
                        wire:model="designation"
                        placeholder="e.g. Senior Technician"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                               outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100"
                    >

                    @error('designation')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Assigned Shift --}}
                <div>
                    <label for="shift_id" class="mb-1.5 block text-sm font-medium text-slate-700">
                        Assigned Shift <span class="text-red-600">*</span>
                    </label>

                    <select
                        id="shift_id"
                        wire:model="shift_id"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red"
                        required
                    >
                        <option value="">Select shift</option>

                        @foreach ($shifts as $shift)
                            <option value="{{ $shift->id }}">
                                {{ $shift->name }}
                                ({{ \Carbon\Carbon::parse($shift->start_time)->format('g:i A') }}
                                – {{ \Carbon\Carbon::parse($shift->end_time)->format('g:i A') }})
                            </option>
                        @endforeach
                    </select>

                    @error('shift_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Joining Date --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Joining Date
                    </label>

                    <input
                        type="date"
                        wire:model="joining_date"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                               outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100"
                    >

                    @error('joining_date')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </div>


        {{-- ========================================================= --}}
        {{-- PERSONAL --}}
        {{-- ========================================================= --}}

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="font-semibold text-slate-900">
                    Personal Information
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Personal and contact details.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2 lg:grid-cols-4">

                {{-- Phone --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Phone
                    </label>

                    <input
                        type="text"
                        wire:model="phone"
                        placeholder="9876543210"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                               outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100"
                    >
                </div>


                {{-- DOB --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Date of Birth
                    </label>

                    <input
                        type="date"
                        wire:model="date_of_birth"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                               outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100"
                    >
                </div>


                {{-- Gender --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Gender
                    </label>

                    <select
                        wire:model="gender"
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm
                               outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100"
                    >
                        <option value="">Select gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>


                {{-- City --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        City
                    </label>

                    <input
                        type="text"
                        wire:model="city"
                        placeholder="Chandigarh"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                               outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100"
                    >
                </div>


                {{-- State --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        State
                    </label>

                    <input
                        type="text"
                        wire:model="state"
                        placeholder="Punjab"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                               outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100"
                    >
                </div>


                {{-- Pincode --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Pincode
                    </label>

                    <input
                        type="text"
                        wire:model="pincode"
                        placeholder="160002"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                               outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100"
                    >
                </div>


                {{-- Address --}}
                <div class="md:col-span-2 lg:col-span-2">
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Address
                    </label>

                    <textarea
                        wire:model="address"
                        rows="3"
                        placeholder="Complete residential address"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                               outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100"
                    ></textarea>
                </div>

            </div>
        </div>


        {{-- ========================================================= --}}
        {{-- EMERGENCY --}}
        {{-- ========================================================= --}}

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">

            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="font-semibold text-slate-900">
                    Emergency Contact
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Contact person to reach in case of emergency.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2">

                {{-- Name --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Contact Name
                    </label>

                    <input
                        type="text"
                        wire:model="emergency_contact_name"
                        placeholder="Emergency contact name"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                               outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100"
                    >
                </div>


                {{-- Phone --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Contact Phone
                    </label>

                    <input
                        type="text"
                        wire:model="emergency_contact_phone"
                        placeholder="Emergency contact phone"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm
                               outline-none focus:border-red-500 focus:ring-2 focus:ring-red-100"
                    >
                </div>

            </div>
        </div>


        {{-- ========================================================= --}}
        {{-- ACTIONS --}}
        {{-- ========================================================= --}}

        <div class="flex items-center justify-end gap-3">

            <a
                href="{{ route('employees.index') }}"
                class="rounded-lg border border-slate-300 bg-white px-5 py-2.5
                       text-sm font-medium text-slate-700 hover:bg-slate-50"
            >
                Cancel
            </a>

            <button
                type="submit"
                wire:loading.attr="disabled"
                class="inline-flex items-center gap-2 rounded-lg bg-hitek-red px-5 py-2.5
                       text-sm font-semibold text-white
                       hover:bg-hitek-red-hover
                       disabled:cursor-not-allowed disabled:opacity-60"
            >
                <span wire:loading.remove wire:target="save">
                    Create Employee
                </span>

                <span wire:loading wire:target="save">
                    Creating...
                </span>
            </button>

        </div>

    </form>

</div>