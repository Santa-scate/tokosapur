<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller; // PENTING
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UserController extends Controller // PENTING
{
    /**
     * Terapkan policy ke semua method resource secara otomatis.
     */
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }
    /**
     * Menampilkan daftar semua user.
     */
    public function index()
    {

        $users = User::where('id', '!=', auth()->id())->latest()->paginate(10);
        return view('users.index', compact('users'));
    }


    /**
     * Menampilkan form untuk membuat user baru.
     */
    public function create()
    {

        return view('users.create');
    }


    /**
     * Menyimpan user baru ke database.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'string', Rule::in(['admin', 'kasir'])],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit user.
     */

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'string', Rule::in(['admin', 'kasir'])],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $userData = $request->only('name', 'email', 'role');

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    /**
     * Menghapus user dari database.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}

