<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\StudentResearchController;
use App\Http\Controllers\FacultyResearchController;
use App\Http\Controllers\ThesisController;
use App\Http\Controllers\DissertationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ResearchCitationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Public research view routes (no auth required for viewing)
Route::get('/research/student/{id}', [StudentResearchController::class, 'showPublic'])->name('student.show.public');
Route::get('/research/faculty/{id}', [FacultyResearchController::class, 'showPublic'])->name('faculty.show.public');
Route::get('/research/thesis/{id}', [ThesisController::class, 'showPublic'])->name('thesis.show.public');
Route::get('/research/dissertation/{id}', [DissertationController::class, 'showPublic'])->name('dissertation.show.public');

// Download survey modal routes (public)
Route::get('/download-survey/student/{id}', [StudentResearchController::class, 'downloadSurvey'])->name('student.download-survey');
Route::get('/download-survey/faculty/{id}', [FacultyResearchController::class, 'downloadSurvey'])->name('faculty.download-survey');
Route::get('/download-survey/thesis/{id}', [ThesisController::class, 'downloadSurvey'])->name('thesis.download-survey');
Route::get('/download-survey/dissertation/{id}', [DissertationController::class, 'downloadSurvey'])->name('dissertation.download-survey');

// Download routes with survey data (public)
Route::post('/download/student/{id}', [StudentResearchController::class, 'download'])->name('student.download');
Route::post('/download/faculty/{id}', [FacultyResearchController::class, 'download'])->name('faculty.download');
Route::post('/download/thesis/{id}', [ThesisController::class, 'download'])->name('thesis.download');
Route::post('/download/dissertation/{id}', [DissertationController::class, 'download'])->name('dissertation.download');

// Abstract PDF viewer routes (public - blurred for non-authenticated users)
Route::get('/view-abstract-pdf/student/{id}', [StudentResearchController::class, 'viewAbstractPdf'])->name('student.view-abstract.pdf');
Route::get('/view-abstract-pdf/faculty/{id}', [FacultyResearchController::class, 'viewAbstractPdf'])->name('faculty.view-abstract.pdf');
Route::get('/view-abstract-pdf/thesis/{id}', [ThesisController::class, 'viewAbstractPdf'])->name('thesis.view-abstract.pdf');
Route::get('/view-abstract-pdf/dissertation/{id}', [DissertationController::class, 'viewAbstractPdf'])->name('dissertation.view-abstract.pdf');

// Abstract download GET routes (redirect to login if not authenticated, show survey if authenticated)
Route::get('/download-abstract/student/{id}', [StudentResearchController::class, 'downloadAbstractGet'])->name('student.download-abstract.get');
Route::get('/download-abstract/faculty/{id}', [FacultyResearchController::class, 'downloadAbstractGet'])->name('faculty.download-abstract.get');
Route::get('/download-abstract/thesis/{id}', [ThesisController::class, 'downloadAbstractGet'])->name('thesis.download-abstract.get');
Route::get('/download-abstract/dissertation/{id}', [DissertationController::class, 'downloadAbstractGet'])->name('dissertation.download-abstract.get');

