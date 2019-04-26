<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
	protected $table = 'wishlist';
    protected $fillable = ['listing_id', 'user_id'];

    public function getListing()
    {
    	return $this->belongsTo("App\Models\Listings", "listing_id");
    }

    public function getListingImages()
    {
    	return $this->belongsToMany("App\Models\ListingImages", "App\Models\Listings", "id", "id", "listing_id", "listing_id");
    }
}
