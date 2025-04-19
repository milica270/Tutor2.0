<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(){
        return Inertia::render('Auth/Register');
    }

    public function store(Request $request) { 
        

        $fields = $request->validate([
            'avatar' => ['file', 'nullable', 'max:300'],
            'name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'grade' => ['required', 'min:1', 'max:4'],
            'major_id' => ['required', 'min:1', 'max:3'],
            'email'=> ['required','email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed'],
        ]);

        if($request->hasFile('avatar')) {
            $fields['avatar'] = $request->file('avatar')->store('avatars', 'public');
            //$fileds['avatar'] = Storage::disk('public')->put('avatars',$request->avatar);
        }

        $user = User::create($fields);
        Auth::login($user);

        return redirect()->route('dashboard');

    }

    public function login() {
        return Inertia::render('Auth/Login');
    }

    public function authenticate(Request $request) {
        $fields = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if(Auth::attempt($fields, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records',
        ])->onlyInput('email');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

}
