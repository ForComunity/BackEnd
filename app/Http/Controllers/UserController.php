<?php

namespace App\Http\Controllers;

use App\Models\RegistToBeRescuedModel;
use App\Session;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\PayloadFactory;
use Tymon\JWTAuth\JWTManager as JWT;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        return response()->json($user->sortByDesc('id')->values(), 200);
    }
    public function register(Request $request){
        $validator = Validator::make($request->json()->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create([
            'name'=> $request->json()->get('name'),
            'email'=>$request->json()->get('email'),
            'password'=>Hash::make($request->json()->get('password')),
        ]);
        $token = JWTAuth::fromUser($user);
        return response()->json(compact('user','token'), 201);
    }

    public function login(Request $request){
        $credentials = $request->json()->all();
        try{
            if(! $token = JWTAuth::attempt($credentials)){
                return response()->json(['error'=>'Tài khoản mật khẩu không khớp'], 400);
            }
        }catch (JWTException $e){
            return response()->json(['error'=>'could not create token'], 500);
        }
        $user = User::where([
            'email' => $request->email
        ])->get();
        return response()->json(compact('user','token'));
    }



    public function getAuthenticatedUser(Request $request){
        $user = JWTAuth::toUser($request->token);
        return response()->json(['result' => $user]);
//        $user = Session::create($request->all());
//        return response()->json($user, 201);
    }
}

