<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                'code' => 'NUR101',
                'title' => 'Introduction to Nursing',
                'description' => 'Fundamental concepts and practices in nursing, including patient care and ethics.',
                'credit_hours' => 3,
                'prerequisites' => json_encode([]),
            ],
            [
                'code' => 'NUR202',
                'title' => 'Human Anatomy and Physiology',
                'description' => 'Detailed study of human body structure and function, essential for healthcare professionals.',
                'credit_hours' => 4,
                'prerequisites' => json_encode(['NUR101']),
            ],
            [
                'code' => 'DPT301',
                'title' => 'Physical Therapy Techniques',
                'description' => 'Core techniques and practices used in physical therapy and rehabilitation.',
                'credit_hours' => 3,
                'prerequisites' => json_encode([]),
            ],
            [
                'code' => 'MLT101',
                'title' => 'Clinical Laboratory Techniques',
                'description' => 'Introduction to laboratory methods, sample collection, and diagnostic procedures.',
                'credit_hours' => 3,
                'prerequisites' => json_encode([]),
            ],
            [
                'code' => 'NUT201',
                'title' => 'Principles of Human Nutrition',
                'description' => 'Explores human dietary needs, nutrient functions, and diet planning.',
                'credit_hours' => 3,
                'prerequisites' => json_encode([]),
            ],
            [
                'code' => 'CMW101',
                'title' => 'Maternal and Child Health',
                'description' => 'Focuses on healthcare practices related to pregnancy, childbirth, and newborn care.',
                'credit_hours' => 3,
                'prerequisites' => json_encode([]),
            ],
            [
                'code' => 'LHV201',
                'title' => 'Community Health and Disease Prevention',
                'description' => 'Covers strategies for improving community health and preventing communicable diseases.',
                'credit_hours' => 3,
                'prerequisites' => json_encode([]),
            ],
        ];

        foreach ($courses as $course) {
            DB::table('courses')->insert($course);
        }
    }
}