// PDF viewer routes (accessible to everyone, authentication checked in controller)
Route::get('/view-pdf/student/{id}', [StudentResearchController::class, 'viewPdf'])->name('student.view.pdf');
Route::get('/view-pdf/faculty/{id}', [FacultyResearchController::class, 'viewPdf'])->name('faculty.view.pdf');
Route::get('/view-pdf/thesis/{id}', [ThesisController::class, 'viewPdf'])->name('thesis.view.pdf');
Route::get('/view-pdf/dissertation/{id}', [DissertationController::class, 'viewPdf'])->name('dissertation.view.pdf');

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
    Route::get('/research/student/{id}/private', [StudentResearchController::class, 'show'])->name('student.show');
    Route::get('/research/faculty/{id}/private', [FacultyResearchController::class, 'show'])->name('faculty.show');
    Route::get('/research/thesis/{id}/private', [ThesisController::class, 'show'])->name('thesis.show');
    Route::get('/research/dissertation/{id}/private', [DissertationController::class, 'show'])->name('dissertation.show');

    // Research edit routes for pending submissions
    Route::get('/student/{id}/edit', [StudentResearchController::class, 'edit'])->name('student.edit');
    Route::get('/faculty/{id}/edit', [FacultyResearchController::class, 'edit'])->name('faculty.edit');
    Route::get('/thesis/{id}/edit', [ThesisController::class, 'edit'])->name('thesis.edit');
    Route::get('/dissertation/{id}/edit', [DissertationController::class, 'edit'])->name('dissertation.edit');
    
    // Direct file download routes (after survey)
    Route::get('/download-file/student/{id}', [StudentResearchController::class, 'downloadFile'])->name('student.download.file');
    Route::get('/download-file/faculty/{id}', [FacultyResearchController::class, 'downloadFile'])->name('faculty.download.file');
    Route::get('/download-file/thesis/{id}', [ThesisController::class, 'downloadFile'])->name('thesis.download.file');
    Route::get('/download-file/dissertation/{id}', [DissertationController::class, 'downloadFile'])->name('dissertation.download.file');
    
    // Abstract download routes (require authentication)
    Route::post('/download-abstract/student/{id}', [StudentResearchController::class, 'downloadAbstract'])->name('student.download-abstract');
    Route::get('/download-abstract-file/student/{id}', [StudentResearchController::class, 'downloadAbstractFile'])->name('student.download-abstract.file');
    
    Route::post('/download-abstract/faculty/{id}', [FacultyResearchController::class, 'downloadAbstract'])->name('faculty.download-abstract');
    Route::get('/download-abstract-file/faculty/{id}', [FacultyResearchController::class, 'downloadAbstractFile'])->name('faculty.download-abstract.file');
    
    Route::post('/download-abstract/thesis/{id}', [ThesisController::class, 'downloadAbstract'])->name('thesis.download-abstract');
    Route::get('/download-abstract-file/thesis/{id}', [ThesisController::class, 'downloadAbstractFile'])->name('thesis.download-abstract.file');
    
    Route::post('/download-abstract/dissertation/{id}', [DissertationController::class, 'downloadAbstract'])->name('dissertation.download-abstract');
    Route::get('/download-abstract-file/dissertation/{id}', [DissertationController::class, 'downloadAbstractFile'])->name('dissertation.download-abstract.file');
    
    // Research history/tracking routes
    Route::get('/research/history', [DashboardController::class, 'researchHistory'])->name('research.history');
    
    // Research citation routes
    Route::get('/citations/search', [ResearchCitationController::class, 'searchApprovedResearch'])->name('citations.search');
    Route::post('/citations', [ResearchCitationController::class, 'store'])->name('citations.store');
    Route::get('/my-citations', [ResearchCitationController::class, 'getUserCitations'])->name('citations.my');
    Route::get('/research-citations/{type}/{id}', [ResearchCitationController::class, 'getResearchCitations'])->name('citations.research');
    Route::get('/references-cited/{type}/{id}', [ResearchCitationController::class, 'getReferencesCited'])->name('citations.references');
});

// Admin dashboard - admin and faculty with permissions
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});

