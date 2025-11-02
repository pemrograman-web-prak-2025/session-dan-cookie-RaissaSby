<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        $credentials = $this->credentials($request);
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
           
            if ($remember) {
                $user = Auth::user();
                $rememberToken = Str::random(60);
                
                $user->forceFill([
                    'remember_token' => hash('sha256', $rememberToken),
                ])->save();

               
                Cookie::queue('remember_me', $rememberToken, 43200);
                Cookie::queue('remember_user', $user->id, 43200);
                
                \Log::info('Remember Me: ENABLED - User will auto login for 30 days');
            } else {
                \Log::info('Remember Me: DISABLED - User must login manually after browser close');
            }

            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    public function showLoginForm(Request $request)
    {
        // Auto login HANYA dari cookies remember_me
        if (!Auth::check() && $request->cookie('remember_me')) {
            $rememberToken = $request->cookie('remember_me');
            $userId = $request->cookie('remember_user');
            
            $user = \App\Models\User::where('id', $userId)
                    ->where('remember_token', hash('sha256', $rememberToken))
                    ->first();
            
            if ($user) {
                Auth::login($user, true); // Login dengan remember
                
                \Log::info('Auto-login successful from Remember Me cookies');
                return redirect()->intended('/home');
            } else {
                // Clear invalid cookies
                Cookie::queue(Cookie::forget('remember_me'));
                Cookie::queue(Cookie::forget('remember_user'));
            }
        }

        return view('auth.login');
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->forceFill([
                'remember_token' => null,
            ])->save();
        }

        // Clear semua cookies remember me
        Cookie::queue(Cookie::forget('remember_me'));
        Cookie::queue(Cookie::forget('remember_user'));

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}