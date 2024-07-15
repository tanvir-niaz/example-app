<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; 
class UserController extends Controller
{
    //
    public function register(Request $request) {
        $incomingFields = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6', 'confirmed'],
            'password_confirmation' => ['required']
        ]);

        if ($incomingFields->fails()) {
            return response()->json($incomingFields->messages(), 400);
        }

        $validatedData = $incomingFields->validated();

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);
        $token=$user->createToken("auth_token")->accessToken;


        return response()->json(['token'=>$token,'user'=>$user], 201);
    }


    public function login(Request $request)
        {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token=$user->createToken("auth_token")->accessToken;
                return response()->json([
                    'message' => 'Sign in successful',
                    'token'=>$token,
                    'user' => $user,
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Invalid email or password',
                ], 401);
            }
        }
    
    public function getUserById($id){
        $user=User::find($id);
        if(is_null($user)){
            return response()->json([
                'message'=>"Id not found",
            ],401);
        }
        return response()->json(['user'=>$user],200);
    }

}
