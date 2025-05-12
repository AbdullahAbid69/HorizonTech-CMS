<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\StudentQualification;
use App\Models\StudentUserDetials;
use Illuminate\Database\Seeder;
// use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ProgramSeeder::class,
            CourseSeeder::class,
            DepartmentSeeder::class,
            InstructorSeeder::class,
        ]);
    }
}