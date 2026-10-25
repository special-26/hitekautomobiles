
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Edit Employee</h1>
            <p class="mt-1 text-sm text-slate-500">
                Update {{ $employee->user->name }}'s account and employment details.
            </p>
        </div>

        <a href="{{ route('employees.show', $employee) }}"
           class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
            Cancel
        </a>
    </div>

    @if (session('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 p-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            <p class="font-semibold">Please correct the following errors:</p>
            <ul class="mt-2 list-disc space-y-1 pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form wire:submit="save" class="space-y-6">

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="font-semibold text-slate-900">Account Information</h2>
                <p class="mt-1 text-xs text-slate-500">Login identity and system role.</p>
            </div>

            <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Full Name *</label>
                    <input type="text" wire:model="name"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
                    @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Email *</label>
                    <input type="email" wire:model="email"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
                    @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Role *</label>
                    <select wire:model="role"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
                        <option value="">Select role</option>
                        @foreach ($roles as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error('role') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    <p class="mt-1 text-xs text-slate-500">Changing the role changes this employee's permissions.</p>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Employee Code *</label>
                    <input type="text" wire:model="employee_code"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
                    @error('employee_code') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="font-semibold text-slate-900">Employment Information</h2>
            </div>

            <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2 lg:grid-cols-4">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Department *</label>
                    <select wire:model="department_id"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
                        <option value="">Select department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                    @error('department_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Designation</label>
                    <input type="text" wire:model="designation"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
                    @error('designation') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Joining Date</label>
                    <input type="date" wire:model="joining_date"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
                    @error('joining_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Phone</label>
                    <input type="text" wire:model="phone"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
                    @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="shift_id" class="mb-1.5 block text-sm font-medium text-slate-700">
                        Assigned Shift <span class="text-red-600">*</span>
                    </label>

                    <select
                        id="shift_id"
                        wire:model="shift_id"
                        required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-hitek-red focus:outline-none focus:ring-1 focus:ring-hitek-red"
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

            </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="font-semibold text-slate-900">Personal Information</h2>
            </div>

            <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2 lg:grid-cols-4">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Date of Birth</label>
                    <input type="date" wire:model="date_of_birth"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
                    @error('date_of_birth') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Gender</label>
                    <select wire:model="gender"
                            class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
                        <option value="">Select gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                    @error('gender') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">City</label>
                    <input type="text" wire:model="city"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
                    @error('city') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">State</label>
                    <input type="text" wire:model="state"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
                    @error('state') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Pincode</label>
                    <input type="text" wire:model="pincode"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
                    @error('pincode') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2 lg:col-span-3">
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Address</label>
                    <textarea wire:model="address" rows="2"
                              class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100"></textarea>
                    @error('address') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
            <div class="border-b border-slate-200 px-6 py-4">
                <h2 class="font-semibold text-slate-900">Emergency Contact</h2>
            </div>

            <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Contact Name</label>
                    <input type="text" wire:model="emergency_contact_name"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
                    @error('emergency_contact_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Contact Phone</label>
                    <input type="text" wire:model="emergency_contact_phone"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-red-500 focus:outline-none focus:ring-2 focus:ring-red-100">
                    @error('emergency_contact_phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('employees.show', $employee) }}"
               class="rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
                Cancel
            </a>

            <button type="submit" wire:loading.attr="disabled"
                    class="rounded-lg bg-hitek-red px-5 py-2.5 text-sm font-semibold text-white hover:bg-hitek-red-hover disabled:opacity-60">
                <span wire:loading.remove wire:target="save">Save Changes</span>
                <span wire:loading wire:target="save">Saving...</span>
            </button>
        </div>

    </form>
</div>