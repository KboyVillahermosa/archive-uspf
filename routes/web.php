<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentResearchController;
use App\Http\Controllers\FacultyResearchController;
use App\Http\Controllers\ThesisController;
use App\Http\Controllers\DissertationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ResearchCitationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Research by department route
    Route::get('/research/by-department', [DashboardController::class, 'researchByDepartment'])->name('research.by-department');
    
    // Research upload routes
    Route::get('/student/upload', [StudentResearchController::class, 'create'])->name('student.upload');
    Route::post('/student/upload', [StudentResearchController::class, 'store'])->name('student.store');
    
    Route::get('/faculty/upload', [FacultyResearchController::class, 'create'])->name('faculty.upload');
    Route::post('/faculty/upload', [FacultyResearchController::class, 'store'])->name('faculty.store');
    
    Route::get('/thesis/upload', [ThesisController::class, 'create'])->name('thesis.upload');
    Route::post('/thesis/upload', [ThesisController::class, 'store'])->name('thesis.store');
    
    Route::get('/dissertations/upload', [DissertationController::class, 'create'])->name('dissertations.upload');
    Route::post('/dissertations/upload', [DissertationController::class, 'store'])->name('dissertations.store');
    
    // Research detail view routes
    Route::get('/research/student/{id}', [StudentResearchController::class, 'show'])->name('student.show');
    Route::get('/research/faculty/{id}', [FacultyResearchController::class, 'show'])->name('faculty.show');
    Route::get('/research/thesis/{id}', [ThesisController::class, 'show'])->name('thesis.show');
    Route::get('/research/dissertation/{id}', [DissertationController::class, 'show'])->name('dissertation.show');
    
    // Download survey modal routes
    Route::get('/download-survey/student/{id}', [StudentResearchController::class, 'downloadSurvey'])->name('student.download-survey');
    Route::get('/download-survey/faculty/{id}', [FacultyResearchController::class, 'downloadSurvey'])->name('faculty.download-survey');
    Route::get('/download-survey/thesis/{id}', [ThesisController::class, 'downloadSurvey'])->name('thesis.download-survey');
    Route::get('/download-survey/dissertation/{id}', [DissertationController::class, 'downloadSurvey'])->name('dissertation.download-survey');
    
    // Download routes with survey data
    Route::post('/download/student/{id}', [StudentResearchController::class, 'download'])->name('student.download');
    Route::post('/download/faculty/{id}', [FacultyResearchController::class, 'download'])->name('faculty.download');
    Route::post('/download/thesis/{id}', [ThesisController::class, 'download'])->name('thesis.download');
    Route::post('/download/dissertation/{id}', [DissertationController::class, 'download'])->name('dissertation.download');
    
    // Direct file download routes (after survey)
    Route::get('/download-file/student/{id}', [StudentResearchController::class, 'downloadFile'])->name('student.download.file');
    Route::get('/download-file/faculty/{id}', [FacultyResearchController::class, 'downloadFile'])->name('faculty.download.file');
    Route::get('/download-file/thesis/{id}', [ThesisController::class, 'downloadFile'])->name('thesis.download.file');
    Route::get('/download-file/dissertation/{id}', [DissertationController::class, 'downloadFile'])->name('dissertation.download.file');
    
    // Research history/tracking routes
    Route::get('/research/history', [DashboardController::class, 'researchHistory'])->name('research.history');
    
    // Research citation routes
    Route::get('/citations/search', [ResearchCitationController::class, 'searchApprovedResearch'])->name('citations.search');
    Route::post('/citations', [ResearchCitationController::class, 'store'])->name('citations.store');
    Route::get('/my-citations', [ResearchCitationController::class, 'getUserCitations'])->name('citations.my');
    Route::get('/research-citations/{type}/{id}', [ResearchCitationController::class, 'getResearchCitations'])->name('citations.research');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/pending-research', [AdminController::class, 'pendingResearch'])->name('pending-research');
    
    // Student research approval
    Route::post('/approve/student/{id}', [AdminController::class, 'approveStudentResearch'])->name('approve.student');
    Route::post('/reject/student/{id}', [AdminController::class, 'rejectStudentResearch'])->name('reject.student');
    
    // Faculty research approval
    Route::post('/approve/faculty/{id}', [AdminController::class, 'approveFacultyResearch'])->name('approve.faculty');
    Route::post('/reject/faculty/{id}', [AdminController::class, 'rejectFacultyResearch'])->name('reject.faculty');
    
    // Thesis approval
    Route::post('/approve/thesis/{id}', [AdminController::class, 'approveThesis'])->name('approve.thesis');
    Route::post('/reject/thesis/{id}', [AdminController::class, 'rejectThesis'])->name('reject.thesis');
    
    // Dissertation approval
    Route::post('/approve/dissertation/{id}', [AdminController::class, 'approveDissertation'])->name('approve.dissertation');
    Route::post('/reject/dissertation/{id}', [AdminController::class, 'rejectDissertation'])->name('reject.dissertation');
});

require __DIR__.'/auth.php';

