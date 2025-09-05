<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentResearchController;
use App\Http\Controllers\FacultyResearchController;
use App\Http\Controllers\ThesisController;
use App\Http\Controllers\DissertationController;
use App\Http\Controllers\AdminController;
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
    
    // Download routes
    Route::get('/download/student/{id}', [StudentResearchController::class, 'download'])->name('student.download');
    Route::get('/download/faculty/{id}', [FacultyResearchController::class, 'download'])->name('faculty.download');
    Route::get('/download/thesis/{id}', [ThesisController::class, 'download'])->name('thesis.download');
    Route::get('/download/dissertation/{id}', [DissertationController::class, 'download'])->name('dissertation.download');
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

