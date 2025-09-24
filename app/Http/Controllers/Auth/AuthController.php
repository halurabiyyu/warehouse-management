<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Login successful');
        }

        return redirect()->back()->withErrors(['email' => 'Unauthorized']);
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Successfully logged out');
    }

    public function profile(){
        $user = Auth::user();

        return view('admin.profile.index', compact('user'));
    }
}
