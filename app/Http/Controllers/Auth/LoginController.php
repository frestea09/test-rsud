<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('/admin/login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Jika login berhasil, redirect ke halaman yang diinginkan
                $users = User::all(); // Mengambil semua data pengguna dari database

            return view('/dashboard',['users'=> $users]);
        }

        // Jika login gagal, kembali ke form login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}
