<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    //
    protected $guarded = [];
    
        public function bankAccount()
    {
        return $this->belongsTo(UserBankDetail::class);
    }
}
