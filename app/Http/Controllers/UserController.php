<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Tambahkan method index ini
    public function index(Request $request)
    {
        return $this->handle($request);
    }
    
    public function handle(Request $request, $userId = null)
    {
        if ($request->isMethod('get')) {
            $users = User::all();
            return view('user', compact('users'));
        }

        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8|confirmed',
                'role' => ['required', Rule::in(['admin', 'petugas', 'user'])],
            ]);
    
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
            ]);
    
            if ($user) {
                return back()->with('success', 'User berhasil ditambahkan.');
            } else {
                return back()->with('error', 'Terjadi kesalahan saat menambahkan user.');
            }
        }

        if ($request->isMethod('put') && $userId) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $userId,
                'password' => 'nullable|min:8|confirmed',
                'role' => ['required', Rule::in(['admin', 'petugas', 'user'])],
            ]);

            $user = User::findOrFail($userId);

            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            $user->role = $request->role;

            if ($user->save()) {
                return back()->with('success', 'User berhasil diperbarui.');
            } else {
                return back()->with('error', 'Terjadi kesalahan saat memperbarui user.');
            }
        }

        if ($request->isMethod('delete') && $userId) {
            try {
                $user = User::findOrFail($userId);
                $user->delete();
                return back()->with('success', 'User berhasil dihapus.');
            } catch (\Exception $e) {
                return back()->with('error', 'Terjadi kesalahan saat menghapus user.');
            }
        }

        return back()->with('error', 'Aksi tidak diizinkan.');
    }
}