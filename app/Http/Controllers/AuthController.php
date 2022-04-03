<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function register(Request $request){
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users|email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        if($user){
            //$token = $user->createToken('myapptoken')->plainTextToken;

            return \response([
                'user' => $user,
                //'token' => $token
            ], 201);
        }

        return \response([
            'message' => 'Register failed!'
        ]);
    }

    public function login(Request $request){
        $fields = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        //Check if user exists
        $user = User::where('email', $fields['email'])->first();

        if(!$user){
            return response([
                'message' => 'User not found!'
            ], 200);
        }

        //Check password
        if(Hash::check($fields['password'], $user->password) === false){
            return response([
                'message' => 'Wrong password!'
            ], 200);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ], 201);


    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        return \response([
            'message' => 'Logged out'
        ]);
    }

    public function search(Request $request){
        try{
            $fields = $request->validate([
                'email' => 'required|string|email',
            ]);
        }catch(\Exception $exception){
            return \response(['found' => false]);
        }

        $user = User::where('email', $fields['email'])->first();

        if($user){
            return \response([
                    'found' => true,
                    'id'    => $user->id,
                    'name'  => $user->name
                ])->header('Access-Control-Allow-Origin', '*');

        }

        return \response(['found' => false]);
    }
}
