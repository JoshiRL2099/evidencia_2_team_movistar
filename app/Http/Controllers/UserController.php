<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->orderBy('full_name')->get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::orderBy('name')->get();

        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
            'role_id' => ['required', 'exists:roles,role_id'],
        ]);

        User::create([
            'username' => $data['username'],
            'password_hash' => Hash::make($data['password']),
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'is_active' => $request->boolean('is_active'),
            'role_id' => $data['role_id'],
            'created_at' => now(),
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function show(string $id)
    {
        $user = User::with('role')->findOrFail($id);

        return view('users.show', compact('user'));
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $roles = Role::orderBy('name')->get();

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $id . ',user_id'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
            'role_id' => ['required', 'exists:roles,role_id'],
        ]);

        $user->username = $data['username'];
        $user->full_name = $data['full_name'];
        $user->email = $data['email'];
        $user->is_active = $request->boolean('is_active');
        $user->role_id = $data['role_id'];

        if (!empty($data['password'])) {
            $user->password_hash = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }
}