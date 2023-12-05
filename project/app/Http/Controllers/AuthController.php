<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $req)
        {
            $rules = 
                [
                    'name'=>'required|string|max:255',
                     'email' => 'required|email',
                     'password'=>'required|min:6'

                ];

            $validateUser = Validator::make($req->all(), $rules);

            if($validateUser->fails())
                {
                    return response()->json(['message'=>'Invalid input']);
                }
            else{
                 $user = User::create([
                    'name'=>$req->name,
                    'email'=>$req->email,
                    'password'=>Hash::make($req->password)
                ]);
            }
            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200); 
            
            
        }

    public function login(Request $req)
        {
            $rules = [
                'email'=>'required|email',
                 'password'=>'required'
            ];

            $authenticatedUser = Validator::make($req->all(), $rules);

            if($authenticatedUser->fails())
                {
                    return response()->json(['message'=>'Invalid Credentials','status'=>401]);
                }

             $user = User::where('email',$req->email)->first();
             if ($user && Hash::check($req->password, $user->password)) {
                // Authentication successful
                $token = $user->createToken('API TOKEN')->plainTextToken;
        
                return response()->json([
                    'status' => true,
                    'message' => 'User logged in successfully',
                    'token' => $token,
                ], 200);
            }
            else{
                return response()->json(['message'=>'User not found']);
            }
                
        }
        
        public function logout(Request $req)
        {
            $user = $req->user();

            
            if ($req->token === $user->currentAccessToken()->plainTextToken) {
                $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        
                return response()->json([
                    'status' => true,
                    'message' => 'User logged out successfully',
                ], 200);
            }
        
            return response()->json([
                'status' => false,
                'message' => 'Invalid token provided',
            ], 401);
        
          
        }    
}
