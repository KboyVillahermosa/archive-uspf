<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentResearch;
use App\Models\FacultyResearch;
use App\Models\Thesis;
use App\Models\Dissertation;
use App\Models\Department;

class WelcomeController extends Controller
{
    /**
     * Display the welcome page with approved research
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $searchQuery = $request->get('search', '');
        $typeFilter = $request->get('type', 'all');
        $departmentFilter = $request->get('department', 'all');
        
        // Build base queries
        $studentQuery = StudentResearch::where('status', 'approved')->with('user');
        $facultyQuery = FacultyResearch::where('status', 'approved')->with('user');
        $thesisQuery = Thesis::where('status', 'approved')->with('user');
        $dissertationQuery = Dissertation::where('status', 'approved')->with('user');
        
        // Apply search filter
        if (!empty($searchQuery)) {
            $searchTerm = '%' . $searchQuery . '%';
            
            // Student Research: search in title, authors, department, program, tags, abstract
            $studentQuery->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', $searchTerm)
                  ->orWhere('authors', 'LIKE', $searchTerm)
                  ->orWhere('department', 'LIKE', $searchTerm)
                  ->orWhere('program', 'LIKE', $searchTerm)
                  ->orWhere('tags', 'LIKE', $searchTerm)
                  ->orWhere('abstract', 'LIKE', $searchTerm);
            });
            
            // Faculty Research: search in title, co_researchers, department, tags, abstract
            $facultyQuery->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', $searchTerm)
                  ->orWhere('co_researchers', 'LIKE', $searchTerm)
                  ->orWhere('department', 'LIKE', $searchTerm)
                  ->orWhere('tags', 'LIKE', $searchTerm)
                  ->orWhere('abstract', 'LIKE', $searchTerm)
                  ->orWhereHas('user', function($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'LIKE', $searchTerm);
                  });
            });
            
            // Thesis: search in title, author, department, program, keywords, abstract
            $thesisQuery->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', $searchTerm)
                  ->orWhere('author', 'LIKE', $searchTerm)
                  ->orWhere('department', 'LIKE', $searchTerm)
                  ->orWhere('program', 'LIKE', $searchTerm)
                  ->orWhere('keywords', 'LIKE', $searchTerm)
                  ->orWhere('abstract', 'LIKE', $searchTerm);
            });
            
            // Dissertation: search in title, author, department, program, keywords, abstract
            $dissertationQuery->where(function($q) use ($searchTerm) {
                $q->where('title', 'LIKE', $searchTerm)
                  ->orWhere('author', 'LIKE', $searchTerm)
                  ->orWhere('department', 'LIKE', $searchTerm)
                  ->orWhere('program', 'LIKE', $searchTerm)
                  ->orWhere('keywords', 'LIKE', $searchTerm)
                  ->orWhere('abstract', 'LIKE', $searchTerm);
            });
        }
        
        // Apply department filter
        if ($departmentFilter !== 'all') {
            $department = Department::find($departmentFilter);
            if ($department) {
                $studentQuery->where('department', $department->name);
                $facultyQuery->where('department', $department->name);
                $thesisQuery->where('department', $department->name);
                $dissertationQuery->where('department', $department->name);
            }
        }
        
        // Apply type filter and get results
        $approvedStudentResearch = collect();
        $approvedFacultyResearch = collect();
        $approvedThesis = collect();
        $approvedDissertations = collect();
        
        if ($typeFilter === 'all' || $typeFilter === 'student') {
            $approvedStudentResearch = $studentQuery->latest('approved_at')->take(6)->get();
        }
        
        if ($typeFilter === 'all' || $typeFilter === 'faculty') {
            $approvedFacultyResearch = $facultyQuery->latest('approved_at')->take(6)->get();
        }
        
        if ($typeFilter === 'all' || $typeFilter === 'thesis') {
            $approvedThesis = $thesisQuery->latest('approved_at')->take(6)->get();
        }
        
        if ($typeFilter === 'all' || $typeFilter === 'dissertation') {
            $approvedDissertations = $dissertationQuery->latest('approved_at')->take(6)->get();
        }
        
        // Fetch all departments with their programs
        $departments = Department::with('programs')
            ->orderBy('name')
            ->get();
        
        return view('welcome', compact(
            'approvedStudentResearch',
            'approvedFacultyResearch', 
            'approvedThesis',
            'approvedDissertations',
            'departments',
            'searchQuery'
        ));
    }
}


