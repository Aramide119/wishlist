<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Wishlist;
use App\Models\Item;
use App\Models\Money;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $wishlist = ;
        return view('user.wishlist.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function upload(Request $request, $wishlistId)
    {
        
        $wishlist= Wishlist::findOrFail($wishlistId);

        if($wishlist){
            if($request->hasFile('image'))
             {
                $file = $request->File('image');
                $requiredFileType = ['jpg','jpeg','png','gif'];
                $maxFileSize = '3145728';
                $path = "user/image";


                $filename   = $file->getClientOriginalName();
                $extension  = $file->getClientOriginalExtension();
                $size       = $file->getSize();
                $slugFilename =  Str::of($filename)->slug();
                $newFileName = $slugFilename . '.' . $extension;
            
                if (!in_array($extension, $requiredFileType)) {
                    $requiredFileTypeString = implode(",", $requiredFileType);
                    return redirect()->back()->with('error', "Unsupported File Format, Expecting". $requiredFileTypeString );
                }
            
                if ($maxFileSize && $size > $maxFileSize) {
                    
                    return redirect()->back()->with('error', "The maximum filesize requried is ". $maxFileSize );
                }
                    
                    $pathToImage = $file->move(public_path($path), $newFileName);

                    $wishlist = Wishlist::findOrFail($wishlistId);
                    $wishlist->image = $path . '/' . $newFileName; 
                    $wishlist->save();
                    return redirect()->back()->with('success', "Image uploaded successfully.");
            }
        }
   
            return redirect()->back()->with('error', "No file was uploaded.");
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'date' => 'required|date',
            'addressLine1' => 'required|string',
            'addressLine2' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'postal' => 'required|string',
            'country' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $wishlist = Wishlist::create([
            'user_id' => auth()->id(), 
            'title' => $request->title,
            'date' => $request->date,
            'addressLine1' => $request->addressLine1,
            'addressLine2' => $request->addressLine2,
            'city' => $request->city,
            'state' => $request->state,
            'postal' => $request->postal,
            'country' => $request->country,
            'description' => $request->description,
        ]);
        return redirect()->route('wishlist.show', $wishlist->slug)
        ->with('success', 'Wishlist created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function edit($slug)
    {
        $wishlist = Wishlist::where('slug', $slug)->firstOrFail();
        $items = Item::where('wishlist_id', $wishlist->id)->get();
        $money = Money::where('wishlist_id', $wishlist->id)->get();
        return view('user.wishlist.create', compact('wishlist', 'items', 'money'));
    }
    public function show($slug)
    {
        $wishlist = Wishlist::where('slug', $slug)->firstOrFail();

        $items = $wishlist->items;
        $money = $wishlist->money;

        
        return view('user.wishlist.view', compact('wishlist', 'items', 'money'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function view($slug)
    {
        $wishlist = Wishlist::where('slug', $slug)->with('items')->firstOrFail();
        $items = $wishlist->items;
        $money = $wishlist->money;
        return view('user.wishlist.show', compact('items', 'wishlist', 'money'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $wishlist = Wishlist::findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string',
            'date' => 'required|date',
            'addressLine1' => 'required|string',
            'addressLine2' => 'nullable|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'postal' => 'required|string',
            'country' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $wishlist->update($data);

        return redirect()->route('wishlist.show', $wishlist->id)
            ->with('success', 'Wishlist updated successfully!');
    }

    public function destroy($id)
    {
        $wishlist = Wishlist::findOrFail($id);

        // Optionally delete image file from server if exists
        if ($wishlist->image && file_exists(public_path($wishlist->image))) {
            unlink(public_path($wishlist->image));
        }

        // Optionally delete associated items
        Item::where('wishlist_id', $id)->delete();

        $wishlist->delete();

        return back()->with('success', 'Wishlist deleted successfully!');
    }
    
}
