<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect('dashboard');
        }

        return view('auth.login');
    }

    public function registration()
    {
        if (Auth::check()) {
            return redirect('dashboard');
        }

        return view('auth.registration');
    }

    public function postLogin(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')->withSuccess('Anda berhasil masuk !');
        }

        return redirect('login')->withError('Ups!, Anda gagal masuk, silahkan gunakan email dan password yang benar !');
    }

    public function postRegistration(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);

        Auth::login($user);

        return redirect("dashboard")->withSuccess('Anda berhasil daftar dan masuk !');
    }

    public function dashboard()
    {
        // if (Auth::check()) {
        //     return view('dashboard');
        // }

        // return redirect('login')->withSuccess('Ups, Anda tidak mempunyai akses, silahkan masuk kembali!');

        return view('dashboard');
    }

    public function logout(): RedirectResponse
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }
}
