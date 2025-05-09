<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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
    
        User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
    
        return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
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


    // Forgot Password
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Password reset link sent'], 200)
            : response()->json(['error' => 'Error sending password reset link'], 400);
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
