<?php

use App\Livewire\Professor\GradeManagement;
use App\Livewire\Professor\TeacherClassManagement;
use Illuminate\Support\Facades\Route;
use App\Livewire\Professor\ProfDashboard;
use App\Livewire\Student\StudentDashboard;
use App\Livewire\Professor\Calendar;
use App\Livewire\Professor\Messages;
Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboards', ProfDashboard::class)->name('dashboard');



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard utilisateur normal
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::get('/teacher/dashboard', ProfDashboard::class);
    Route::get('/teacher/grade', GradeManagement::class)->name('professor.grades');
    Route::get('/teacher/class', TeacherClassManagement::class)->name('professor.classes');
    Route::get('/student/dashboard', StudentDashboard::class);

});


