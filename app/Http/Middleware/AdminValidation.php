<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class AdminValidation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Session::get('users');
        $usertype = $user->usertype ?? 0;

        if ($usertype == '1') {
            return $next($request);
        }
        else {
            return redirect('admin/login')->with('Failed', 'Please Login');
        }
    }
}
