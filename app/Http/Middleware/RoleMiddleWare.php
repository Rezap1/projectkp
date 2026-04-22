<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!auth()->check() || auth()->user()->role !== $role) {
            // Jika bukan rolenya, tendang ke halaman depan
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
