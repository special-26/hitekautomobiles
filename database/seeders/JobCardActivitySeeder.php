<?php

namespace Database\Seeders;

use App\Models\JobCard;
use App\Models\JobCardActivity;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobCardActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobCard = JobCard::query()
            ->with(['customer', 'vehicle'])
            ->latest('id')
            ->first();

        if (! $jobCard) {
            $this->command->warn('No job card found.');
            return;
        }

        $user = User::query()->first();

        if (! $user) {
            $this->command->warn('No user found.');
            return;
        }

        JobCardActivity::where('job_card_id', $jobCard->id)->delete();

        $activities = [
            [
                'type' => 'Job Card',
                'action' => 'Job Card Created',
                'description' => 'Job card was created for '
                    . $jobCard->vehicle->make . ' '
                    . $jobCard->vehicle->model . '.',
                'created_by' => $user->id,
                'created_at' => now()->subDays(3)->setTime(9, 15),
            ],
            [
                'type' => 'Customer',
                'action' => 'Customer & Vehicle Added',
                'description' => 'Customer and vehicle information was added to the job card.',
                'created_by' => $user->id,
                'created_at' => now()->subDays(3)->setTime(9, 18),
            ],
            [
                'type' => 'Task',
                'action' => 'Task Added',
                'description' => 'Periodic Service task was added to the job card.',
                'created_by' => $user->id,
                'created_at' => now()->subDays(3)->setTime(9, 25),
            ],
            [
                'type' => 'Assignment',
                'action' => 'Mechanic Assigned',
                'description' => 'Mechanic was assigned to the service task.',
                'created_by' => $user->id,
                'created_at' => now()->subDays(3)->setTime(10, 0),
            ],
            [
                'type' => 'Parts',
                'action' => 'Part Requested',
                'description' => 'A part was requested for the service task.',
                'created_by' => $user->id,
                'created_at' => now()->subDays(3)->setTime(10, 5),
            ],
            [
                'type' => 'Parts',
                'action' => 'Part Issued',
                'description' => 'The requested part was issued from the store.',
                'created_by' => $user->id,
                'created_at' => now()->subDays(3)->setTime(10, 20),
            ],
            [
                'type' => 'Billing',
                'action' => 'Estimate Created',
                'description' => 'An estimate was created for the job card.',
                'created_by' => $user->id,
                'created_at' => now()->subDays(3)->setTime(12, 10),
            ],
            [
                'type' => 'Payment',
                'action' => 'Payment Received',
                'description' => 'Advance payment was received from the customer.',
                'created_by' => $user->id,
                'created_at' => now()->subDays(3)->setTime(12, 45),
            ],
            [
                'type' => 'Status',
                'action' => 'Job Card Status Updated',
                'description' => 'Job card status was changed from Received to Under Service.',
                'created_by' => $user->id,
                'created_at' => now()->subDays(3)->setTime(13, 5),
                'metadata' => [
                    'old_status' => 'Received',
                    'new_status' => 'Under Service',
                ],
            ],
            [
                'type' => 'Task',
                'action' => 'Task Completed',
                'description' => 'A service task was marked as completed.',
                'created_by' => $user->id,
                'created_at' => now()->subDay()->setTime(9, 52),
            ],
            [
                'type' => 'Billing',
                'action' => 'Final Invoice Created',
                'description' => 'Final invoice was generated for the job card.',
                'created_by' => $user->id,
                'created_at' => now()->subDay()->setTime(16, 20),
            ],
            [
                'type' => 'Payment',
                'action' => 'Payment Received',
                'description' => 'Payment was received from the customer.',
                'created_by' => $user->id,
                'created_at' => now()->subDay()->setTime(16, 35),
            ],
            [
                'type' => 'Status',
                'action' => 'Vehicle Marked Ready',
                'description' => 'Vehicle was marked ready for customer delivery.',
                'created_by' => $user->id,
                'created_at' => now()->subDay()->setTime(16, 45),
            ],
        ];

        foreach ($activities as $activity) {
            JobCardActivity::create([
                'job_card_id' => $jobCard->id,
                'type' => $activity['type'],
                'action' => $activity['action'],
                'description' => $activity['description'],
                'created_by' => $activity['created_by'],
                'metadata' => $activity['metadata'] ?? null,
                'created_at' => $activity['created_at'],
                'updated_at' => $activity['created_at'],
            ]);
        }

        $this->command->info(
            'Demo history activities created for ' . $jobCard->job_card_number
        );
    }
}
