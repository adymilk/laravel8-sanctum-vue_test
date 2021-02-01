<?php


namespace App\Http\Controllers;

use App\Http\Controllers\API\V1\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokenController extends BaseController
{
    public function index()
    {
        return view('tokens.index');
    }

    public function create(Request $request)
    {
        $credentials = $request->only(['email','password']);
        if (Auth::attempt($credentials)){
            $token = $request->user()->createToken($request->email)->plainTextToken;;
            $response = [
                'user' => $request->user(),
                'token' => $token
            ];
            return $this->sendResponse($response,'is login in');
        }else{
            return $this->unauthorizedResponse('Login error,Please checked.');
        }

    }


    public function store(Request $request)
    {
        $user  = $request->user();
        $token = $user->createToken('token-name');
        return $user;
    }


}
