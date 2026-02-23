<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
        return redirect('/login');
        }
        $user = Auth::user();

        if(!$user->hasRole('admin')) {
            abort(403);
        }

        return $next($request);
        // $userRole = session('user_role');

        // if ($userRole === 1) {
        //     return $next($request);
        // } else {
        //     return back()->with('Error', 'Akses ditolak');
        // }
    }
}
