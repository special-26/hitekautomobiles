<?php

namespace App\Livewire\MarketingStudio;

use App\Models\MarketingTemplate;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class Index extends Component
{
    public string $search = '';

    public string $category = 'all';

    public string $format = 'all';

    public function mount(): void
    {
        Gate::authorize('marketing-studio.view');
    }

    public function updatedSearch(): void
    {
        // Search updates reactively as the user types.
    }

    public function selectCategory(string $category): void
    {
        $allowedCategories = [
            'all',
            'festivals',
            'services',
            'seasonal',
            'offers',
            'awareness',
        ];

        if (in_array($category, $allowedCategories, true)) {
            $this->category = $category;
        }
    }

    public function selectFormat(string $format): void
    {
        $allowedFormats = [
            'all',
            'square',
            'portrait',
            'story',
        ];

        if (in_array($format, $allowedFormats, true)) {
            $this->format = $format;
        }
    }

    public function render()
    {
        $templates = MarketingTemplate::query()
            ->where('is_active', true)
            ->when(trim($this->search) !== '', function ($query) {
                $search = trim($this->search);

                $query->where(function ($query) use ($search) {
                    $query->where('name', 'ilike', "%{$search}%")
                        ->orWhere('description', 'ilike', "%{$search}%")
                        ->orWhere('occasion', 'ilike', "%{$search}%");
                });
            })
            ->when($this->category !== 'all', function ($query) {
                $query->where('category', $this->category);
            })
            ->when($this->format !== 'all', function ($query) {
                $query->where('format', $this->format);
            })
            ->orderBy('sort_order')
            ->get();

        return view('livewire.marketing-studio.index', [
            'templates' => $templates,
        ])->layout('components.layouts.management');
    }
}
