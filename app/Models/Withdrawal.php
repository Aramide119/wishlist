<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    //
    protected $guarded = [];
    
   public function bankAccount()
    {
        return $this->belongsTo(UserBankDetail::class, 'account_id');
    }

public function walletTransactions()
{
    return $this->hasMany(WalletTransaction::class);
}
public function user()
{
    return $this->belongsTo(User::class);
}

}
