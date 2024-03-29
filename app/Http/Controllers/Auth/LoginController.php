<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function login_page()
    {
        return view('auth.admin-login');
    }

    public function process_login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        $remember = false;
        if ($request->has('remember')) {
            $remember = true;
        }

        if (Auth::attempt($credentials, $remember)) {
            // do something after login
            return redirect()->route('admin.dashboard')->with('success', __('Login successful'));
        }

        return redirect()->back()->with('error', __('Something went wrong. Please try again'))->withInput();
    }
}