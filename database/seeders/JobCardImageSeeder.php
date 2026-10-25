<?php

namespace Database\Seeders;

use App\Models\JobCard;
use App\Models\JobCardImage;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobCardImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobCard = JobCard::query()->first();

        if (! $jobCard) {
            return;
        }

        $user = User::query()->first();

        $images = [
            [
                'file_name' => 'front-damage.jpg',
                'file_path' => 'job-cards/images/front-damage.jpg',
                'category' => 'Damage / Inspection',
            ],
            [
                'file_name' => 'left-side.jpg',
                'file_path' => 'job-cards/images/left-side.jpg',
                'category' => 'Before Service',
            ],
            [
                'file_name' => 'engine-bay.jpg',
                'file_path' => 'job-cards/images/engine-bay.jpg',
                'category' => 'Inspection',
            ],
            [
                'file_name' => 'service-complete.jpg',
                'file_path' => 'job-cards/images/service-complete.jpg',
                'category' => 'After Service',
            ],
        ];

        foreach ($images as $image) {
            JobCardImage::create([
                'job_card_id' => $jobCard->id,
                'file_name' => $image['file_name'],
                'file_path' => $image['file_path'],
                'category' => $image['category'],
                'uploaded_by' => $user?->id,
                'remarks' => null,
            ]);
        }
    }
}
