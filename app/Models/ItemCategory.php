<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemCategory extends Model
{
    //

    protected $fillable = [
        'wishlist_id',
        'name',
    ];

    public function wishlist()
    {
        return $this->belongsTo(Wishlist::class);
    }
}
