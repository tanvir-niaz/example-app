<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function register(Request $request){
        $incomingFields=$request->validate([
            'name'=>['required','string'],
            'email'=>['required','email'],
            'password'=>['required','min:6','max:12'],
        ]);
        $user = User::create([
            'name' => $incomingFields['name'],
            'email' => $incomingFields['email'],
            'password' => bcrypt($incomingFields['password']),
        ]);
        return response()->json($user,201);
    }


    public function signin(Request $request)
        {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                return response()->json([
                    'message' => 'Sign in successful',
                    'user' => $user,
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Invalid email or password',
                ], 401);
            }
        }

}
