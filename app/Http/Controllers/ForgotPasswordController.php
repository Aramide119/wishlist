<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ForgotPassword;
use App\Mail\ResetPasswordEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{

    public function index() 
    {
        return view('user.auth.email');
    }
    public function viewotp() 
    {
        return view('user.auth.verify-otp');
    }
    public function sendResetEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email does not exist.');
        }

        // set token expiry date
        $expiry =  Carbon::now()->addMinutes(10);

        // Store the reset token in the forgot_passwords table
        $send_token = ForgotPassword::updateOrCreate([
            'email' => $user->email,
            'token' => random_int(1000, 9999),
            'expiry_date' => $expiry,
        ]);
        
        // Send the reset email to the user
        Mail::to($user->email)->send(new ResetPasswordEmail($send_token->token, $user));

        if ($user) {
            return view('user.auth.verify-otp');
        }else{
            return back()->with('error' ,'error');
        }

    }


    public function reset(Request $request)
    {

        $token = trim($request->token1) . trim($request->token2) . trim($request->token3) . trim($request->token4);


        $passwordReset = ForgotPassword::where('token', $token)->first();


        if (!$passwordReset) {
            return back()->withErrors(['token' => 'Invalid Reset Token'])->withInput();
        }
        $email = $passwordReset->email; // Accessing the email associated with this record

        $user = User::where('email', $email)->first();

        //check if token has expired
        $currentDate = Carbon::now();
        if($currentDate > $passwordReset->expiry_date){
            $expiry =  Carbon::now()->addMinutes(10);

        $send_token = ForgotPassword::updateOrCreate([
                'token' => random_int(1000, 9999),
                'email' => $user->email,
                'expiry_date' => $expiry,
            ]);        
            Mail::to($user->email)->send(new ResetPasswordEmail($send_token->token, $user));

            return back()->withErrors(['token' => 'Tokin expired, check your email for another token']);
        }

        return view('user.auth.reset-password', compact('user'));
    }


    public function passwordReset(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required|min:6',
        ]);
              // Find the email in the password_resets table
            $passwordReset = ForgotPassword::where('email', $request->email)->first();

            if (!$passwordReset) {
                return back()->with('error', 'Invalid email');
            }

            $user = User::where('email', $passwordReset->email)->first();

            // Update the user's password
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the password reset record
        $passwordReset->delete();

        return view('user.auth.login');
    }

}
