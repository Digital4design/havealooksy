<?php

namespace App\Http\Controllers\Host;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bookings;
use Auth;

class BookingController extends Controller
{
    public function getBookings()
    {
    	$bookings = Bookings::with(['getBookedListingUser'])->whereHas('getBookedListingUser', function($q){
    		$q->where('user_id', Auth::user()->id);
    	})->get();

    	return view('host.bookings_view')->with('bookings', $bookings);
    }
}
