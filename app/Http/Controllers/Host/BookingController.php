<?php

namespace App\Http\Controllers\Host;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\Shopper\NotifyShopper;
use Yajra\Datatables\Datatables;
use App\Models\ListingTimes;
use App\Models\Bookings;
use App\Models\Listings;
use App\User;
use Carbon;
use Auth;

class BookingController extends Controller
{
    public function getBookingsView()
    {
    	$bookings = Bookings::with(['getBookedListingUser', 'getBookedListingTime', 'getbookingStatus'])
                            ->whereHas('getBookedListingUser', function($q){
                        		$q->where('user_id', Auth::user()->id);
                        	})->orderBy('created_at', 'desc')->get();
    	return view('host.bookings_view')->with('bookings', $bookings);
    }

    public function getAllBookings()
    {
    	$bookings = Bookings::with(['getBookedListingUser', 'getBookedListingTime', 'getbookingStatus'])
                            ->whereHas('getBookedListingUser', function($q){
                        		$q->where('user_id', Auth::user()->id);
                        	})->orderBy('created_at', 'desc')->get();

    	foreach ($bookings as $b)
    	{
    		$time = Carbon::create($b['getBookedListingTime']['start_time'])->format("g:i a")."-".Carbon::create($b['getBookedListingTime']['end_time'])->format("g:i a");
    		$b['time'] = $time;
    	}

    	return response()->json(['bookings' => $bookings]);
    }

    public function getBookingData($id)
    {
    	$booking = Bookings::with(['getBookedListingUser', 'getBookedListingTime', 'getbookingStatus'])
    						->whereHas('getBookedListingUser', function($q){
    							$q->where('user_id', Auth::user()->id);
    						})->where('id', $id)->first();

    	$booking_data = view('host.renders.booking_data_render')->with('booking', $booking)->render();

    	return response()->json(['status' => 'success', 'booking_data' => $booking_data]);
    }

    public function getBookingsTable()
    {
        $bookings = Bookings::with(['getBookingStatus'])->get();
        return Datatables::of($bookings)
                        ->editColumn('status_id', function ($bookings){
                            return $bookings['getBookingStatus']['display_name'];
                        })->editColumn('time_slot', function ($bookings){
                            $time_slot = ListingTimes::where('id', $bookings['time_slot'])
                                        ->first();
                            $time_slot = Carbon::create($time_slot['start_time'])->format("g:i a")."-".Carbon::create($time_slot['end_time'])->format("g:i a");
                            return $time_slot;
                        })->editColumn('listing_id', function ($bookings){
                            return "<a href='".url('host/listings/view/'.$bookings['listing_id'])."' class='view_eye'><i class='fa fa-eye'></i></a>";
                        })->addColumn('action', function ($bookings){
                            if(Carbon::today() > $bookings['date'] && $bookings['status_id'] != 2)
                            {
                                return "Requested booking date passed.";
                            }
                            if($bookings['status_id'] == 1){
                                $label = "Revoke Confirmation";
                                $btn_style = "btn-default";
                            }
                            elseif($bookings['status_id'] == 3){
                                $label = "Confirm Booking";
                                $btn_style = "btn-info";
                            }
                            elseif($bookings['status_id'] == 2){
                                return $bookings['getBookingStatus']['display_name'];
                            }
                            return "<a href='#' data-id='".$bookings['id']."' class='btn ".$btn_style." confirmation'>".$label."</a>"; 
                            
                        })->rawColumns(['listing_id' => 'listing_id', 'action' => 'action'])->make(true);
    }

    public function changeBookingConfirmation($id, $data)
    {
        try
        {
            $booking = Bookings::find($id);
            $booking->status_id = $data;
            $booking->save();

            $listing = Listings::where('id', $booking['listing_id'])->first();
            $time_slot = ListingTimes::where('id', $booking['time_slot'])->first();
            $date = Carbon::create($booking['date'])->format("d/m/Y");

            $time = Carbon::create($time_slot['start_time'])->format("g:i a")."-".Carbon::create($time_slot['end_time'])->format("g:i a");

            $notification_data = ["user" => '', "message" => "Your booking for ".$listing->title." on ".$date." at ".$time." has been confirmed. Click here to make payment.", "action" => url('/cart')];

            $user = User::find($booking['user_id']);

            $user->notify(new NotifyShopper($notification_data));

            return response()->json(['status' => 'success']);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 'danger' , 'message' => 'Something went wrong. Please try again later.']);
        }
    }
}
