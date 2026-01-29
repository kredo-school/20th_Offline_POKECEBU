<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        //handle() - handles an incoming request
        //closure - $next is a function and calling it means continue to the next middleware/controller 
        if(Auth::check() && Auth::user()->role_id == User::ADMIN_ROLE_ID) {
            return $next($request);
        } 
        return redirect()->route('index');
    }
}