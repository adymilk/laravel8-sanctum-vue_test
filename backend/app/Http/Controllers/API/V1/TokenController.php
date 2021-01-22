<?php


namespace App\Http\Controllers\API\V1;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokenController extends BaseController
{
    public function create(Request $request)
    {
        $credentials = $request->only(['email','password']);
        if (Auth::attempt($credentials)){
            $token = $request->user()->createToken($request->email);
            return $this->sendResponse(['token' => $token->plainTextToken],'success!');
        }else{
            return $this->unauthorizedResponse();
        }
    }
}
