<?php

namespace App\Livewire\Payroll;

use App\Models\PayrollSetting;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Settings extends Component
{
    public array $weekly_off_days = [0];

    public string $proration_method = 'actual_working_days';

    public string $half_day_deduction_fraction = '0.50';

    public bool $deduct_absent_days = true;

    public bool $deduct_half_days = true;

    public bool $late_deduction_enabled = false;

    public function mount(): void
    {
        Gate::authorize('payroll.settings.manage');

        $settings = PayrollSetting::current();

        $this->weekly_off_days = $settings->weekly_off_days ?? [0];
        $this->proration_method = $settings->proration_method;
        $this->half_day_deduction_fraction =
            (string) $settings->half_day_deduction_fraction;
        $this->deduct_absent_days = $settings->deduct_absent_days;
        $this->deduct_half_days = $settings->deduct_half_days;
        $this->late_deduction_enabled = $settings->late_deduction_enabled;
    }

    protected function rules(): array
    {
        return [
            'weekly_off_days' => ['required', 'array', 'min:1'],
            'weekly_off_days.*' => [
                'required',
                'integer',
                Rule::in([0, 1, 2, 3, 4, 5, 6]),
            ],
            'proration_method' => [
                'required',
                Rule::in(['actual_working_days']),
            ],
            'half_day_deduction_fraction' => [
                'required',
                'numeric',
                'min:0',
                'max:1',
            ],
            'deduct_absent_days' => ['required', 'boolean'],
            'deduct_half_days' => ['required', 'boolean'],
            'late_deduction_enabled' => ['required', 'boolean'],
        ];
    }

    public function save(): void
    {
        Gate::authorize('payroll.settings.manage');

        $validated = $this->validate();

        $validated['weekly_off_days'] = array_values(
            array_unique(array_map(
                'intval',
                $validated['weekly_off_days']
            ))
        );

        sort($validated['weekly_off_days']);

        PayrollSetting::current()->update($validated);

        session()->flash('success', 'Payroll settings saved successfully.');
    }

    public function render()
    {
        return view('livewire.payroll.settings')
            ->layout('components.layouts.management');
    }
}
