<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    //
    protected $fillable = [
        'user_id', 'reference_id', 'type', 'amount',
        'transfer_fee', 'status', 'description'
    ];
    
}
