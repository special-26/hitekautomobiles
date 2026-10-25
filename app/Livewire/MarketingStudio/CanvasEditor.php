<?php

namespace App\Livewire\MarketingStudio;

use App\Models\MarketingTemplate;
use App\Models\WorkshopBrandProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class CanvasEditor extends Component
{
    public ?MarketingTemplate $template = null;
    public ?WorkshopBrandProfile $profile = null;

    public function mount(Request $request): void
    {
        Gate::authorize('marketing-studio.view');

        $this->profile = WorkshopBrandProfile::query()->first();

        $slug = $request->query('template');

        if ($slug) {
            $this->template = MarketingTemplate::query()
                ->where('is_active', true)
                ->where('slug', $slug)
                ->firstOrFail();
        }
    }

    public function render()
    {
        return view('livewire.marketing-studio.canvas-editor')
            ->layout('components.layouts.management');
    }
}
