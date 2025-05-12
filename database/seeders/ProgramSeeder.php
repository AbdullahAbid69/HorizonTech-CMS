<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            [
                'name' => 'BSN Nursing',
                'code' => 'BSN',
                'description' => 'Bachelor of Science in Nursing program focused on professional nursing practice and healthcare management.',
                'duration_in_semesters' => 8,
                'fee_per_semester' => 50000.00,
            ],
            [
                'name' => 'Post RN BSN',
                'code' => 'PRNBSN',
                'description' => 'Post Registered Nurse Bachelor of Science in Nursing program designed for working nurses to advance their education.',
                'duration_in_semesters' => 4,
                'fee_per_semester' => 40000.00,
            ],
            [
                'name' => 'Community Midwife',
                'code' => 'CMW',
                'description' => 'Program to train midwives with specialized skills in maternal and child healthcare, particularly in communities.',
                'duration_in_semesters' => 4,
                'fee_per_semester' => 30000.00,
            ],
            [
                'name' => 'Lady Health Visitor',
                'code' => 'LHV',
                'description' => 'Training program for Lady Health Visitors focusing on community healthcare, maternal and child services.',
                'duration_in_semesters' => 4,
                'fee_per_semester' => 30000.00,
            ],
            [
                'name' => 'BS Diet and Nutrition',
                'code' => 'BSDN',
                'description' => 'Bachelor program focusing on nutrition science, diet planning, and healthcare wellness management.',
                'duration_in_semesters' => 8,
                'fee_per_semester' => 45000.00,
            ],
            [
                'name' => 'BS Medical Lab Technology',
                'code' => 'BSMLT',
                'description' => 'Bachelor of Science program in Medical Laboratory Technology, focusing on diagnostic and laboratory procedures.',
                'duration_in_semesters' => 8,
                'fee_per_semester' => 47000.00,
            ],
            [
                'name' => 'Doctor of Physical Therapy (DPT)',
                'code' => 'DPT',
                'description' => 'Professional Doctorate degree focusing on rehabilitation, physical therapy, and patient mobility healthcare.',
                'duration_in_semesters' => 10,
                'fee_per_semester' => 55000.00,
            ],
        ];

        foreach ($programs as $program) {
            DB::table('programs')->insert($program);
        }
    }
}