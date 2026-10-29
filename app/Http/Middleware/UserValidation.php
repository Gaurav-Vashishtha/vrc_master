<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class UserValidation
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user session exists
        if (!Session::has('users')) {
            return redirect('/user/login')
                ->with('flash_error', 'Please login first.');
        }

        $user = Session::get('users');

        // Check user type (change this value if your project uses a different user type)
        if ($user->usertype != 3) {
            Session::forget('users');

            return redirect('/user/login')
                ->with('flash_error', 'Unauthorized access.');
        }

        return $next($request);
    }
}