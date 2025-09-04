<?php

namespace App\Http\Controllers;

use App\Models\Thesis;
use Illuminate\Http\Request;

class ThesisController extends Controller
{
    public function create()
    {
        return view('thesis.upload');
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
            $data['document_file'] = $request->file('document_file')->store('thesis', 'public');
        }

        Thesis::create($data);

        return redirect()->route('dashboard')->with('success', 'Thesis submitted successfully! It will be reviewed by an administrator.');
    }

    public function show($id)
    {
        $thesis = Thesis::with(['user', 'approvedBy'])->findOrFail($id);
        
        if ($thesis->status !== 'approved') {
            abort(404);
        }
        
        $thesis->incrementViews();
        
        return view('research.thesis-detail', compact('thesis'));
    }

    public function download($id)
    {
        $thesis = Thesis::findOrFail($id);
        
        if ($thesis->status !== 'approved') {
            abort(404);
        }
        
        $filePath = storage_path('app/public/' . $thesis->document_file);
        
        if (!file_exists($filePath)) {
            abort(404);
        }
        
        return response()->download($filePath, 'Thesis_' . $thesis->id . '.pdf');
    }
}
