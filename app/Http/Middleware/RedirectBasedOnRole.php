<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->isAdmin()) {
                return redirect('/admin');
            } elseif ($user->isTeacher()) {
                return redirect('/teacher/dashboard');
            } elseif ($user->isStudent()) {
                return redirect('/student/dashboard');
            }
        }
        // if (Auth::check()) {
        //     $user = Auth::user();

        //     if ($user->hasRole('admin')) {
        //         return redirect()->route('admin.dashboard');
        //     }

        //     if ($user->hasRole('teacher')) {
        //         return redirect()->route('teacher.dashboard');
        //     }

        //     if ($user->hasRole('student')) {
        //         return redirect()->route('student.dashboard');
        //     }
        // }
        return $next($request);
    }
}
