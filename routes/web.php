<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Professor\ProfDashboard;
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

});


