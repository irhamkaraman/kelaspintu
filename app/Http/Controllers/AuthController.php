<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'))->with('success', 'Berhasil login!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    // Google OAuth
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Check if this is account linking mode
            if (session('google_connect_mode') && Auth::check()) {
                $user = Auth::user();
                
                // Check if this Google ID is already used by another user
                $existingUser = User::where('google_id', $googleUser->id)->first();
                if ($existingUser && $existingUser->id !== $user->id) {
                    session()->forget('google_connect_mode');
                    return redirect()->route('profile.edit')
                        ->withErrors(['google' => 'Akun Google ini sudah terhubung dengan akun lain.']);
                }
                
                // Link Google account to current user
                $user->update(['google_id' => $googleUser->id]);
                session()->forget('google_connect_mode');
                
                return redirect()->route('profile.edit')
                    ->with('success', 'Akun Google berhasil dihubungkan!');
            }
            
            // Normal login/register flow
            $user = User::where('google_id', $googleUser->id)->first();

            if ($user) {
                // User exists, login
                Auth::login($user);
                return redirect()->intended(route('dashboard'))->with('success', 'Berhasil login dengan Google!');
            } else {
                // Check if email exists
                $user = User::where('email', $googleUser->email)->first();
                
                if ($user) {
                    // Update existing user with google_id
                    $user->update([
                        'google_id' => $googleUser->id,
                    ]);
                    Auth::login($user);
                    return redirect()->intended(route('dashboard'))->with('success', 'Akun berhasil ditautkan dengan Google!');
                } else {
                    // Create new user
                    $newUser = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'password' => Hash::make(Str::random(24)), // Random secure password
                    ]);
                    
                    Auth::login($newUser);
                    return redirect()->route('dashboard')->with('success', 'Registrasi berhasil dengan Google!');
                }
            }
        } catch (\Exception $e) {
            session()->forget('google_connect_mode');
            return redirect()->route('login')->withErrors(['email' => 'Gagal login dengan Google. Silakan coba lagi.']);
        }
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil! Selamat datang di KelasPintu.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login')->with('success', 'Berhasil logout.');
    }
}
