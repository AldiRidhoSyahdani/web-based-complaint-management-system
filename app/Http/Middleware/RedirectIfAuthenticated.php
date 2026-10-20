<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {

            if (Auth::guard($guard)->check()) {

                // Jika sudah login sebagai admin → arahkan ke dashboard admin
                if ($guard === 'admin') {
                    return redirect()->route('admin.dashboard');
                }

                // Jika login sebagai user biasa → arahkan ke home
                return redirect('/home');
            }
        }

        return $next($request);
    }
}
