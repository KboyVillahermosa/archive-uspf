<?php

namespace App\Http\Controllers;

use App\Models\FacultyResearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FacultyResearchController extends Controller
{
    public function create()
    {
        return view('faculty.upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'co_researchers' => 'nullable|string',
            'department' => 'required|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'research_file' => 'required|mimes:pdf|max:10240',
            'abstract' => 'required|string',
            'tags' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $request->file('banner_image')->store('banners/faculty', 'public');
        }

        if ($request->hasFile('research_file')) {
            $data['research_file'] = $request->file('research_file')->store('research/faculty', 'public');
        }

        FacultyResearch::create($data);

        // Check if it's an AJAX request
        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Faculty research submitted successfully! It is now pending approval.'
            ]);
        }

        return redirect()->route('research.history')->with('success', 'Faculty research submitted successfully! It is now pending approval.');
    }

    public function show($id)
    {
        $research = FacultyResearch::with(['user', 'approvedBy'])->findOrFail($id);
        
        if ($research->status !== 'approved') {
            abort(404);
        }
        
        $research->incrementViews();
        
        return view('research.faculty-detail', compact('research'));
    }

    public function download($id)
    {
        $research = FacultyResearch::findOrFail($id);
        
        if ($research->status !== 'approved') {
            abort(404);
        }
        
        $filePath = storage_path('app/public/' . $research->research_file);
        
        if (!file_exists($filePath)) {
            abort(404);
        }
        
        return response()->download($filePath, 'Faculty_Research_' . $research->id . '.pdf');
    }
}
