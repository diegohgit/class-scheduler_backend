<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function store(ResetPasswordRequest $request){

        $validData = $request->validated();

        $resetUser = null;

        $status = Password::reset(
            $validData,
            function($user, $password) use (&$resetUser) {
                //forceFill() is used to ignore the $fillable safety rules.
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                $user->tokens()->delete();

                $resetUser = $user;
            }
        );

        if($status !== Password::PASSWORD_RESET){
            return response()->json(['message' => __($status), ], 422);
        }

        //Start user's session after resetting their password.
        Auth::login($resetUser);
        request()->session()->regenerate();

        return response()->json([
            'success' => true,
            'message' => 'Your password has been reset successfully.',
        ]);
    }
}
