<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (!Auth::check() || !Auth::user()->isAdmin()) {
        //     abort(403, 'Accès refusé. Droits administrateur requis.');
        // }
        if (!Auth::check() || !Auth::user()->hasAnyRole(['admin', 'teacher', 'student'])) {
            abort(403, 'Accès non autorisé');
        }
        // if (!auth()->user()->hasAnyRole(['admin', 'teacher', 'student'])) {
        //     abort(403, 'Accès non autorisé');
        // }


        return $next($request);
    }
}
