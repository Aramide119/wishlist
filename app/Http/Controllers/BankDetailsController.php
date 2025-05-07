<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserBankDetail;
use Illuminate\Support\Facades\Auth;

class BankDetailsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return response()->json($user->bankAccounts);

    }

    public function store(Request $request)
{
    $request->validate([
        'bank_name_text' => 'required|string',
        'account_number' => 'required|string',
        'account_name' => 'required|string',
    ]);

    UserBankDetail::create([
        'user_id' => auth()->id(),
        'bank_name' => $request->bank_name_text,
        'account_number' => $request->account_number,
        'account_name' => $request->account_name,
    ]);

    return response()->json(['success' => true]);
}

}
