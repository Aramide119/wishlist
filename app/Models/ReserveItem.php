<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReserveItem extends Model
{
    //
    protected $fillable = ['name', 'email','reference_id','status', 'quantity', 'item_id', 'amount', 'money_id', 'note', 'accepted_terms'];
    public function money()
{
    return $this->belongsTo(Money::class, 'money_id');
}

public function item()
{
    return $this->belongsTo(Item::class, 'item_id');
}


}
