<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard utilisateur normal
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Routes admin
    // Route::prefix('admin')->middleware('admin')->group(function () {
    //     Route::get('/dashboard', function () {
    //         return view('admin.dashboard');
    //     })->name('admin.dashboard');

    // Autres routes admin...

    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
});
