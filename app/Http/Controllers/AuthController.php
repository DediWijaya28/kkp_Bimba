<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Log only non-sensitive metadata (never log passwords or full user objects)
        \Illuminate\Support\Facades\Log::info('Login attempt', ['email' => $credentials['email'], 'remember' => $request->boolean('remember')]);

        $user = User::where('email', $credentials['email'])->first();
        $hashCheck = $user ? Hash::check($credentials['password'], $user->password) : false;
        $authAttempt = Auth::attempt($credentials, $request->boolean('remember'));

        \Illuminate\Support\Facades\Log::info('Login debug', [
            'user_found' => !!$user,
            'user_id' => $user ? $user->id : null,
            'hash_check' => $hashCheck,
            'auth_attempt' => $authAttempt,
        ]);

        if ($authAttempt) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        \Illuminate\Support\Facades\Log::warning('Login failed', [
            'email' => $credentials['email'],
            'user_found' => !!$user,
            'hash_check' => $hashCheck,
            'auth_attempt' => $authAttempt,
        ]);

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create([
            'name' => ucwords(strtolower($validated['name'])),
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'parent',
        ]);

        Auth::login($user);

        return redirect()->route('registration.create')->with('success', 'Registration successful! Please fill in your child\'s information.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    // Password Reset Methods
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // We will just simulate it for now if no mailer is configured, 
        // or rely on standard Password Facade if they have it setup.
        
        $status = \Illuminate\Support\Facades\Password::sendResetLink($request->only('email'));

        return $status === \Illuminate\Support\Facades\Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = \Illuminate\Support\Facades\Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new \Illuminate\Auth\Events\PasswordReset($user));
            }
        );

        return $status === \Illuminate\Support\Facades\Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
}
