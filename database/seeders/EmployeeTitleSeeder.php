<?php

namespace Database\Seeders;

use App\Models\EmployeeTitle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmployeeTitle::create([
            'name' => 'Software Engineer',
            'is_active' => true,
            'description' => 'Responsible for developing and maintaining software applications.',
        ]);

        EmployeeTitle::create([
            'name' => 'Project Manager',
            'is_active' => true,
            'description' => 'Responsible for planning, executing, and closing projects.',
        ]);

        EmployeeTitle::create([
            'name' => 'Human Resource Manager',
            'is_active' => true,
            'description' => 'Responsible for managing employee relations and HR policies.',
        ]);
    }
}
