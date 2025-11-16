<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Program;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::orderBy('name')->get();
        return response()->json($departments);
    }

    public function programs($departmentId)
    {
        $programs = Program::where('department_id', $departmentId)
                          ->orderBy('name')
                          ->get();
        return response()->json($programs);
    }

    public function allPrograms()
    {
        $programs = Program::with('department')->orderBy('name')->get();
        return response()->json($programs);
    }
}
