<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika belum login → lempar ke login
        if (! $request->user()) {
            return redirect()->route('login');
        }

        // Jika login tapi bukan admin → kembali ke dashboard user
        if (! $request->user()->isAdmin()) {
            return redirect()->route('dashboard');
        }

        // Jika admin → lanjutkan request
        return $next($request);
    }
}
