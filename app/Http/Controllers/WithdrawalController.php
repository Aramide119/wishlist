<?php

namespace App\Http\Controllers;

use App\Models\UserBankDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Withdrawal;

class WithdrawalController extends Controller
{
    //
    public function withdrawFunds(Request $request)
{
    $request->validate([
        'account_id' => 'required|exists:user_accounts,id',
        'amount' => 'required|numeric|min:100', // You can set min withdrawal limit
    ]);

    $user = Auth::user();
    $account = UserBankDetail::where('id', $request->account_id)
        ->where('user_id', $user->id)
        ->firstOrFail();

    $walletBalance = $user->wallet_balance; // Assume you store this on users table

    if ($request->amount > $walletBalance) {
        return response()->json(['success' => false, 'message' => 'Insufficient balance.'], 422);
    }

    DB::beginTransaction();

    try {
        // Deduct from wallet
        $user->wallet_balance -= $request->amount;
        $user->save();

        // Create withdrawal record
        $withdrawal = Withdrawal::create([
            'user_id' => $user->id,
            'account_id' => $account->id,
            'amount' => $request->amount,
            'transfer_fee' => 0, // if applicable
            'status' => 'pending',
            'reference' => strtoupper(uniqid('WD-')),
        ]);

        DB::commit();

        return response()->json(['success' => true, 'message' => 'Withdrawal request submitted.', 'withdrawal' => $withdrawal]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['success' => false, 'message' => 'Failed to process withdrawal.', 'error' => $e->getMessage()], 500);
    }
}
}
