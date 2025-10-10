<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //

    }
    public function toResponse($request)
    {
        $user = Auth::user();
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->hasRole('admin')) {
                return redirect()->intended('/admin');

            }

            if ($user->hasRole('teacher')) {
                return redirect()->intended('/teacher/dashboard');
            }

            if ($user->hasRole('student')) {
                return redirect()->route('student.dashboard');
            }
        }

        // if ($user->isAdmin()) {
        //     return redirect()->intended('/admin/dashboard');
        // }
        // if ($user->hasRole('teacher')) {
        //     return redirect()->intended('/teacher/dashboards');
        // }

        // Redirection par défaut pour les utilisateurs normaux
        return redirect()->intended('/login');
    }
}
