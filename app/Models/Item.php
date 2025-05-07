<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['wishlist_id', 'name', 'website_link', 'note', 'price', 'quantity', 'image'];


    public function wishlist()
    {
        return $this->belongsTo(Wishlist::class);
    }
    public function reservation()
    {
        return $this->hasOne(ReserveItem::class);
    }

}
