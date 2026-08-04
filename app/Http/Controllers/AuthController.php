<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function login(LoginRequest $request){
        $data = $request->validated();

        //Authenticate user
        if (!Auth::attempt($data)) {
            return response()->json([
                'message' => 'The provided credentials do not match our records.'
            ], 401);
        }

        //Prevent session fixation attacks.
        $request->session()->regenerate();

        return response()->json(Auth::user());
    }



    public function logout(Request $request){

        Auth::logout();

        //-Clear all session values and generate a brand-new Session ID.
        //-Refresh the CSRF token for security.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
        ]);
    }
}
