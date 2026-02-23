<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    public function index()
    {
        $alumnos = User::role('alumno')
            ->with('wallet')
            ->latest()
            ->paginate(15);
        
        return view('admin.alumnos.index', compact('alumnos'));
    }
}
