<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Return view for login
     *
     * @return Application|Factory|View
     */
    public function showLogin()
    {
        return view('my_login');
    }

    /**
     * Trying to log user in
     *
     * @param LoginRequest $request
     * @return Application|RedirectResponse|Redirector
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            session()->forget('currency_type');

            return redirect('menu');
        }

        return back()->withErrors(['login' => 'failed']);
    }

    /**
     * Return view for registration
     *
     * @return Application|Factory|View
     */
    public function showRegister()
    {
        return view('my_register');
    }

    /**
     * Creating a new user
     *
     * @param RegisterRequest $request
     * @return Application|RedirectResponse|Redirector
     */
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

    /**
     * Log user out
     *
     * @return RedirectResponse
     */
    public function logout()
    {
        auth()->logout();

        return back();
    }
}
