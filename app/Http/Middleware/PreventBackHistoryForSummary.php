<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PreventBackHistoryForSummary
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is trying to access summary page without proper flow
        if ($request->route()->named('reservation.summary')) {
            $allowedReferrers = ['/reservation-confirm', '/reservation-payment']; // Add your actual routes
            
            if (!Session::get('can_access_summary') && !in_array($request->header('referer'), $allowedReferrers)) {
                return redirect()->route('home')->with('error', 'Invalid access attempt.');
            }
        }

        $response = $next($request);

        // Set session flag when user properly accesses summary
        if ($request->route()->named('reservation.summary')) {
            Session::put('can_access_summary', true);
        }

        return $response->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    }
}