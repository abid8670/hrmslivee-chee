<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmployeeShift;

class EmployeeShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmployeeShift::create([
            'name' => 'Morning Shift',
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
            'grace_period' => 15,
            'is_active' => true,
            'color' => '#3498db',
            'description' => 'Standard morning shift for all employees.',
        ]);

        EmployeeShift::create([
            'name' => 'Night Shift',
            'start_time' => '17:00:00',
            'end_time' => '01:00:00',
            'grace_period' => 10,
            'is_active' => true,
            'color' => '#34495e',
            'description' => 'Standard night shift for all employees.',
        ]);
    }
}
