<?php

namespace App\Http\Controllers;

use App\Models\ReserveItem;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserBankDetail;
use App\Models\WalletTransaction;
use DB;

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
            // Sum of ReserveItem amounts for current user's wishlists
        $totalwalletBalance = WalletTransaction::where('user_id', $id)->where('type', 'credit')->sum('amount');
        
        $amountWithdrawn = WalletTransaction::where('user_id', $id)->where('type', 'debit')->sum('amount');
        $currentBalance = $totalwalletBalance- $amountWithdrawn;
            $reserved = ReserveItem::with(['item', 'money.wishlist'])
            ->whereHas('money.wishlist', function ($query) use ($id) {
                $query->where('user_id', $id);
            })
            ->orWhereHas('item.wishlist', function ($query) use ($id) {
                $query->where('user_id', $id);
            })
            ->get();
        
        // dd($reserved);
        return view('user.dashboard.index', compact('wishlists', 'user', 'totalwalletBalance', 'reserved', 'amountWithdrawn', 'currentBalance'));
    }
}
