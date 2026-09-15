<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function store(ResetPasswordRequest $request){

        $validData = $request->validated();

        $status = Password::reset(
            $validData,
            function($user, $password){
                //forceFill() is used to ignore the $fillable safety rules.
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
