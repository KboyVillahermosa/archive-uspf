<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        
        $query = User::where(function($q) {
            $q->where('role', 'faculty')
              ->orWhereHas('roles', function($roleQuery) {
                  $roleQuery->where('name', 'faculty');
              });
        });
        
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('department', 'LIKE', "%{$search}%");
            });
        }
        
        $faculty = $query->select('id', 'name', 'email', 'department')
            ->orderBy('name')
            ->limit(50)
            ->get();
        
        return response()->json($faculty);
    }
}
