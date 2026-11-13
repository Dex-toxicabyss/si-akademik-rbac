<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request and verify user role against allowed roles.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userRole = Auth::user()->role;

        if (!in_array($userRole, $roles, true)) {
            abort(
                403,
                sprintf(
                    '403 Forbidden — Role [%s] tidak memiliki izin mengakses endpoint [%s]. Diperlukan role: [%s].',
                    strtoupper($userRole),
                    $request->path(),
                    implode(', ', array_map('strtoupper', $roles))
                )
            );
        }

        return $next($request);
    }
}
