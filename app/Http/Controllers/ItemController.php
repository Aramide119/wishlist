<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\ReserveItem;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function reserve(Request $request)
    {
    
            $validated = $request->validate([ 
                'item_id'         => 'required|exists:items,id',
                'name'            => 'nullable|string|max:255',
                'email'           => 'nullable|email|max:255',
                'quantity'        => 'required|integer|min:1',            
                'accepted_terms'  => 'required|boolean'
            ]);
    
            ReserveItem::create([
                'name' => $request->name,
                'email' => $request->email,
                'quantity' => $request->quantity,
                'item_id' => $request->item_id,
                'accepted_terms' => $request->accepted_terms,
            ]);
    
            return response()->json(['message' => 'Reservation successful!']);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        try {
            $data = $request->validate([
                'wishlist_id' => 'required|exists:wishlists,id',
                'name' => 'required|string|max:255',
                'website_link' => 'nullable',
                'note' => 'nullable|string',
                'price' => 'nullable|numeric',
                'quantity' => 'nullable|integer|min:1',
                'image' => 'nullable|file',
                'category' => 'nullable',
                'new_category' => 'nullable|string|max:255',
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->errors());
        }
        $categoryId = null;
        if ($request->category == '1' && $request->new_category) {
            // Create new category
            $category = ItemCategory::create(['name' => $request->new_category, 'wishlist_id'=>$request->wishlist_id]);
            $categoryId = $category->id;
        } elseif ($request->category && $request->category != '2') {
            // Use selected category if it's not "None"
            $categoryId = $request->category;
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('item_images'), $imageName);
            $imagePath = 'item_images/' . $imageName; // Save relative path for display
        }

        // Create the item
        $item = Item::create([
            'wishlist_id' =>$request->wishlist_id,
            'name' => $request->name,
            'website_link' => $request->website_link,
            'price' => $request->price,
            'note' => $request->note,
            'quantity' => $request->quantity,
            'category_id' => $categoryId,
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Item added successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'wishlist_id' => 'required|exists:wishlists,id',
                'name' => 'required|string|max:255',
                'website_link' => 'nullable',
                'note' => 'nullable|string',
                'price' => 'nullable|numeric',
                'quantity' => 'nullable|integer|min:1',
                'image' => 'nullable|file',
                'category' => 'nullable',
                'new_category' => 'nullable|string|max:255',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->errors());
        }
    
        $item = Item::findOrFail($id);
    
        // Handle category logic
        $categoryId = null;
        if ($request->category == '1' && $request->new_category) {
            $category = ItemCategory::create([
                'name' => $request->new_category,
                'wishlist_id' => $request->wishlist_id
            ]);
            $categoryId = $category->id;
        } elseif ($request->category && $request->category != '2') {
            $categoryId = $request->category;
        }
    
        // Handle image upload (replace old image)
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('item_images'), $imageName);
            $item->image = 'item_images/' . $imageName;
        }
    
        // Update item fields
        $item->update([
            'wishlist_id' => $request->wishlist_id,
            'name' => $request->name,
            'website_link' => $request->website_link,
            'note' => $request->note,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'category_id' => $categoryId,
            'image' => $item->image, // Keep the current or newly uploaded image
        ]);
    
        return redirect()->back()->with('success', 'Item updated successfully!');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $item = Item::findOrFail($id);

        // Optionally delete the image file if it exists
        if ($item->image && file_exists(public_path($item->image))) {
            unlink(public_path($item->image));
        }

        $item->delete();

        return redirect()->back()->with('success', 'Item deleted successfully!');
    }

}
