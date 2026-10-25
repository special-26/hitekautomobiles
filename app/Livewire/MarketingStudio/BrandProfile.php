<?php

namespace App\Livewire\MarketingStudio;

use App\Models\WorkshopBrandProfile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class BrandProfile extends Component
{
    use WithFileUploads;

    public ?WorkshopBrandProfile $profile = null;

    public string $name = '';
    public string $phone = '';
    public string $email = '';
    public string $address = '';
    public string $website = '';

    public string $primary_color = '#dc2626';
    public string $secondary_color = '#334155';

    public string $instagram_handle = '';
    public string $facebook_handle = '';
    public string $default_call_to_action = 'Book your service today';

    public $logo;

    public function mount(): void
    {
        Gate::authorize('marketing-studio.view');

        $this->profile = WorkshopBrandProfile::query()->first();

        if ($this->profile) {
            $this->name = $this->profile->name;
            $this->phone = $this->profile->phone ?? '';
            $this->email = $this->profile->email ?? '';
            $this->address = $this->profile->address ?? '';
            $this->website = $this->profile->website ?? '';

            $this->primary_color = $this->profile->primary_color;
            $this->secondary_color = $this->profile->secondary_color;

            $this->instagram_handle = $this->profile->instagram_handle ?? '';
            $this->facebook_handle = $this->profile->facebook_handle ?? '';
            $this->default_call_to_action = $this->profile->default_call_to_action;
        }
    }

    public function save(): void
    {
        Gate::authorize('marketing-studio.view');

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:2000'],
            'website' => ['nullable', 'url', 'max:255'],

            'primary_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'secondary_color' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],

            'instagram_handle' => ['nullable', 'string', 'max:255'],
            'facebook_handle' => ['nullable', 'string', 'max:255'],
            'default_call_to_action' => ['required', 'string', 'max:255'],

            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        $profile = WorkshopBrandProfile::query()->first();

        $data = collect($validated)->except('logo')->all();

        if ($this->logo) {
            $data['logo_path'] = $this->logo->store(
                'workshop-brand',
                'public'
            );
        }

        if ($profile) {
            $profile->update($data);
        } else {
            $profile = WorkshopBrandProfile::create($data);
        }

        if ($this->logo && $profile->wasChanged('logo_path')) {
            // Remove the previous logo only after the new one has been saved.
            $oldLogo = $profile->getOriginal('logo_path');

            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }
        }

        $this->profile = $profile->fresh();
        $this->logo = null;

        session()->flash('success', 'Workshop brand profile saved successfully.');
    }

    public function render()
    {
        return view('livewire.marketing-studio.brand-profile')
            ->layout('components.layouts.management');
    }
}
