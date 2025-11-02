<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
    
        if (!Auth::check() && request()->cookie('remember_me')) {
            $rememberToken = request()->cookie('remember_me');
            $userId = request()->cookie('remember_user');
            
            $user = User::where('id', $userId)
                    ->where('remember_token', hash('sha256', $rememberToken))
                    ->first();
            
            if ($user) {
                Auth::login($user);
                \Log::info('Auto-login from Remember Me cookies');
                return redirect()->route('dashboard');
            } else {
                Cookie::queue(Cookie::forget('remember_me'));
                Cookie::queue(Cookie::forget('remember_user'));
            }
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $remember = $request->has('remember');

        // LOG untuk debugging
        \Log::info('Login attempt', [
            'remember_checked' => $remember,
            'email' => $request->email
        ]);

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            if ($remember) {
                $user = Auth::user();
                $rememberToken = Str::random(60);
                
                $user->forceFill([
                    'remember_token' => hash('sha256', $rememberToken),
                ])->save();

                Cookie::queue('remember_me', $rememberToken, 43200); // 
                Cookie::queue('remember_user', $user->id, 43200);
                
                \Log::info('Remember Me ENABLED - Cookies set for 30 days');
            } else {
                \Log::info('Remember Me DISABLED - Only session (will expire on browser close)');
                

                Cookie::queue(Cookie::forget('remember_me'));
                Cookie::queue(Cookie::forget('remember_user'));
            }

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->forceFill([
                'remember_token' => null,
            ])->save();
        }

        // Clear semua cookies
        Cookie::queue(Cookie::forget('remember_me'));
        Cookie::queue(Cookie::forget('remember_user'));

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
}