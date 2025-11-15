<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            DepartmentSeeder::class,
            DesignationSeeder::class,
            EmployeeTitleSeeder::class,
            WorkLocationSeeder::class,
            EmployeeShiftSeeder::class,
            // EmployeeSeeder must be after the others it depends on.
            EmployeeSeeder::class, 
        ]);
    }
}
