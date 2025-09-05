<?php

namespace App\Http\Controllers;

use App\Models\StudentResearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentResearchController extends Controller
{
    public function create()
    {
        return view('student.upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'authors' => 'required|string',
            'department' => 'required|string|max:255',
            'program' => 'required|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'research_file' => 'required|mimes:pdf|max:10240',
            'abstract' => 'required|string',
            'tags' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $request->file('banner_image')->store('banners/student', 'public');
        }

        if ($request->hasFile('research_file')) {
            $data['research_file'] = $request->file('research_file')->store('research/student', 'public');
        }

        StudentResearch::create($data);

        return redirect()->route('dashboard')->with('success', 'Research submitted successfully! It will be reviewed by an administrator.');
    }

    public function show($id)
    {
        $research = StudentResearch::with(['user', 'approvedBy'])->findOrFail($id);
        
        // Only show approved research
        if ($research->status !== 'approved') {
            abort(404);
        }
        
        // Increment view count
        $research->incrementViews();
        
        return view('research.student-detail', compact('research'));
    }

    public function download($id)
    {
        $research = StudentResearch::findOrFail($id);
        
        // Only allow download for approved research
        if ($research->status !== 'approved') {
            abort(404);
        }
        
        $filePath = storage_path('app/public/' . $research->research_file);
        
        if (!file_exists($filePath)) {
            abort(404);
        }
        
        return response()->download($filePath, 'Student_Research_' . $research->id . '.pdf');
    }
    
}
