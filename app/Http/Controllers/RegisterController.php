<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /**
     * Menampilkan form registrasi
     */
    public function showRegistrationForm()
    {
        // Coba cek apakah view register ada di folder auth
        if (view()->exists('auth.register')) {
            return view('auth.register');
        }
        
        // Jika tidak, coba view register langsung
        return view('register');
    }

    /**
     * Memproses registrasi user baru
     */
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            // Buat user baru dengan role 'user'
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user',
            ]);

            // Login otomatis
            Auth::login($user);

            // Redirect ke dashboard
            return redirect()->route('dashboard')->with('success', 'Registrasi berhasil! Selamat datang ' . $user->name);

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Registrasi gagal: ' . $e->getMessage());
        }
    }
}