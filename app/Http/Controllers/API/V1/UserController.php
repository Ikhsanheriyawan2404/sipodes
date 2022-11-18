<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json(new ApiResource(200, true, 'Data Users', $users), 200);
    }

    public function store()
    {
        request()->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'password' => 'required|max:255|confirmed',
        ]);

        $data = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => password_hash(request('password'), PASSWORD_DEFAULT),
        ]);
        return redirect()->route('users.index')->with('success', 'Data desa berhasil dimasukkan!', $data);
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
