<?php

namespace App\Livewire\Employees;

use App\Models\Employee;
use App\Models\EmployeeDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Show extends Component
{
    use WithFileUploads;

    public Employee $employee;

    public bool $showUploadModal = false;
    public string $document_type = '';
    public string $document_number = '';
    public $document_file;
    public string $issued_at = '';
    public string $expires_at = '';
    public string $notes = '';

    // Bank Account
    public bool $showBankModal = false;
    public ?int $editingBankAccountId = null;
    public string $account_holder_name = '';
    public string $bank_name = '';
    public string $account_number = '';
    public string $ifsc_code = '';
    public string $branch_name = '';
    public bool $is_primary = true;

    // Salary Structure
    public bool $showSalaryModal = false;
    public string $basic_salary = '0';
    public string $hra = '0';
    public string $transport_allowance = '0';
    public string $other_allowances = '0';
    public string $other_deductions = '0';
    public string $effective_from = '';
    public string $salary_notes = '';

    public function mount(Employee $employee): void
    {
        $this->employee = $employee->load([
            'user.roles',
            'department',
            'documents' => fn($query) => $query->latest(),
            'bankAccounts',
            'salaryHistories',
        ]);
    }

    public function openUploadModal(): void
    {
        $this->resetValidation();

        $this->reset([
            'document_type',
            'document_number',
            'document_file',
            'issued_at',
            'expires_at',
            'notes',
        ]);

        $this->showUploadModal = true;
    }

    public function closeUploadModal(): void
    {
        $this->showUploadModal = false;

        $this->resetValidation();

        $this->reset([
            'document_type',
            'document_number',
            'document_file',
            'issued_at',
            'expires_at',
            'notes',
        ]);
    }

    public function uploadDocument(): void
    {
        $validated = $this->validate([
            'document_type' => [
                'required',
                'string',
                'max:100',
            ],

            'document_number' => [
                'nullable',
                'string',
                'max:100',
            ],

            'document_file' => [
                'required',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:10240',
            ],

            'issued_at' => [
                'nullable',
                'date',
            ],

            'expires_at' => [
                'nullable',
                'date',
                'after_or_equal:issued_at',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        $file = $this->document_file;

        $path = $file->store(
            "employees/{$this->employee->id}/documents",
            'local'
        );

        EmployeeDocument::create([
            'employee_id' => $this->employee->id,
            'document_type' => $validated['document_type'],
            'document_number' => $validated['document_number'] ?? null,
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'file_size' => $file->getSize(),
            'issued_at' => $validated['issued_at'] ?? null,
            'expires_at' => $validated['expires_at'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'uploaded_by' => Auth::id(),
        ]);

        $this->employee->load([
            'documents' => fn($query) => $query->latest(),
        ]);

        $this->closeUploadModal();

        session()->flash(
            'success',
            'Employee document uploaded successfully.'
        );
    }

    public function deleteDocument(int $documentId): void
    {
        $document = EmployeeDocument::query()
            ->where('employee_id', $this->employee->id)
            ->findOrFail($documentId);

        Storage::disk('local')->delete($document->file_path);

        $document->delete();

        $this->employee->load([
            'documents' => fn($query) => $query->latest(),
        ]);

        session()->flash(
            'success',
            'Document deleted successfully.'
        );
    }

    public function openSalaryModal(): void
    {
        abort_unless(
            auth()->user()->can('employees.salary.manage'),
            403
        );

        $this->resetValidation();

        $this->reset([
            'basic_salary',
            'hra',
            'transport_allowance',
            'other_allowances',
            'other_deductions',
            'salary_notes',
        ]);

        $this->basic_salary = '0';
        $this->hra = '0';
        $this->transport_allowance = '0';
        $this->other_allowances = '0';
        $this->other_deductions = '0';
        $this->effective_from = now()->toDateString();

        $this->showSalaryModal = true;
    }

    public function closeSalaryModal(): void
    {
        $this->showSalaryModal = false;

        $this->resetValidation();

        $this->reset([
            'basic_salary',
            'hra',
            'transport_allowance',
            'other_allowances',
            'other_deductions',
            'effective_from',
            'salary_notes',
        ]);
    }

    public function saveSalaryStructure(): void
    {
        abort_unless(
            auth()->user()->can('employees.salary.manage'),
            403
        );

        $validated = $this->validate([
            'basic_salary' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
            'hra' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
            'transport_allowance' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
            'other_allowances' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
            'other_deductions' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
            'effective_from' => ['required', 'date'],
            'salary_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use ($validated) {
            // Lock this employee's salary history while adding a new record.
            $latestSalary = $this->employee
                ->salaryHistories()
                ->lockForUpdate()
                ->first();

            $effectiveFrom = \Illuminate\Support\Carbon::parse(
                $validated['effective_from']
            )->startOfDay();

            // Salary records must be added in chronological order.
            if (
                $latestSalary &&
                $effectiveFrom->lessThanOrEqualTo(
                    $latestSalary->effective_from->startOfDay()
                )
            ) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'effective_from' => 'The effective date must be later than the latest salary record.',
                ]);
            }

            // End the previous salary the day before the new salary starts.
            if ($latestSalary) {
                $latestSalary->update([
                    'effective_to' => $effectiveFrom->copy()
                        ->subDay()
                        ->toDateString(),
                ]);
            }

            $this->employee->salaryHistories()->create([
                'basic_salary' => $validated['basic_salary'],
                'hra' => $validated['hra'],
                'transport_allowance' => $validated['transport_allowance'],
                'other_allowances' => $validated['other_allowances'],
                'other_deductions' => $validated['other_deductions'],
                'effective_from' => $effectiveFrom->toDateString(),
                'effective_to' => null,
                'notes' => $validated['salary_notes'] ?? null,
                'created_by' => Auth::id(),
            ]);
        });

        $this->employee->load('salaryHistories');

        $this->closeSalaryModal();

        session()->flash(
            'success',
            'Salary structure saved successfully.'
        );
    }

    public function toggleStatus(): void
    {
        abort_unless(
            auth()->user()->can('employees.status.update'),
            403
        );

        $this->employee->refresh();

        $newStatus = $this->employee->status === 'active'
            ? 'inactive'
            : 'active';

        \Illuminate\Support\Facades\DB::transaction(function () use ($newStatus) {
            $this->employee->update([
                'status' => $newStatus,
            ]);

            $this->employee->user()->update([
                'is_active' => $newStatus === 'active',
            ]);
        });

        $this->employee->refresh();

        session()->flash(
            'success',
            $newStatus === 'active'
                ? 'Employee activated successfully.'
                : 'Employee deactivated successfully.'
        );
    }

    public function openBankModal(?int $bankAccountId = null): void
    {
        abort_unless(
            auth()->user()->can('employees.bank-details.manage'),
            403
        );

        $this->resetValidation();

        $this->reset([
            'editingBankAccountId',
            'account_holder_name',
            'bank_name',
            'account_number',
            'ifsc_code',
            'branch_name',
        ]);

        $this->is_primary = true;

        if ($bankAccountId) {
            $account = $this->employee->bankAccounts()
                ->findOrFail($bankAccountId);

            $this->editingBankAccountId = $account->id;
            $this->account_holder_name = $account->account_holder_name;
            $this->bank_name = $account->bank_name;
            $this->account_number = $account->account_number;
            $this->ifsc_code = $account->ifsc_code;
            $this->branch_name = $account->branch_name ?? '';
            $this->is_primary = $account->is_primary;
        }

        $this->showBankModal = true;
    }

    public function closeBankModal(): void
    {
        $this->showBankModal = false;
        $this->resetValidation();

        $this->reset([
            'editingBankAccountId',
            'account_holder_name',
            'bank_name',
            'account_number',
            'ifsc_code',
            'branch_name',
        ]);

        $this->is_primary = true;
    }

    public function saveBankAccount(): void
    {
        abort_unless(
            auth()->user()->can('employees.bank-details.manage'),
            403
        );

        $validated = $this->validate([
            'account_holder_name' => ['required', 'string', 'max:255'],
            'bank_name' => ['required', 'string', 'max:255'],
            'account_number' => ['required', 'string', 'max:50'],
            'ifsc_code' => [
                'required',
                'string',
                'regex:/^[A-Z]{4}0[A-Z0-9]{6}$/i',
            ],
            'branch_name' => ['nullable', 'string', 'max:255'],
            'is_primary' => ['required', 'boolean'],
        ]);

        DB::transaction(function () use ($validated) {
            if ($validated['is_primary']) {
                $this->employee->bankAccounts()
                    ->update(['is_primary' => false]);
            }

            if ($this->editingBankAccountId) {
                $account = $this->employee->bankAccounts()
                    ->findOrFail($this->editingBankAccountId);

                $account->update($validated);
            } else {
                $this->employee->bankAccounts()->create($validated);
            }
        });

        $this->employee->load('bankAccounts');

        $this->closeBankModal();

        session()->flash('success', 'Bank details saved successfully.');
    }

    public function deleteBankAccount(int $bankAccountId): void
    {
        abort_unless(
            auth()->user()->can('employees.bank-details.manage'),
            403
        );

        $account = $this->employee->bankAccounts()
            ->findOrFail($bankAccountId);

        $account->delete();

        $this->employee->load('bankAccounts');

        session()->flash('success', 'Bank account deleted successfully.');
    }

    public function render()
    {
        return view('livewire.employees.show')
            ->layout('components.layouts.management', [
                'title' => $this->employee->user->name,
            ]);;
    }
}
