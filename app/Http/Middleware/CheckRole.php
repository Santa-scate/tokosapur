<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */


    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek jika user sudah login DAN rolenya ada di dalam daftar $roles yang diizinkan
        if (! $request->user() || ! in_array($request->user()->role, $roles)) {
            // Jika tidak, redirect ke halaman dashboard atau berikan error 403
            return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
