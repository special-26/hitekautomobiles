<?php

namespace App\Livewire\Shifts;

use App\Models\Shift;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Index extends Component
{
    public bool $showModal = false;
    public ?int $editingShiftId = null;
    public string $name = '';
    public string $start_time = '';
    public string $end_time = '';
    public bool $is_active = true;

    public function createShift(): void
    {
        abort_unless(auth()->user()->can('shifts.manage'), 403);

        $this->resetForm();
        $this->showModal = true;
    }

    public function editShift(int $id): void
    {
        abort_unless(auth()->user()->can('shifts.manage'), 403);

        $shift = Shift::findOrFail($id);
        $this->resetValidation();
        $this->editingShiftId = $shift->id;
        $this->name = $shift->name;
        $this->start_time = substr($shift->start_time, 0, 5);
        $this->end_time = substr($shift->end_time, 0, 5);
        $this->is_active = $shift->is_active;
        $this->showModal = true;
    }

    public function saveShift(): void
    {
        abort_unless(auth()->user()->can('shifts.manage'), 403);

        $validated = $this->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('shifts', 'name')->ignore($this->editingShiftId),
            ],
            'start_time' => [
                'required',
                'date_format:H:i',
            ],
            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
            ],
            'is_active' => [
                'required',
                'boolean',
            ],
        ]);

        $shiftData = [
            'name' => $validated['name'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'is_active' => $validated['is_active'],
        ];

        if ($this->editingShiftId) {
            Shift::findOrFail($this->editingShiftId)->update($shiftData);
            session()->flash('success', 'Shift updated successfully.');
        } else {
            $code = str($validated['name'])->slug('_')->toString();
            if (Shift::where('code', $code)->exists()) {
                $this->addError('name', 'This shift name generates an existing shift code.');
                return;
            }
            Shift::create([...$shiftData, 'code' => $code,]);
            session()->flash('success', 'Shift created successfully.');
        }
        $this->closeModal();
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->reset(['editingShiftId', 'name', 'start_time', 'end_time',]);
        $this->is_active = true;
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.shifts.index', [
            'shifts' => Shift::query()
                ->orderBy('start_time')
                ->get(),
        ])->layout('components.layouts.management', [
            'title' => 'Shift Management',
        ]);
    }
}
