<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;

class AdminController extends Controller
{
    public function login(Request $request) {
        $credentials = $request->json()->all();

        try {
            if(! $token = JWTAuth::attempt($credentials)){
                    return response()->json(['error'=>'Số điện thoại hoặc mật khẩu không đúng'], 400);
            }
        }catch (JWTException $e){
            return response()->json(['error'=>'could_not_create_token'], 500);
        }

        if (auth()->user()->role == 'admin'){
            return response()->json(compact('token'));
        }
        return response()->json(['error' => 'Số điện thoại hoặc mật khẩu không đúng'], 400);
    }

    public function logout() {
        auth()->logout();
    }

    public function getAuthenticatedUser(){
        try {
            $user = auth()->userOrFail();
            return response()->json($user, 200);
        } catch (UserNotDefinedException $e) {
            return response()->json(["error" => "Unauthenticated"], 401);
        }
    }
}
