<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    protected $table = 'bookings';
    protected $fillable = ['date', 'no_of_seats', 'time_slot', 'status_id', 'listing_id', 'user_id'];

    public function getBookingStatus()
    {
    	return $this->belongsTo("App\Models\BookingStatus", "status_id");
    }

    public function getBookedListingUser()
    {
    	return $this->belongsTo("App\Models\Listings", 'listing_id');
    }

    public function getBookedListingTime()
    {
        return $this->belongsTo("App\Models\ListingTimes", 'time_slot');
    }
}
