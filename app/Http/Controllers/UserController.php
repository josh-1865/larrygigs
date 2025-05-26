<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //show register form
    public function register()
    {
        return view('users.register');
    }
    // create new user
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        //hash password

        $validatedData['password'] = bcrypt($validatedData['password']);
        //create user

        $user = User::create($validatedData);

        //login user
        Auth::login($user);


        //redirect
        return redirect('/')->with('message', 'User created and logged in successfully!');
    }
    //logout user
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        //redirect

        return redirect('/')->with('message', 'You have been logged out!');
    }
    //show login form
    public function login(Request $request)
    {
        return view('users.login');
    }
    //login user
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Authentication passed...
            return redirect('/')->with('message', 'You are logged in!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
