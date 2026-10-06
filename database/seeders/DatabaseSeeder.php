<?php

namespace Database\Seeders;

use App\Models\AcademicSession;
use App\Models\ClassGroup;
use App\Models\GradeLevel;
use App\Models\School;
use App\Models\SchoolSection;
use App\Models\Term;
use Illuminate\Database\Seeder;

class SchoolConfigurationSeeder extends Seeder
{
    public function run(): void
    {
        $school = School::where('code', 'demo-school')->firstOrFail();

        $sections = [
            ['name' => 'Nursery', 'code' => 'nursery', 'display_order' => 1],
            ['name' => 'Primary', 'code' => 'primary', 'display_order' => 2],
            ['name' => 'Junior Secondary', 'code' => 'jss', 'display_order' => 3],
            ['name' => 'Senior Secondary', 'code' => 'sss', 'display_order' => 4],
        ];

        foreach ($sections as $sectionData) {
            $section = SchoolSection::updateOrCreate([
                'school_id' => $school->id,
                'code' => $sectionData['code'],
            ], [
                'name' => $sectionData['name'],
                'display_order' => $sectionData['display_order'],
                'status' => 'ACTIVE',
            ]);

            $gradeDefinitions = [
                'nursery' => ['Nursery 1', 'Nursery 2'],
                'primary' => ['Primary 1', 'Primary 2', 'Primary 3', 'Primary 4', 'Primary 5', 'Primary 6'],
                'jss' => ['JSS 1', 'JSS 2', 'JSS 3'],
                'sss' => ['SSS 1', 'SSS 2', 'SSS 3'],
            ];

            foreach ($gradeDefinitions[$sectionData['code']] as $index => $gradeName) {
                $gradeCode = strtolower(str_replace([' ', '/'], ['-', '-'], $gradeName));
                $grade = GradeLevel::updateOrCreate([
                    'school_id' => $school->id,
                    'section_id' => $section->id,
                    'code' => $gradeCode,
                ], [
                    'name' => $gradeName,
                    'sequence' => $index + 1,
                    'status' => 'ACTIVE',
                ]);

                $classGroups = ['A', 'B', 'C'];

                foreach ($classGroups as $arm) {
                    ClassGroup::updateOrCreate([
                        'school_id' => $school->id,
                        'grade_level_id' => $grade->id,
                        'code' => strtolower($gradeCode . '-' . $arm),
                    ], [
                        'name' => $gradeName . ' ' . $arm,
                        'capacity' => 40,
                        'status' => 'ACTIVE',
                    ]);
                }
            }
        }

        $session = AcademicSession::updateOrCreate([
            'school_id' => $school->id,
            'name' => '2025/2026 Academic Session',
        ], [
            'start_date' => '2025-09-01',
            'end_date' => '2026-07-31',
            'is_current' => true,
            'status' => 'ACTIVE',
        ]);

        $terms = [
            ['name' => 'First Term', 'sequence' => 1, 'start_date' => '2025-09-01', 'end_date' => '2025-12-19', 'is_current' => false],
            ['name' => 'Second Term', 'sequence' => 2, 'start_date' => '2026-01-05', 'end_date' => '2026-04-10', 'is_current' => false],
            ['name' => 'Third Term', 'sequence' => 3, 'start_date' => '2026-04-20', 'end_date' => '2026-07-31', 'is_current' => true],
        ];

        foreach ($terms as $termData) {
            Term::updateOrCreate([
                'academic_session_id' => $session->id,
                'sequence' => $termData['sequence'],
            ], [
                'name' => $termData['name'],
                'start_date' => $termData['start_date'],
                'end_date' => $termData['end_date'],
                'is_current' => $termData['is_current'],
                'status' => 'ACTIVE',
            ]);
        }
    }
}
