<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function show(Student $student)
    {
        if ($student->user_id !== Auth::id()) abort(403);
        
        $student->load(['documents', 'payment']);
        return view('student.show', compact('student'));
    }
}
