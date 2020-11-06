<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use \Tymon\JWTAuth\Exceptions\UserNotDefinedException;

use App\User;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->json()->all(), [
                'phone' => ['required', 'numeric', 'unique:users'],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:8'],
            ]);

            if($validator->fails()){
                return response()->json($validator->errors()/*->toJson()*/, 400);
            }

            $user = User::create([
                'phone' => $request->json()->get('phone'),
                'name' => $request->json()->get('name'),
                'email' => $request->json()->get('email'),
                'password' => Hash::make($request->json()->get('password')),
            ]);

            $token = JWTAuth::fromUser($user);

            return response()->json(compact('user','token'), 201);

    }

    public function login(Request $request){
        $credentials = $request->json()->all();

        try {
            if(! $token = JWTAuth::attempt($credentials)){
                return response()->json(['error'=>'Số điện thoại hoặc mật khẩu không đúng'], 400);
            }
        }catch (JWTException $e){
            return response()->json(['error'=>'could_not_create_token'], 500);
        }

        return response()->json([
            'token' => $token
        ]);

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
