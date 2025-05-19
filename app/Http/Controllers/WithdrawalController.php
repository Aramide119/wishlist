<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use Illuminate\Http\Request;
use App\Models\UserBankDetail;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WithdrawalController extends Controller
{
public function withdrawFunds(Request $request)
{
    $request->headers->set('Accept', 'application/json'); // Add this line first

    try {
        $request->validate([
            'account_id' => 'required',
            'amount' => 'required|numeric|min:100',
        ]);

        $user = Auth::user();
        $account = UserBankDetail::where('id', $request->account_id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $totalwalletBalance = WalletTransaction::where('user_id', $user->id)
            ->where('type', 'credit')->sum('amount');

        $amountWithdrawn = WalletTransaction::where('user_id', $user->id)
            ->where('type', 'debit')->sum('amount');

        $walletBalance = $totalwalletBalance - $amountWithdrawn;

        if ($request->amount > $walletBalance) {
            return back()->with('error', 'Insufficient balance.');
        }

        DB::beginTransaction();

        $withdrawal = Withdrawal::create([
            'user_id' => $user->id,
            'account_id' => $account->id,
            'amount' => $request->amount,
            'status' => 'pending',
            'reference' => strtoupper(uniqid('WD-')),
        ]);

        DB::commit();

        return back()->with('success' , 'Withdrawal request submitted, you will be credited in the next 24 hours.');

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Withdrawal Error: ' . $e->getMessage());
        return back()->with('error' , 'Server error.');
    }
}

}
