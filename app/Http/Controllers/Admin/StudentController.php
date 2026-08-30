<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = User::role('alumno')
            ->with('wallet')
            ->latest()
            ->paginate(15);
        
        return view('admin.students.index', compact('students'));
    }
}