// Research Management - accessible to admin and faculty
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/research', [AdminController::class, 'allResearch'])->name('research');
    Route::get('/research/filter-form', [AdminController::class, 'filterForm'])->name('research.filter-form');
    Route::get('/pending-research', [AdminController::class, 'pendingResearch'])->name('pending-research');
    Route::get('/downloads-views', [AdminController::class, 'downloadsViews'])->name('downloads-views');
    
    // Student research approval
    Route::get('/approve/student/{id}', [AdminController::class, 'approveStudentForm'])->name('approve.student.form');
    Route::post('/approve/student/{id}', [AdminController::class, 'approveStudentResearch'])->name('approve.student');
    Route::get('/reject/student/{id}', [AdminController::class, 'rejectStudentForm'])->name('reject.student.form');
    Route::post('/reject/student/{id}', [AdminController::class, 'rejectStudentResearch'])->name('reject.student');
    
    // Faculty research approval
    Route::get('/approve/faculty/{id}', [AdminController::class, 'approveFacultyForm'])->name('approve.faculty.form');
    Route::post('/approve/faculty/{id}', [AdminController::class, 'approveFacultyResearch'])->name('approve.faculty');
    Route::get('/reject/faculty/{id}', [AdminController::class, 'rejectFacultyForm'])->name('reject.faculty.form');
    Route::post('/reject/faculty/{id}', [AdminController::class, 'rejectFacultyResearch'])->name('reject.faculty');
    
    // Thesis approval
    Route::get('/approve/thesis/{id}', [AdminController::class, 'approveThesisForm'])->name('approve.thesis.form');
    Route::post('/approve/thesis/{id}', [AdminController::class, 'approveThesis'])->name('approve.thesis');
    Route::get('/reject/thesis/{id}', [AdminController::class, 'rejectThesisForm'])->name('reject.thesis.form');
    Route::post('/reject/thesis/{id}', [AdminController::class, 'rejectThesis'])->name('reject.thesis');
    
    // Dissertation approval
    Route::get('/approve/dissertation/{id}', [AdminController::class, 'approveDissertationForm'])->name('approve.dissertation.form');
    Route::post('/approve/dissertation/{id}', [AdminController::class, 'approveDissertation'])->name('approve.dissertation');
    Route::get('/reject/dissertation/{id}', [AdminController::class, 'rejectDissertationForm'])->name('reject.dissertation.form');
    Route::post('/reject/dissertation/{id}', [AdminController::class, 'rejectDissertation'])->name('reject.dissertation');
    
    // Adviser approvals (faculty only)
    Route::get('/adviser-approvals', [AdminController::class, 'adviserApprovals'])->name('adviser-approvals');
    Route::post('/adviser-approve/{type}/{id}', [AdminController::class, 'approveAdviser'])->name('adviser.approve');
    Route::post('/adviser-reject/{type}/{id}', [AdminController::class, 'rejectAdviser'])->name('adviser.reject');
    
    // Delete research route
    Route::delete('/research/{type}/{id}', [AdminController::class, 'deleteResearch'])->name('research.delete');
});

// Users management - accessible to admin and faculty with view-any users permission
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'create'])->name('users.create');
    Route::get('/users/template', [AdminController::class, 'downloadUserTemplate'])->name('users.template');
    Route::post('/users', [AdminController::class, 'store'])->name('users.store');
    Route::post('/users/import', [AdminController::class, 'importUsers'])->name('users.import');
    Route::get('/users/{user}', [AdminController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [AdminController::class, 'edit'])->name('users.edit');
    Route::get('/users/{user}/password', [AdminController::class, 'password'])->name('users.password');
    Route::put('/users/{user}', [AdminController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');
});

// Roles management - accessible to admin and faculty with view-any roles permission
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/roles', [\App\Http\Controllers\RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [\App\Http\Controllers\RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [\App\Http\Controllers\RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}/edit', [\App\Http\Controllers\RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}', [\App\Http\Controllers\RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [\App\Http\Controllers\RoleController::class, 'destroy'])->name('roles.destroy');
});

// API routes for dynamic dropdowns
Route::prefix('api')->group(function () {
    Route::get('/departments', [\App\Http\Controllers\Api\DepartmentController::class, 'index']);
    Route::get('/departments/{departmentId}/programs', [\App\Http\Controllers\Api\DepartmentController::class, 'programs']);
    Route::get('/programs', [\App\Http\Controllers\Api\DepartmentController::class, 'allPrograms']);
    Route::get('/faculty', [\App\Http\Controllers\Api\FacultyController::class, 'index']);
});

require __DIR__.'/auth.php';

