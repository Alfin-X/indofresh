<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpFoundation\Response;

class HandleSessionExpired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            return $next($request);
        } catch (TokenMismatchException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Session expired. Please refresh the page and try again.',
                    'error' => 'token_mismatch',
                    'redirect' => route('login')
                ], 419);
            }

            // For web requests, redirect to login with message
            return redirect()->route('login')
                ->with('error', 'Your session has expired. Please login again.')
                ->withInput($request->except(['_token', 'password']));
        }
    }
}
