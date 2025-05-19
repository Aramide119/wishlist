<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    //
    public function index()
    {
        $id = Auth('admin')->id();
        $admin = Admin::Where('id', $id)->first();
        return view('admin.setting', compact('admin'));
    }

    public function store(Request $request)
    {
        $id = Auth('admin')->id();
        $admin = Admin::Where('id', $id)->first();
        $admin->password = Hash::make($request->password);
        $admin->save();

        return back()->with('message', 'Profile updated Successfully');

    }
}
