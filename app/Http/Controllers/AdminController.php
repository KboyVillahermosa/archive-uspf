<?php

namespace App\Http\Controllers;

use App\Models\StudentResearch;
use App\Models\FacultyResearch;
use App\Models\Thesis;
use App\Models\Dissertation;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pendingStudentResearch = StudentResearch::where('status', 'pending')->count();
        $pendingFacultyResearch = FacultyResearch::where('status', 'pending')->count();
        $pendingThesis = Thesis::where('status', 'pending')->count();
        $pendingDissertations = Dissertation::where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'pendingStudentResearch',
            'pendingFacultyResearch',
            'pendingThesis',
            'pendingDissertations'
        ));
    }

    public function pendingResearch()
    {
        $studentResearch = StudentResearch::where('status', 'pending')->with('user')->latest()->get();
        $facultyResearch = FacultyResearch::where('status', 'pending')->with('user')->latest()->get();
        $thesis = Thesis::where('status', 'pending')->with('user')->latest()->get();
        $dissertations = Dissertation::where('status', 'pending')->with('user')->latest()->get();

        return view('admin.pending-research', compact(
            'studentResearch',
            'facultyResearch',
            'thesis',
            'dissertations'
        ));
    }

    public function approveStudentResearch(Request $request, $id)
    {
        $research = StudentResearch::findOrFail($id);
        $research->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'admin_notes' => $request->input('notes', 'Approved by admin')
        ]);

        return redirect()->back()->with('success', 'Student research approved successfully!');
    }

    public function rejectStudentResearch(Request $request, $id)
    {
        $research = StudentResearch::findOrFail($id);
        $research->update([
            'status' => 'rejected',
            'admin_notes' => $request->notes
        ]);

        return redirect()->back()->with('success', 'Student research rejected.');
    }

    public function approveFacultyResearch(Request $request, $id)
    {
        $research = FacultyResearch::findOrFail($id);
        $research->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'admin_notes' => $request->input('notes', 'Approved by admin')
        ]);

        return redirect()->back()->with('success', 'Faculty research approved successfully!');
    }

    public function rejectFacultyResearch(Request $request, $id)
    {
        $research = FacultyResearch::findOrFail($id);
        $research->update([
            'status' => 'rejected',
            'admin_notes' => $request->notes
        ]);

        return redirect()->back()->with('success', 'Faculty research rejected.');
    }

    public function approveThesis(Request $request, $id)
    {
        $thesis = Thesis::findOrFail($id);
        $thesis->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'admin_notes' => $request->input('notes', 'Approved by admin')
        ]);

        return redirect()->back()->with('success', 'Thesis approved successfully!');
    }

    public function rejectThesis(Request $request, $id)
    {
        $thesis = Thesis::findOrFail($id);
        $thesis->update([
            'status' => 'rejected',
            'admin_notes' => $request->notes
        ]);

        return redirect()->back()->with('success', 'Thesis rejected.');
    }

    public function approveDissertation(Request $request, $id)
    {
        $dissertation = Dissertation::findOrFail($id);
        $dissertation->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'admin_notes' => $request->input('notes', 'Approved by admin')
        ]);

        return redirect()->back()->with('success', 'Dissertation approved successfully!');
    }

    public function rejectDissertation(Request $request, $id)
    {
        $dissertation = Dissertation::findOrFail($id);
        $dissertation->update([
            'status' => 'rejected',
            'admin_notes' => $request->notes
        ]);

        return redirect()->back()->with('success', 'Dissertation rejected.');
    }
}
