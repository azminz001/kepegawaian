<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionTimeoutMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && $request->session()->has('lastActivityTime')) {
            $timeout = config('session.lifetime') * 60; // Konversi dari menit ke detik
            $lastActivity = $request->session()->get('lastActivityTime');

            if (time() - $lastActivity > $timeout) {
                Auth::logout();
                $request->session()->flush(); // Hapus semua data sesi
                return redirect()->route('kepegawaian.login.post')->with('message', 'Your session has expired, please login again.');
            }
        }

        $request->session()->put('lastActivityTime', time());

        return $next($request);
    }
}
