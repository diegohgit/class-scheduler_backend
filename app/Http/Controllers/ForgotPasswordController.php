<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function store(Request $request){

        $request->validate([
            //Don't validate if email exists in database
            //because it would give extra information to attackers.
            'email' => 'required|email',
        ]);

        //Generate a token and send via email a password reset link.
        Password::sendResetLink(
            $request->only('email')
        );

        return response()->json([
            'success' => true,
            'message' => 'If an account exists for that email address, 
                          a password reset link has been sent.'
        ]);
    }
}