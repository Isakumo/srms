<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(Request $request): View
    {
        $students = Student::query()
            ->with('guardians')
            ->latest()
            ->paginate(25);

        return view('students.index', [
            'students' => $students,
        ]);
    }
}
