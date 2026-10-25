<?php

namespace App\Livewire\MarketingStudio;

use App\Models\WorkshopBrandProfile;
use App\Services\MarketingCreativeService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\Component;

class CreativeEditor extends Component
{
    use WithFileUploads;

    public string $template = 'car-service-promo';

    public string $title = 'CAR SERVICE';
    public string $subtitle = 'CARE THAT KEEPS YOU MOVING';
    public string $price = '';
    public string $cta = '';

    public $carPhoto = null;

    public ?string $generatedPath = null;

    public function mount(): void
    {
        Gate::authorize('marketing-studio.view');

        $templates = $this->availableTemplates();

        // Read the template selected from the Marketing Studio gallery.
        $requestedTemplate = request()->query('template', 'car-service-promo');

        $this->template = is_string($requestedTemplate)
            && isset($templates[$requestedTemplate])
            ? $requestedTemplate
            : 'car-service-promo';

        // Apply the selected template's default content.
        $this->applyTemplateDefaults();

        $brand = WorkshopBrandProfile::query()->first();

        if (! $brand) {
            session()->flash(
                'error',
                'Please configure your Workshop Brand Profile first.'
            );

            return;
        }

        $this->cta = $brand->default_call_to_action ?? 'Book your service today';
    }

    public function updatedTemplate(): void
    {
        $templates = $this->availableTemplates();

        if (! isset($templates[$this->template])) {
            $this->template = 'car-service-promo';
        }

        $this->applyTemplateDefaults();
        $this->generatedPath = null;
        $this->resetValidation();
    }

    private function availableTemplates(): array
    {
        return [
            'car-service-promo' => [
                'label' => 'Car Service Promotion',
                'title' => 'CAR SERVICE',
                'subtitle' => 'CARE THAT KEEPS YOU MOVING',
                'price' => '',
            ],
            'detailing-offer' => [
                'label' => 'Ceramic Coating / PPF',
                'title' => 'PREMIUM CAR CARE',
                'subtitle' => 'CERAMIC COATING & PAINT PROTECTION',
                'price' => '',
            ],
            'festival-greeting' => [
                'label' => 'Festival Greeting',
                'title' => 'FESTIVE GREETINGS',
                'subtitle' => 'WISHING YOU JOY AND HAPPINESS',
                'price' => '',
            ],
            'seasonal-car-care' => [
                'label' => 'Seasonal Car Care',
                'title' => 'SEASONAL CAR CARE',
                'subtitle' => 'PREPARE YOUR CAR FOR THE SEASON',
                'price' => '',
            ],
            'special-offer' => [
                'label' => 'Special Discount Offer',
                'title' => 'SPECIAL OFFER',
                'subtitle' => 'GREAT VALUE FOR YOUR CAR',
                'price' => '',
            ],
            'vehicle-safety' => [
                'label' => 'Vehicle Safety Awareness',
                'title' => 'DRIVE SAFELY',
                'subtitle' => 'REGULAR CHECKS HELP KEEP YOU SAFE',
                'price' => '',
            ],
        ];
    }

    private function applyTemplateDefaults(): void
    {
        $template = $this->availableTemplates()[$this->template]
            ?? $this->availableTemplates()['car-service-promo'];

        $this->title = $template['title'];
        $this->subtitle = $template['subtitle'];
        $this->price = $template['price'];
    }

    public function generate(): void
    {
        Gate::authorize('marketing-studio.view');

        $this->validate([
            'template' => [
                'required',
                'string',
                'in:car-service-promo,detailing-offer,festival-greeting,seasonal-car-care,special-offer,vehicle-safety',
            ],
            'title' => ['required', 'string', 'max:50'],
            'subtitle' => ['required', 'string', 'max:100'],
            'price' => ['nullable', 'string', 'max:40'],
            'cta' => ['required', 'string', 'max:100'],
            'carPhoto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        if (! WorkshopBrandProfile::query()->exists()) {
            $this->addError(
                'title',
                'Please configure your Brand Profile first.'
            );

            return;
        }

        $carPhotoPath = null;

        if ($this->carPhoto) {
            $carPhotoPath = $this->carPhoto->store(
                'marketing-uploads',
                'public'
            );
        }

        // Keep using the working generator for this first step.
        $this->generatedPath = app(MarketingCreativeService::class)
            ->generateServicePromotion([
                'template' => $this->template,
                'title' => $this->title,
                'subtitle' => $this->subtitle,
                'price' => $this->price,
                'cta' => $this->cta,
                'car_photo_path' => $carPhotoPath,
            ]);

        $this->carPhoto = null;

        session()->flash('success', 'Your creative has been generated.');
    }

    public function download()
    {
        Gate::authorize('marketing-studio.view');

        if (
            ! $this->generatedPath ||
            ! Storage::disk('public')->exists($this->generatedPath)
        ) {
            $this->addError(
                'title',
                'Generate the creative again before downloading.'
            );

            return;
        }

        return Storage::disk('public')->download(
            $this->generatedPath,
            'hitek-' . $this->template . '.png'
        );
    }

    public function render()
    {
        return view('livewire.marketing-studio.creative-editor', [
            'templates' => $this->availableTemplates(),
        ])->layout('components.layouts.management');
    }
}
