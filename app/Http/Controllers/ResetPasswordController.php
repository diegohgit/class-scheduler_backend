<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password as PasswordRules;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class ResetPasswordController extends Controller
{
    public function store(Request $request){

        $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => ['required', 'confirmed',
                            PasswordRules::min(8)
                                        ->mixedCase()
                                        ->numbers()
                                        ->symbols()],
        ]);

        $status = Password::reset(
            //Password::reset() validates this data before running
            //the callback functon.
            $request->only( 'email',
                            'password',
                            'password_confirmation',
                            'token'),

            function($user, $password){
                //forceFill() is to ignore the $fillable safety rules.
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                $user->tokens()->delete();
            }
        );

        if($status !== Password::PASSWORD_RESET){
            return response()->json(['message' => __($status), ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Your password has been reset successfully.',
        ]);
    }
}
