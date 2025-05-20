<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\VerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ForgotPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    //
    public function index()
    {
        return view('user.auth.register');
    }

    public function viewLogin()
    {
        return view("user.auth.login");
    }

    public function viewEmail()
    {
        return view('user.auth.verify-email');
    }
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

         // Check if the user exists but is not verified
         $unverifiedUser = User::where('email', $request->email)->whereNull('email_verified_at')->first();
 
         if ($unverifiedUser) {
             // Check if the user has a VerifyUser record
             $verifyUser = ForgotPassword::where('email', $unverifiedUser->email)->first();
 
             if ($verifyUser) {
                 // Resend the existing verification email with the same token
                 $this->resendVerificationEmail($unverifiedUser, $verifyUser->token);
             } else {
                 // Generate a new token and resend the verification email
                 $this->sendVerificationEmail($unverifiedUser);
             }
 
             return Redirect()->route('verify.email')->withErrors(['error'=> 'This email already exists, a verification email has been resent.'])->withInput();
         }    
        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        $expiry =  Carbon::now()->addMinutes(5);
    
        $token = ForgotPassword::create([
            'token' => random_int(1000, 9999),
            'email' => $user->email,
            'expiry_date' => $expiry,
        ]);

        Mail::to($user->email)->send(new VerifyEmail($user, $token->token));
    
    
        return redirect()->route('verify.email')->with('success', 'A verification code has been sent into your email');
    }
    
       private function resendVerificationEmail(User $user, $token)
    {
        // Check if the user has a VerifyUser record
           $token = ForgotPassword::where('email', $user->email)
            ->latest('created_at')
            ->first();

        // If there is no VerifyUser record, return false
        if (!$token) {
            return false;
        }

        // Resend the existing verification email with the same token
        Mail::to($user->email)->send(new VerifyEmail($user, $token->token));

        return true;
    }


    protected function sendVerificationEmail($user)
    {
        try {
            $expiry =  Carbon::now()->addMinutes(5);
            // Generate a new VerifyUser record
            ForgotPassword::updateOrCreate([
                'token' => random_int(1000, 9999),
                'email' => $user->email,
                'expiry_date' => $expiry
            ]);
             
           $token = ForgotPassword::where('email', $user->email)
            ->latest('created_at')
            ->first();

            // Send the verification email
            Mail::to($user->email)->send(new VerifyEmail($user, $token->token));

            return true; 
        } catch (\Exception $e) {
            // Handle any exception, log, or return false based on your requirements
            return false;
        }
    }

        public function verifyEmail(Request $request)
    {
            $token = trim($request->token1) . trim($request->token2) . trim($request->token3) . trim($request->token4);

        // Find the corresponding VerifyUser record with the provided token
        $verifyUser = ForgotPassword::where('token', $token)->first();

        // Check if a matching VerifyUser record is found
        if ($verifyUser) {
            // Get the associated user model
            $user = User::where('email', $verifyUser->email)->first();

            // Check if token has expired
            $currentDate = Carbon::now();
            if ($currentDate > $verifyUser->expiry_date) {
                $expiry = Carbon::now()->addMinutes(5);

              $token =  ForgotPassword::updateOrCreate([
                    'token' => random_int(1000, 9999),
                    'user_id' => $user->id,
                    'expiry_date' => $expiry,
                ]);


                // Send email to user
                Mail::to($user->email)->send(new VerifyEmail($user, $token->token));

                return back()->withErrors(['error'=> 'Token Expired! Kindly check email for another token'])->withInput();
            }

            // Mark the user as verified
            $user->email_verified_at = now();
            $user->save();

            // Delete the VerifyUser record
            ForgotPassword::where('email', $verifyUser->email)->delete();

        return redirect()->route('login')->with('success', 'Registration successful! Please log in.');

        }
    }
    // User Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        $remember = $request->has('remember'); 
    
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            $request->session()->regenerate();
            return redirect()->route('wishlist')->with('success', 'Login successful!');
        }
    
        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }
    
    public function update(Request $request) {
        $user = auth()->user(); // Get the currently authenticated user

        // Validate incoming request
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'current_password' => 'nullable|required_with:new_password|string',
            'new_password' => 'nullable|string|confirmed',
        ]);
    
        // Update profile image if uploaded
        if ($request->hasFile('profile_picture')) {
            
            $file = $request->File('profile_picture');
                $requiredFileType = ['jpg','jpeg','png','gif'];
                $maxFileSize = '3145728';
                $path = "user/image";


                $filename   = $file->getClientOriginalName();
                $extension  = $file->getClientOriginalExtension();
                $size       = $file->getSize();
                $slugFilename =  Str::of($filename)->slug();
                $newFileName = $slugFilename . '.' . $extension;
            
                if (!in_array($extension, $requiredFileType)) {
                    $requiredFileTypeString = implode(",", $requiredFileType);
                    return redirect()->back()->with('error', "Unsupported File Format, Expecting". $requiredFileTypeString );
                }
            
                if ($maxFileSize && $size > $maxFileSize) {
                    
                    return redirect()->back()->with('error', "The maximum filesize requried is ". $maxFileSize );
                }
                // Delete previous image if it exists
                if ($user->profile_picture) {
                    $oldPath = public_path($user->profile_picture);
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                }
            $newPath = $file->move(public_path($path), $newFileName);
            $user->profile_picture = $newFileName;
        }
    
        // Update names
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
    
        // Handle password change
        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->with('error', 'Current password is incorrect');
            }
    
            $user->password = Hash::make($request->new_password);
        }
    
        $user->save();
    
        return back()->with('success', 'Profile updated successfully.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logged out successfully.');
    }
}
