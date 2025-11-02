<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika sudah login via session, lanjutkan
        if (Auth::check()) {
            return $next($request);
        }

        // Auto login HANYA dari remember me cookies
        if ($request->cookie('remember_me')) {
            $rememberToken = $request->cookie('remember_me');
            $userId = $request->cookie('remember_user');
            
            $user = \App\Models\User::where('id', $userId)
                    ->where('remember_token', hash('sha256', $rememberToken))
                    ->first();
            
            if ($user) {
                Auth::login($user);
                \Log::info('Middleware: Auto-login from Remember Me cookies');
                return $next($request);
            } else {
                // Clear invalid cookies
                Cookie::queue(Cookie::forget('remember_me'));
                Cookie::queue(Cookie::forget('remember_user'));
            }
        }

        return redirect()->route('login');
    }
}