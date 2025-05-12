<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Nursing',
                'description' => 'The department focused on nursing education and practice, offering courses in various nursing fields including BSN and Post-RN programs.',
            ],
            [
                'name' => 'Physiotherapy',
                'description' => 'The physiotherapy department offers courses on rehabilitation, physical therapy techniques, and health maintenance.',
            ],
            [
                'name' => 'Medical Laboratory Technology',
                'description' => 'This department specializes in medical laboratory practices, diagnostic techniques, and laboratory management.',
            ]
        ];

        foreach ($departments as $department) {
            DB::table('departments')->insert($department);
        }
    }
}