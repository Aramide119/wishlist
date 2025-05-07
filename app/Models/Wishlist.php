<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'date', 'addressLine1','addressLine2', 'description','city','state','postal','country', 'image', 'user_id'];

    // Define relationship: A Wishlist has many Items
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function money()
    {
        return $this->hasMany(Money::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function itemCategories()
    {
        return $this->hasMany(ItemCategory::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($wishlist) {
            $baseSlug = Str::slug($wishlist->title);
            $slug = $baseSlug;
            $count = 1;

            while (static::where('slug', $slug)->exists()) {
                $slug = "{$baseSlug}{$count}";
                $count++;
            }

            $wishlist->slug = $slug;
        });
    }

}
