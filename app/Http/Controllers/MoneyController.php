<?php

namespace App\Http\Controllers;

use App\Models\Money;
use Illuminate\Http\Request;
use App\Models\WalletTransaction;
use Illuminate\Support\Str;
use App\Models\ReserveItem;
use Illuminate\Support\Facades\Http;
use App\Models\Wishlist;

class MoneyController extends Controller
{
    public function store(Request $request){
        try {
            $data = $request->validate([
                'wishlist_id' => 'required|exists:wishlists,id',
                'name' => 'required|string|max:255',
                'description' => 'nullable',
                'target' => 'nullable|string',
                'image' => 'nullable|file'
            ]);
            
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->errors());
        }
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('money_images'), $imageName);
            $imagePath = 'money_images/' . $imageName; // Save relative path for display
        }

        // Create
        $money = Money::create([
            'wishlist_id' =>$request->wishlist_id,
            'name' => $request->name,
            'description' => $request->description,
            'target' => $request->target,
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Money added successfully!');
 
    }

    public function destroy($id)
    {
        $item = Money::findOrFail($id);

        // Optionally delete the image file if it exists
        if ($item->image && file_exists(public_path($item->image))) {
            unlink(public_path($item->image));
        }

        $item->delete();

        return redirect()->back()->with('success', 'Item deleted successfully!');
    }

    public function initiate(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string',
            'email' => 'required|email',
            'amount' => 'required|numeric|min:100',
            'note' => 'nullable|string'
        ]);

        $reference = Str::uuid();
        $money = Money::findOrFail($request->money_id); 
        $wishlist = Wishlist::findOrFail($money->wishlist_id);

        //store users information
        $commission = $request->input('amount')* 0.039;
        $amount = $request->input('amount') - $commission;
        ReserveItem::create([
            'name' => $request->name,
            'email' => $request->email,
            'amount' => $request->amount,
            'reference_id' => $reference,
            'money_id' => $request->money_id,
            'note' => $request->note,
            'status'=>'pending',
        ]);
        // Store the pending transaction
        WalletTransaction::create([
            'user_id' =>  $wishlist->user_id,
            'reference_id' => $reference,
            'type' => 'credit',
            'total_amount' => $request->input('amount'),
            'amount' => $amount,
            'transfer_fee' => '0',
            'status' => 'pending',
            'description' => $wishlist->title.'/'.$validated['note'] ?? $wishlist->title.'Donation',
        ]);

        // Init Paystack
        $paystackResponse = Http::withToken(env('PAYSTACK_SECRET_KEY'))->post('https://api.paystack.co/transaction/initialize', [
            'email' => $validated['email'],
            'amount' => $validated['amount'] * 100, // Paystack uses kobo
            'reference' => $reference,
            'callback_url' => route('donate.callback')
        ]);

        if ($paystackResponse->successful()) {
            return redirect($paystackResponse['data']['authorization_url']);
        }

        return back()->withErrors(['error' => 'Failed to initiate payment.']);
    }
    public function callback(Request $request)
    {
        $reference = $request->query('reference');

        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
            ->get("https://api.paystack.co/transaction/verify/{$reference}");

        if ($response['data']['status'] === 'success') {
            $transaction = WalletTransaction::where('reference_id', $reference)->firstOrFail();
            $transaction->update(['status' => 'successful']);
            $reservation = ReserveItem::where('reference_id', $reference)->firstOrfail();
            $reservation->update(['status' => 'successful']);
            return redirect('/')->with('success', 'Donation successful!');
        }

        return redirect('/')->with('error', 'Payment failed or was not completed.');
    }
}
