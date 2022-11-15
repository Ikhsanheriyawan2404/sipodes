<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\{Auth, Hash};

class AuthController extends Controller
{
    public function login()
    {
        $validator = Validator::make(request()->all(),[
            'email' => 'required|string|email|max:255',
            'password' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json(new ApiResource(401, false, $validator->errors()), 422);
        }

        if (!auth()->attempt(request()->only('email', 'password'))) {
            return response()->json(new ApiResource(401, false, 'Gagal. email/password salah!'), 401);
        }

        $token = auth()->user()->createToken('auth_token')->plainTextToken;

        $data = [
            'token' => $token,
            'user' => auth()->user(),
        ];

        return new ApiResource(200, true, 'Berhasil login.', $data);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return new ApiResource(200, true, 'Berhasil logout.');
    }
}
