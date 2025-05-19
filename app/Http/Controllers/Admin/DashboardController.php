<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    //
        //
    public function index()
    {
        $wishlistCount= Wishlist::count();
        $userCount = User::count();
        $revenue = WalletTransaction::where('type', 'credit')->sum('amount');
        $users = User::latest()->take(10)->get();
        $usersByMonth = User::select(
                DB::raw("COUNT(*) as count"),
                DB::raw("MONTHNAME(created_at) as month")
            )
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy(DB::raw("MONTH(created_at)"), DB::raw("MONTHNAME(created_at)"))
            ->orderBy(DB::raw("MONTH(created_at)"))
            ->get();

            // Separate into two arrays for the chart
            $months = $usersByMonth->pluck('month');
            $counts = $usersByMonth->pluck('count');
    
    return view('admin.index', compact('wishlistCount', 'userCount','revenue', 'users', 'months', 'counts'));
    }

    public function wishlist()
    {

        $wishlists = Wishlist::with('user')->get();
        
        return view('admin.wishlist', compact('$wishlists'));
    }

    public function user()
    {
       
        $users = User::get();
         
        return view('admin.user', compact('users')); 
    }
}
