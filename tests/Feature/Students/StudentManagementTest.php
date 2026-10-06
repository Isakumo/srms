<?php

namespace Tests\Feature\Students;

use App\Models\Guardian;
use App\Models\School;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_be_created_with_guardians(): void
    {
        $school = School::create([
            'name' => 'Test School',
            'code' => 'test-school-3',
            'status' => 'ACTIVE',
        ]);

        $student = Student::factory()->create([
            'school_id' => $school->id,
            'admission_no' => 'ADM-1001',
        ]);

        $guardian = Guardian::factory()->create([
            'school_id' => $school->id,
            'phone' => '08030000001',
        ]);

        $student->guardians()->attach($guardian->id, [
            'relationship' => 'MOTHER',
            'is_primary' => true,
            'can_pickup' => true,
            'receives_notifications' => true,
        ]);

        $this->assertDatabaseHas('student_guardians', [
            'student_id' => $student->id,
            'guardian_id' => $guardian->id,
            'relationship' => 'MOTHER',
        ]);

        $this->assertTrue($student->guardians()->where('guardian_id', $guardian->id)->exists());
    }
}
