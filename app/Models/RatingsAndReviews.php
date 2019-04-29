<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingsAndReviews extends Model
{
    protected $table = 'ratings_and_reviews';
    protected $fillable = ['rating', 'review', 'approved', 'spam', 'listing_id', 'posted_by'];

    public function getReviewer()
    {
    	return $this->belongsTo("App\User", "posted_by");
    }

    public function getReviewedListing()
    {
    	return $this->belongsTo("App\Models\Listings", "listing_id");
    }
}
