<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class TutorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && (Auth::user()->is_admin === 1 || Auth::user()->is_tutor === 1)) {
            return $next($request);  // Ako je sve u redu, dozvolite pristup ruti
        }

        // Ako nije odgovarajući mejl, preusmerite ga na dashboard (ili neku drugu stranicu)
        return redirect()->route('dashboard');
    }
}
