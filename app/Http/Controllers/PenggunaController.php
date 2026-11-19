<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function index()
    {
        $pengguna = User::latest()->paginate(20);

        return view('pengguna.index', compact('pengguna'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:admin,user',
            'is_active' => 'required|boolean',
        ]);

        if ($request->user()->is($user) && ($validated['role'] !== 'admin' || ! $validated['is_active'])) {
            return back()->with('error', 'Admin tidak dapat menonaktifkan atau mengubah role akunnya sendiri.');
        }

        $user->update($validated);

        return back()->with('success', 'Akses akun diperbarui.');
    }
}