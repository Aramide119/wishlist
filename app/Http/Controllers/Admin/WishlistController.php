<?php

namespace App\Http\Controllers\Admin;

use App\Models\Item;
use App\Models\Money;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WishlistController extends Controller
{
    //
    public function index()
    {
        $wishlists = Wishlist::with('user', 'items', 'money')->get();
        return view('admin.wishlist.index', compact('wishlists'));
    }

    public function item()
    {
        $items = Item::with('wishlist', 'reservations')->get();

        return view('admin.wishlist.item', compact('items'));
        
    }

    public function money()
    {
        $items = Money::with('wishlist', 'reservations')->get();

        return view('admin.wishlist.money', compact('items'));
        
    }
}
