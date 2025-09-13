<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentResearch;
use App\Models\FacultyResearch;
use App\Models\Thesis;
use App\Models\Dissertation;

class WelcomeController extends Controller
{
    /**
     * Display the welcome page with approved research
     */
    public function index()
    {
        // Fetch approved research for display (limited for performance)
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
        
        return view('welcome', compact(
            'approvedStudentResearch',
            'approvedFacultyResearch', 
            'approvedThesis',
            'approvedDissertations'
        ));
    }
}


