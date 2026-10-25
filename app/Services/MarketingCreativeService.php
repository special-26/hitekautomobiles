<?php

namespace App\Services;

use App\Models\WorkshopBrandProfile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Alignment;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;
use Intervention\Image\ImageManager;
use RuntimeException;

class MarketingCreativeService
{
    public function generateServicePromotion(array $offer = []): string
    {
        $brand = WorkshopBrandProfile::query()->first();

        if (! $brand) {
            throw new RuntimeException(
                'Please save the Workshop Brand Profile first.'
            );
        }

        $manager = new ImageManager(new Driver());

        $template = $offer['template'] ?? 'car-service-promo';

        $allowedTemplates = [
            'car-service-promo',
            'detailing-offer',
            'festival-greeting',
            'seasonal-car-care',
            'special-offer',
            'vehicle-safety',
        ];

        if (! in_array($template, $allowedTemplates, true)) {
            $template = 'car-service-promo';
        }

        $primary = $brand->primary_color ?: '#dc2626';
        $secondary = $brand->secondary_color ?: '#334155';

        $title = strtoupper($offer['title'] ?? 'CAR SERVICE');
        $subtitle = $offer['subtitle'] ?? 'CARE THAT KEEPS YOU MOVING';
        $price = trim((string) ($offer['price'] ?? ''));
        $cta = $offer['cta'] ?? $brand->default_call_to_action;

        // Template-specific background colours.
        $background = match ($template) {
            'festival-greeting' => '#451a1a',
            'vehicle-safety' => '#f8fafc',
            'detailing-offer' => '#111827',
            'special-offer' => '#18181b',
            default => $secondary,
        };

        $image = $manager->createImage(1080, 1080)->fill($background);

        // Top branding strip.
        $this->rectangle($image, 0, 0, 1080, 18, $primary);

        // Give every template its own visual structure.
        switch ($template) {
            case 'detailing-offer':
                $this->rectangle($image, 0, 120, 1080, 410, '#202733');
                $this->rectangle($image, 0, 530, 1080, 12, $primary);
                $this->rectangle($image, 0, 550, 18, 390, $primary);
                break;

            case 'festival-greeting':
                $this->rectangle($image, 35, 150, 1010, 470, $primary);
                $this->rectangle($image, 55, 170, 970, 430, '#451a1a');
                $this->rectangle($image, 80, 195, 920, 8, '#fbbf24');
                $this->rectangle($image, 80, 570, 920, 8, '#fbbf24');
                break;

            case 'seasonal-car-care':
                $this->rectangle($image, 0, 130, 1080, 340, '#263747');
                $this->rectangle($image, 0, 470, 1080, 16, $primary);
                $this->rectangle($image, 55, 550, 12, 280, $primary);
                break;

            case 'special-offer':
                $this->rectangle($image, 35, 145, 1010, 430, $primary);
                $this->rectangle($image, 55, 165, 970, 390, '#18181b');
                $this->rectangle($image, 55, 165, 16, 390, $primary);
                break;

            case 'vehicle-safety':
                $this->rectangle($image, 0, 130, 1080, 350, '#e2e8f0');
                $this->rectangle($image, 0, 480, 1080, 15, $primary);
                $this->rectangle($image, 0, 520, 1080, 5, '#cbd5e1');
                break;

            default:
                $this->rectangle($image, 0, 130, 1080, 390, '#1f2937');
                $this->rectangle($image, 0, 505, 1080, 15, $primary);
                break;
        }

        // Insert the optional uploaded photo.
        // Each template gets its own photo placement.
        $photoPositions = match ($template) {
            'detailing-offer' => [0, 120, 1080, 410],
            'festival-greeting' => [90, 220, 900, 330],
            'seasonal-car-care' => [0, 130, 1080, 340],
            'special-offer' => [75, 185, 930, 350],
            'vehicle-safety' => [0, 130, 1080, 350],
            default => [0, 130, 1080, 390],
        };

        if (! empty($offer['car_photo_path'])) {
            $photoPath = Storage::disk('public')->path(
                $offer['car_photo_path']
            );

            if (File::exists($photoPath)) {
                [$x, $y, $width, $height] = $photoPositions;

                $photo = $manager->decodePath($photoPath);
                $photo->cover($width, $height);

                $image->insert($photo, $x, $y);
            }
        }

        // Logo placement remains consistent across templates.
        if ($brand->logo_path) {
            $logoPath = Storage::disk('public')->path($brand->logo_path);

            if (File::exists($logoPath)) {
                $logo = $manager->decodePath($logoPath);
                $logo->scaleDown(220, 120);

                $image->insert(
                    $logo,
                    50,
                    45,
                    Alignment::TOP_RIGHT
                );
            }
        }

        // Workshop name.
        $brandTextColor = $template === 'vehicle-safety'
            ? '#0f172a'
            : '#ffffff';

        $image->text(strtoupper($brand->name), 60, 85, function ($font) use ($brandTextColor) {
            $font->size(30);
            $font->color($brandTextColor);
            $font->wrap(620);
        });

        // Template-specific text positions and hierarchy.
        switch ($template) {
            case 'detailing-offer':
                $this->writeText($image, $title, 60, 615, 54, '#ffffff', 930);
                $this->writeText($image, $subtitle, 60, 675, 25, '#d1d5db', 930);

                if ($price !== '') {
                    $this->writeText($image, $price, 60, 770, 60, $primary, 930);
                }

                $this->writeText($image, $cta, 60, 865, 28, '#ffffff', 930);
                break;

            case 'festival-greeting':
                $this->writeText($image, $title, 85, 300, 58, '#ffffff', 910);
                $this->writeText($image, $subtitle, 85, 370, 27, '#fde68a', 910);

                if ($price !== '') {
                    $this->writeText($image, $price, 85, 455, 42, '#ffffff', 910);
                }

                $this->writeText($image, $cta, 85, 535, 25, '#fde68a', 910);
                break;

            case 'seasonal-car-care':
                $this->writeText($image, $title, 80, 590, 54, '#ffffff', 920);
                $this->writeText($image, $subtitle, 80, 650, 25, '#cbd5e1', 920);

                if ($price !== '') {
                    $this->writeText($image, $price, 80, 745, 48, $primary, 920);
                }

                $this->writeText($image, $cta, 80, 825, 27, '#ffffff', 920);
                break;

            case 'special-offer':
                $this->writeText($image, $title, 90, 265, 56, '#ffffff', 880);
                $this->writeText($image, $subtitle, 90, 325, 25, '#e5e7eb', 880);

                if ($price !== '') {
                    $this->writeText($image, $price, 90, 445, 66, '#ffffff', 880);
                }

                $this->writeText($image, $cta, 65, 665, 30, '#ffffff', 950);
                break;

            case 'vehicle-safety':
                $this->writeText($image, $title, 60, 575, 52, '#0f172a', 950);
                $this->writeText($image, $subtitle, 60, 650, 27, '#334155', 950);

                if ($price !== '') {
                    $this->writeText($image, $price, 60, 740, 36, $primary, 950);
                }

                $this->writeText($image, $cta, 60, 820, 26, '#0f172a', 950);
                break;

            default:
                $this->writeText($image, $title, 60, 245, 68, '#ffffff', 950);
                $this->writeText($image, $subtitle, 60, 315, 27, '#ffffff', 950);

                if ($price !== '') {
                    $this->writeText($image, $price, 60, 445, 60, '#ffffff', 950);
                }

                $this->writeText($image, $cta, 60, 690, 32, '#ffffff', 950);
                break;
        }

        // Contact details in a consistent footer.
        $this->rectangle($image, 0, 900, 1080, 180, '#0f172a');

        if ($brand->phone) {
            $this->writeText(
                $image,
                'Call: ' . $brand->phone,
                60,
                955,
                27,
                '#ffffff',
                950
            );
        }

        if ($brand->address) {
            $this->writeText(
                $image,
                $brand->address,
                60,
                1015,
                21,
                '#cbd5e1',
                950
            );
        }

        $directory = 'marketing-creatives';
        Storage::disk('public')->makeDirectory($directory);

        $filename = $template . '-' . now()->format('YmdHis') . '-' . uniqid() . '.png';
        $path = $directory . '/' . $filename;

        $encoded = $image->encodeUsingFormat(Format::PNG);

        Storage::disk('public')->put($path, (string) $encoded);

        return $path;
    }

    private function rectangle(
        $image,
        int $x,
        int $y,
        int $width,
        int $height,
        string $color
    ): void {
        $image->drawRectangle(function ($rectangle) use (
            $x,
            $y,
            $width,
            $height,
            $color
        ) {
            $rectangle->at($x, $y);
            $rectangle->size($width, $height);
            $rectangle->background($color);
        });
    }

    private function writeText(
        $image,
        string $text,
        int $x,
        int $y,
        int $size,
        string $color,
        int $wrap
    ): void {
        $image->text($text, $x, $y, function ($font) use (
            $size,
            $color,
            $wrap
        ) {
            $font->size($size);
            $font->color($color);
            $font->wrap($wrap);
        });
    }
}
