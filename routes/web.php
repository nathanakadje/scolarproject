<?php

use App\Livewire\Professor\AssignmentManagement;
use App\Livewire\Professor\GradeManagement;
use App\Livewire\Professor\MyStudents;
use App\Livewire\Professor\ProfessorCalendar;
use App\Livewire\Professor\ResourceManagement;
use App\Livewire\Professor\TeacherClassManagement;
use App\Livewire\Student\Calendar;
use App\Livewire\Student\Assignments;
use App\Livewire\Student\NotificationsPage;
use App\Livewire\Student\Timetable;
use Illuminate\Support\Facades\Route;
use App\Livewire\Professor\ProfDashboard;
use App\Livewire\Student\StudentDashboard;

Route::get('/', function () {
    return redirect()->route('login');
    ;
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


    Route::get('/teacher/dashboard', ProfDashboard::class)->name('professor.dashboard');
    Route::get('/teacher/grade', GradeManagement::class)->name('professor.grades');
    Route::get('/teacher/student', MyStudents::class)->name('professor.students');
    Route::get('/teacher/class', TeacherClassManagement::class)->name('professor.classes');
    Route::get('/teacher/calendar', ProfessorCalendar::class)->name('professor.calendar');
    Route::get('/teacher/devoir', ResourceManagement::class)->name('professor.assignments');
    Route::get('/resources', ResourceManagement::class)->name('resources');
    Route::get('/teacher/devoirs', AssignmentManagement::class)->name('professor.courses');
    Route::get('/student/dashboard', StudentDashboard::class)->name('student.dashboard');
    Route::get('/student/calendar', Calendar::class)->name('student.calendar');
    Route::get('/student/assignments', Assignments::class)->name('student.assignments');
    Route::get('/student/timetable', Timetable::class)->name('student.timetable');
    Route::get('/notifications', NotificationsPage::class)->name('notifications');

});


