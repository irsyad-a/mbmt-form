<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDashboardAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! (bool) $request->session()->get('dashboard.authenticated', false)) {
            return redirect()
                ->route('dashboard.login')
                ->with('error', 'Silakan login dashboard terlebih dahulu.');
        }

        return $next($request);
    }
}
