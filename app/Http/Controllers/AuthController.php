<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Function to handle user registration
    public function register(Request $request){
        // Validate user input
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:users',
            'password'=>'required|string|min:8|confirmed'
        ]);

        // If validation fails, return error response
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }

        // Create a new user in the database
        $user = User::create([
            'name'=>$request->get('name'),
            'email'=>$request->get('email'),
            'password'=>Hash::make($request->get('password'))
        ]);

        // Return a success response with user information
        return response()->json(
            [
                'message'=>'User successfully registered',
                'user'=>$user
            ],201
        );
    }

    // Function to handle user login
    public function login(Request $request){
        // Validate user login credentials
        $validator = Validator::make($request->all(),[
            'email'=>'required|string|email|max:255',
            'password'=>'required|string|min:8'
        ]);

        // If validation fails, return error response
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }

        // Attempt to log in the user and generate a token
        if($token = auth()->attempt($validator->validated())){
            return response()->json(
                [
                    'message'=>'Successful',
                    'token'=>$token
                ],201
            );
        }
        return $this->respondWithToken($token);
    }

    // Return token in a structured way
    protected function respondWithToken($token){
        return response()->json([
            'access_token'=>$token,
            'token_type'=>'bearer',
            'expires_in'=>auth()->factory()->getTTL()*60
        ]);
    }

    // Function to retrieve the currently authenticated user
    public function me(){
        return response()->json(auth()->user());
    }

    // Function to refresh the user's token
    public function refresh(){
        return $this->respondWithToken(auth()->refresh());
    }

    // Function to log the user out
    public function logout(){
        auth()->logout();
        return response()->json(['message'=>'User successfully logged out']);
    }

}
