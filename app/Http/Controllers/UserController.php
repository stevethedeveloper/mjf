<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

// These are the JWT middleware
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

// Custom trait for getting user information from JWT token
use App\Traits\JWTCheck;

class UserController extends Controller
{

    // Custom trait for getting user information from JWT token
    use JWTCheck;

    /**
     * 
     * Attempt authentication based on user input and return JWT token
     * 
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }

    /**
     * 
     * Register a new user
     * 
     */
    public function register(Request $request)
    {
            $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user','token'),201);
    }

    /**
     * 
     * Get current logged in user using the custom JWTCheck trait
     * 
     */
    public function getAuthenticatedUser() {
        $user = $this->checkJwt();

        return response()->json(compact('user'));
    }
}
