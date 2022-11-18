<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store()
    {
        request()->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'password' => 'required|max:255|confirmed',
        ]);

        User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => password_hash(request('password'), PASSWORD_DEFAULT),
        ]);
        return redirect()->route('users.index')->with('success', 'Data desa berhasil dimasukkan!');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit', [
            'user' => $user,
        ]);
    }

    public function update($id)
    {
        $user = User::find($id);
        request()->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'password' => 'confirmed',
        ]);
        $user->update([
            'name' => request('name'),
            'email' => request('email'),
            'password' => request('password') ? password_hash(request('password'), PASSWORD_DEFAULT) : $user->password,
        ]);
        return redirect()->route('users.index')->with('success', 'Data desa berhasil dimasukkan!');
    }
}
