<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BankController extends Controller
{
    public function getBanks()
    {
        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
                        ->get('https://api.paystack.co/bank', [
                            'country' => 'nigeria',
                            'type' => 'nuban'
                        ]);

        return $response->json();
    }
    public function resolveAccount(Request $request)
{
    $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
        ->get('https://api.paystack.co/bank/resolve', [
            'account_number' => $request->account_number,
            'bank_code' => $request->bank_code,
        ]);

    return $response->json();
}

}
