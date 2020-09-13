<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('my_login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            session()->forget('currency_type');
            return redirect('menu');
        }
        return back()->withErrors(['login' => 'failed']);
    }

    public function showRegister()
    {
        return view('my_register');
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        auth()->login($user);
        session()->forget('currency_type');

        return redirect(route('menu'));
    }

    public function logout()
    {
        auth()->logout();

        return back();
    }
}
