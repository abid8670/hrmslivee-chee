<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WorkLocation;

class WorkLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WorkLocation::create(['name' => 'Office']);
        WorkLocation::create(['name' => 'Factory']);
        WorkLocation::create(['name' => 'Remote']);
    }
}
