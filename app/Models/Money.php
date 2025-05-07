<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Money extends Model
{
    //
    protected $fillable = ['wishlist_id', 'name', 'description', 'target', 'image'];

    public function wishlist()
    {
        return $this->belongsTo(Wishlist::class);
    }
}
