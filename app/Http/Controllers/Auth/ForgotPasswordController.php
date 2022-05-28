<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function CreateResetPasswordCode(Request $request)
    {
        $user=User::where("email",$request->email)->orWhere("phone",$request->email)->first();
        if($user){
             $user->forget_password_code=Str::random(10);
             $user->save();
             return 1;
        }
        else{
            return 0;
        }
    }
}
