<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
       if (!Auth::check() || !in_array(Auth::user()->role, $roles)) {
          Auth::logout(); // log them out if role is invalid
        return redirect()->route('login')->with('error', 'Access denied or login expired.');
}

        return $next($request);
    }
}