<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $isSiswaLogin = filled($request->input('nis'));
        $identifier = $isSiswaLogin ? (string) $request->input('nis') : (string) $request->input('nip');

        $credentials = [
            'nip' => $identifier,
            'password' => (string) $request->input('password'),
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $role = Auth::user()?->role;
            $defaultRoute = $role === 'admin' ? route('admin.dashboard') : route('siswa.dashboard');

            return redirect()->intended($defaultRoute);
        }

        $errorField = $isSiswaLogin ? 'nis' : 'nip';
        $errorLabel = $isSiswaLogin ? 'NIS' : 'NIP';

        return back()
            ->withInput($request->except('password'))
            ->withErrors([$errorField => $errorLabel . ' atau Password salah!']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
