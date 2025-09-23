<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if (Auth::user()->level == 2) {
                return redirect('/kepegawaian/data_pegawai/profil');
            } else {
            return redirect(route('hai')); // Ganti dengan rute yang Anda inginkan
            }
        }else{
            return redirect(route('hai')); // Ganti dengan rute yang Anda inginkan

        }
    
        return $next($request);
    }
}
