<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Program;

class DepartmentProgramSeeder extends Seeder
{
    public function run(): void
    {
        // List all departments
        $departments = [
            'Faculty Department',
            'Administration Department',
            'College Department',
            'Senior High School Department',
            'Junior High School Department',
            'Grade School Department',
            'Preschool Department',
        ];

        // Create all departments
        foreach ($departments as $deptName) {
            Department::firstOrCreate(['name' => $deptName]);
        }

        // Programs for specific departments only
        $programs = [
            'Faculty Department' => [
                'Faculty Program',
            ],
            'Administration Department' => [
                'Admin Program',
            ],
            'College Department' => [
                'Bachelor of Science in Information Technology',
                'Bachelor of Science in Business Administration',
                'Bachelor of Science in Hospitality Management',
                'Bachelor of Science in Accountancy',
                'Bachelor of Secondary Education',
                'Bachelor of Elementary Education',
                'Bachelor of Science in Criminal Justice',
                'Bachelor of Science in Social Work',
                'Bachelor of Science in Nursing',
            ],
            'Senior High School Department' => [
                'Grade- 11, STEM Strand',
                'Grade- 12, STEM Strand',
                'Grade- 11, ABM Strand',
                'Grade- 12, ABM Strand',
                'Grade- 11, HUMSS Strand',
                'Grade- 12, HUMSS Strand',
                'Grade- 11, TVL Strand',
                'Grade- 12, TVL Strand',
                'Grade- 11, GAS Strand',
                'Grade- 12, GAS Strand',
            ],
            'Junior High School Department' => [
                'Grade 7 Curriculum',
                'Grade 8 Curriculum',
                'Grade 9 Curriculum',
                'Grade 10 Curriculum',
            ],
            'Grade School Department' => [
                'Grade 1 Curriculum',
                'Grade 2 Curriculum',
                'Grade 3 Curriculum',
                'Grade 4 Curriculum',
                'Grade 5 Curriculum',
                'Grade 6 Curriculum',
            ],
            'Preschool Department' => [
                'Nursery Program',
                'Kindergarten Program',
                'Preparatory Program',
            ],
        ];

        // Insert programs only for departments that have them
        foreach ($programs as $departmentName => $programList) {
            $department = Department::where('name', $departmentName)->first();

            if ($department && !empty($programList)) {
                foreach ($programList as $programName) {
                    Program::firstOrCreate([
                        'department_id' => $department->id,
                        'name' => $programName,
                    ]);
                }
            }
        }
    }
}
