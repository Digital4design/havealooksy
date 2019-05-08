<?php

namespace App\Http\Controllers\Shopper;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bookings;
use Carbon;
use Auth;

class BookingController extends Controller
{
    public function getBookingsView()
    {
    	$bookings = Bookings::with(['getBookedListingUser', 'getBookedListingTime', 'getBookingStatus'])
    						->where('user_id', Auth::user()->id)
    						->orderBy('created_at', 'desc')
							->paginate(5);

    	return view('shopper.bookings_view')->with('bookings', $bookings);
    }

    public function getAllBookings()
    {
    	$bookings = Bookings::with(['getBookedListingUser', 'getBookedListingTime', 'getBookingStatus'])
    						->where('user_id', Auth::user()->id)
    						->orderBy('created_at', 'desc')
    						->get();

    	foreach ($bookings as $b)
    	{
    		$time = Carbon::create($b['getBookedListingTime']['start_time'])->format("g:i a")."-".Carbon::create($b['getBookedListingTime']['end_time'])->format("g:i a");
    		$b['time'] = $time;
    	}

    	return response()->json(['bookings' => $bookings]);
    }

    public function getBookingData($id)
    {
    	$booking = Bookings::with(['getBookedListingUser', 'getBookedListingTime', 'getBookingStatus'])
							->where('id', $id)->first();

    	$booking_data = view('shopper.renders.booking_data_render')->with('booking', $booking)->render();

    	return response()->json(['status' => 'success', 'booking_data' => $booking_data]);
    }
}
