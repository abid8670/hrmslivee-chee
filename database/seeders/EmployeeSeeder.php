<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employees;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        // Create Departments
        $it = Department::create(['name' => 'IT']);
        $hr = Department::create(['name' => 'Human Resources']);

        // Create Designations
        $softwareEngineer = Designation::create(['name' => 'Software Engineer']);
        $hrManager = Designation::create(['name' => 'HR Manager']);

        // Create a Manager (who is also an employee)
        $manager = Employees::create([
            'hr_code' => 'EMP-001',
            'machine_id' => '1001',
            'first_name' => 'Adnan',
            'last_name' => 'Sami',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'is_web_user' => true,
            'department_id' => $it->id,
            'designation_id' => $softwareEngineer->id,
            'join_date' => now(),
            'gender' => 'male',
        ]);

        // Create an Employee reporting to the manager
        Employees::create([
            'hr_code' => 'EMP-002',
            'machine_id' => '1002',
            'first_name' => 'Ayesha',
            'last_name' => 'Khan',
            'email' => 'employee@example.com',
            'password' => Hash::make('password'),
            'is_web_user' => true,
            'department_id' => $it->id,
            'designation_id' => $softwareEngineer->id,
            'manager_id' => $manager->id, // Assign manager
            'join_date' => now(),
            'gender' => 'female',
        ]);

        // Create an HR person
        Employees::create([
            'hr_code' => 'EMP-003',
            'machine_id' => '1003',
            'first_name' => 'Bilal',
            'last_name' => 'Ahmed',
            'email' => 'hr@example.com',
            'password' => Hash::make('password'),
            'is_web_user' => true,
            'department_id' => $hr->id,
            'designation_id' => $hrManager->id,
            'join_date' => now(),
            'gender' => 'male',
        ]);
    }
}
