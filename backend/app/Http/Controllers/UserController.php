<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\V1\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return $request->user();
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email','password']);
        if (Auth::attempt($credentials)){
            $token = $request->user()->createToken('app')->plainTextToken;;
            return [
                'user' => $request->user(),
                'token' => $token,
                'msg'=>'login success'
            ];
        }else{
            return ['msg'=>'用户名或密码错误'];
        }
    }
}
