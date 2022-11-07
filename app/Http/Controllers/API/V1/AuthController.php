<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\{Auth, Hash};

class AuthController extends Controller
{
    public function register()
    {
        $validator = Validator::make(request()->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => Hash::make(request('password'))
         ]);

        $token = $user->createToken('token')->plainTextToken;
        $data = [
            'token' => $token,
            'user' => auth()->user(),
        ];
        return new ApiResource(true, 'Berhasil daftar.', $data);
    }

    public function login()
    {
        if (!auth()->attempt(request()->only('email', 'password'))) {
            return response()->json(new ApiResource(true, 'Gagal. email/password salah!'), 401);
        }

        $token = auth()->user()->createToken('auth_token')->plainTextToken;

        $data = [
            'token' => $token,
            'user' => auth()->user(),
        ];

        return new ApiResource(true, 'Berhasil login.', $data);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return new ApiResource(true, 'Berhasil logout.');
    }
}
