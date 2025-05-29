<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    //
    protected $fillable = [
        'user_id', 'reference_id', 'type', 'amount',
        'transfer_fee', 'status', 'description', 'total_amount', 'withdrawal_id'
    ];
    
 
        public function user()
        {
            return $this->belongsTo(User::class);
        }
        public function withdrawal()
        {
            return $this->belongsTo(Withdrawal::class);
        }
        
        public function reserveItem()
        {
            return $this->belongsTo(ReserveItem::class, 'reference_id', 'reference_id');
        }
}
