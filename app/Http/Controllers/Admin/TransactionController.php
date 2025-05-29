<?php

namespace App\Http\Controllers\Admin;

use App\Models\Withdrawal;
use Illuminate\Http\Request;
use App\Models\WalletTransaction;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    //

    public function index()
    {
        $transactions = WalletTransaction::with('user', 'withdrawal', 'reserveItem', 'withdrawal.bankAccount', 'reserveItem.money.wishlist')->get();
        // dd($transactions);
        return view('admin.transactions.index', compact('transactions'));

    }
    public function withdraw()
    {
        $allWithdrawals = Withdrawal::with('user', 'bankAccount')->latest()->get();

        foreach ($allWithdrawals as $withdrawal) {
            $userId = $withdrawal->user_id;

            $totalCredit = WalletTransaction::where('user_id', $userId)
                ->where('type', 'credit')
                ->where('status', 'successful')
                ->sum('amount');

            $totalDebit = WalletTransaction::where('user_id', $userId)
                ->where('type', 'debit')
                ->where('status', 'successful')
                ->sum('amount');

            $withdrawal->user->wallet_balance = $totalCredit - $totalDebit;
        }

        $pending = $allWithdrawals->where('status', 'pending');
        $successful = $allWithdrawals->where('status', 'successful');
        $declined = $allWithdrawals->where('status', 'declined');

        return view('admin.transactions.withdrawal', compact('pending', 'successful', 'declined'));
    }


    public function updateStatus(Request $request, $id)
    {
        
        $withdrawal = Withdrawal::where('id', $id)->update([
            'status' => $request->input('status')
        ]);

                // Store the pending transaction
        WalletTransaction::where('withdrawal_id', $id)->update([
            'status' => $request->input('status')
        ]);
        return back()->with('success' , 'Request Updated Successfully');

    }

}
