<?php

namespace App\Http\Controllers;

use App\Models\Dissertation;
use Illuminate\Http\Request;

class DissertationController extends Controller
{
    public function create()
    {
        return view('dissertations.upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'year_completed' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'keywords' => 'required|string',
            'document_file' => 'required|mimes:pdf|max:10240',
            'abstract' => 'required|string',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('document_file')) {
            $data['document_file'] = $request->file('document_file')->store('dissertations', 'public');
        }

        Dissertation::create($data);

        return redirect()->route('dashboard')->with('success', 'Dissertation submitted successfully! It will be reviewed by an administrator.');
    }

    public function show($id)
    {
        $dissertation = Dissertation::with(['user', 'approvedBy'])->findOrFail($id);
        
        if ($dissertation->status !== 'approved') {
            abort(404);
        }
        
        $dissertation->incrementViews();
        
        return view('research.dissertation-detail', compact('dissertation'));
    }

    public function download($id)
    {
        $dissertation = Dissertation::findOrFail($id);
        
        if ($dissertation->status !== 'approved') {
            abort(404);
        }
        
        $filePath = storage_path('app/public/' . $dissertation->document_file);
        
        if (!file_exists($filePath)) {
            abort(404);
        }
        
        return response()->download($filePath, 'Dissertation_' . $dissertation->id . '.pdf');
    }
}
