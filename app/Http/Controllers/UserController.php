<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = User::find(1);
        $value = [];
        $user->options['result'] = $value;
        return response()->json($user, 200);
    }
}
