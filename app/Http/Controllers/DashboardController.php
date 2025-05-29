<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Wishlist;
use App\Models\Withdrawal;
use App\Models\ReserveItem;
use Illuminate\Http\Request;
use App\Models\UserBankDetail;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $id = Auth::id();
        $user = Auth::user();
        $wishlists = Wishlist::where('user_id', $id)
            ->withCount('items')
            ->get();
        $withdrawals = Withdrawal::with('user', 'bankAccount')->where('user_id', $id)->get();
            // Sum of ReserveItem amounts for current user's wishlists
        $totalwalletBalance = WalletTransaction::where('user_id', $id)->where('type', 'credit')->where('status', 'successful')->sum('amount');
        
        $amountWithdrawn = WalletTransaction::where('user_id', $id)->where('type', 'debit')->where('status', 'successful')->sum('amount');
        $currentBalance = $totalwalletBalance- $amountWithdrawn;
            $reserved = ReserveItem::with(['item', 'money'])->where('status', 'successful')
            ->whereHas('money.wishlist', function ($query) use ($id) {
                $query->where('user_id', $id);
            })
            ->orWhereHas('item.wishlist', function ($query) use ($id) {
                $query->where('user_id', $id);
            })
            ->get();
        // dd($reserved);
        return view('user.dashboard.index', compact('wishlists', 'user', 'totalwalletBalance', 'reserved', 'amountWithdrawn', 'currentBalance', 'withdrawals'));
    }
}
