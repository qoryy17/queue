<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\RouterLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class NonAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is already authenticated
        if (Auth::check()) {
            // Redirect to home page
            $route = RouterLink::string(Auth::user()->role);
            return redirect()->route($route);
        }
        return $next($request);
    }
}
