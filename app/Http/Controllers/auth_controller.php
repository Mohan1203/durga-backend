<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class auth_controller 
{
    public function show_login(){
        return view('admin.login');
    }
    public function handle_login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        // dd($request->all());
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        return back()->withErrors([
            'email' => 'Wrong email or password',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}