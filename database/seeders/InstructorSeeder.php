<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Muzammil Nawaz',
                'email' => 'muzammilnawaz124@gmail.com',
                'password' => bcrypt('muzammil124'), // You can use any password here
                'phone' => '03055148558',
                'status' => 'active',
                "role" => "instructor",
            ],
            [
                'name' => 'Tanveer Hussain',
                'email' => 'tanveergazar323@gmail.com',
                'password' => bcrypt('tanveer323'),
                'phone' => '03481219215',
                'status' => 'active',
                "role" => "instructor",
            ]
        ];

        // Insert users into the users table
        foreach ($users as $userData) {
            $user = User::create($userData);
            // You can assign roles here if you're using a package like spatie/laravel-permission.
            // For now, we just consider them as instructors in the instructors table.
        }

        // Fetch departments
        $departments = Department::all();

        // Create instructors and assign them to a department
        $instructors = [
            [
                'user_id' => User::where('email', 'muzammilnawaz124@gmail.com')->first()->id,
                'department_id' => $departments->first()->id, // Example department assignment
                'designation' => 'Senior Instructor',
                'final_qualification' => 'PhD in Nursing',
            ],
            [
                'user_id' => User::where('email', 'tanveergazar323@gmail.com')->first()->id,
                'department_id' => $departments->last()->id, // Example department assignment
                'designation' => 'Assistant Instructor',
                'final_qualification' => 'Masters in Medical Laboratory Technology',
            ]
        ];

        // Insert instructors into the instructors table
        foreach ($instructors as $instructorData) {
            DB::table('instructors')->insert($instructorData);
        }
    }
}