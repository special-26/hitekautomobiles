<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            'Mechanical',
            'Electrical',
            'AC & HVAC',
            'Denting & Body',
            'Painting',
            'Detailing & Car Care',
            'Wheel & Tyre',
        ];

        foreach ($departments as $name) {
            Department::updateOrCreate(
                ['name' => $name],
                ['is_active' => true]
            );
        }
    }
}
