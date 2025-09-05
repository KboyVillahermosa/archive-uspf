<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentResearch;
use App\Models\FacultyResearch;
use App\Models\Thesis;
use App\Models\Dissertation;

class DashboardController extends Controller
{
    /**
     * Display the dashboard
     */
    public function index()
    {
        // Redirect admin users to admin dashboard
        if (auth()->check() && auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        
        // Fetch approved research for display
        $approvedStudentResearch = StudentResearch::where('status', 'approved')
            ->with('user')
            ->latest('approved_at')
            ->take(6)
            ->get();
            
        $approvedFacultyResearch = FacultyResearch::where('status', 'approved')
            ->with('user')
            ->latest('approved_at')
            ->take(6)
            ->get();
            
        $approvedThesis = Thesis::where('status', 'approved')
            ->with('user')
            ->latest('approved_at')
            ->take(6)
            ->get();
            
        $approvedDissertations = Dissertation::where('status', 'approved')
            ->with('user')
            ->latest('approved_at')
            ->take(6)
            ->get();
        
        return view('dashboard', compact(
            'approvedStudentResearch',
            'approvedFacultyResearch', 
            'approvedThesis',
            'approvedDissertations'
        ));
    }

    /**
     * Display research organized by department
     */
    public function researchByDepartment()
    {
        // Fetch all approved research for department organization
        $approvedStudentResearch = StudentResearch::where('status', 'approved')
            ->with('user')
            ->latest('approved_at')
            ->get();
            
        $approvedFacultyResearch = FacultyResearch::where('status', 'approved')
            ->with('user')
            ->latest('approved_at')
            ->get();
            
        $approvedThesis = Thesis::where('status', 'approved')
            ->latest('approved_at')
            ->get();
            
        $approvedDissertations = Dissertation::where('status', 'approved')
            ->latest('approved_at')
            ->get();

        return view('research.by-department', compact(
            'approvedStudentResearch',
            'approvedFacultyResearch', 
            'approvedThesis',
            'approvedDissertations'
        ));
    }
}
