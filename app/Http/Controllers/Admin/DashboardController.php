<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ReserveItem;

class DashboardController extends Controller
{
    //
        //
    public function index()
    {
        $wishlistCount= Wishlist::count();
        $userCount = User::count();
        $revenue = ReserveItem::sum('amount');
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
    $users = User::with(['wishlists' => function ($query) {
        $query->latest(); // for getting the latest wishlist item
    }])->get()->map(function ($user) {
        $latestWishlist = $user->wishlists->first();
        
        return [
            'id' => $user->id,
            'name' => $user->first_name. " ". $user->last_name,
            'email' => $user->email,
            'profile_picture'=>$user->profile_picture,
            'is_verified' => $user->email_verified_at ? true : false,
            'created_at' => $user->created_at,
            'account_age' => $user->created_at->diffForHumans(),
            'wishlist_count' => $user->wishlists->count(),
            'latest_wishlist' => $latestWishlist ? [
                'name' => $latestWishlist->title ?? 'N/A',
                'created_at' => $latestWishlist->created_at->format('d/m/Y'),
            ] : null
        ];
    });

    return view('admin.user', compact('users'));
}

}
