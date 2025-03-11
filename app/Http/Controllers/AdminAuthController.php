<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;



class AdminAuthController extends Controller
{
    public function register()
    {
        return Inertia::render('admin/auth/Register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if (config('services.admin_role.key') != $request->password) {
            return redirect('/');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),

        ]);

        $user->assignRole('admin');

        event(new Registered($user));

        Auth::login($user);

        return to_route('admin.dashboard');
    }

    public function login()
    {
        return Inertia::render('admin/auth/Login');
    }


    public function loginUser(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);



        $user = User::where('email', '=', $request->email)->first();

        if (!$user) {
            return redirect('/');
        }

        if ($user->hasRole('admin')) {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                return redirect()->intended('admin/dashboard');
            }

        }


        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');

    }
}
