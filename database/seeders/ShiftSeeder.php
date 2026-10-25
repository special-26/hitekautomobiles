<?php

namespace Database\Seeders;

use App\Models\Shift;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shifts = [
            [
                'name' => 'General',
                'code' => 'general',
                'start_time' => '09:00:00',
                'end_time' => '18:00:00',
            ],
            [
                'name' => 'Team A',
                'code' => 'team_a',
                'start_time' => '06:00:00',
                'end_time' => '14:00:00',
            ],
            [
                'name' => 'Team B',
                'code' => 'team_b',
                'start_time' => '14:00:00',
                'end_time' => '22:00:00',
            ],
        ];

        foreach ($shifts as $shift) {
            Shift::updateOrCreate(
                ['code' => $shift['code']],
                [...$shift, 'is_active' => true]
            );
        }
    }
}
