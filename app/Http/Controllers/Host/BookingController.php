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
use Cart;

class BookingController extends Controller
{
    public function getBookingsView()
    {
    	$bookings = Bookings::with(['getBookedListingUser', 'getBookedListingTime', 'getbookingStatus'])
                            ->whereHas('getBookedListingUser', function($q){
                        		$q->where('user_id', Auth::user()->id);
                        	})->orderBy('created_at', 'desc')->get();
    	return view('host.bookings_calendar')->with('bookings', $bookings);
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

    public function getBookingTableView()
    {
        return view('host.bookings_table_view');
    }

    public function getBookingsTable()
    {
        $bookings = Bookings::with(['getBookingStatus'])->get();
        return Datatables::of($bookings)
                        ->editColumn('date', function ($bookings){
                            return Carbon::create($bookings['date'])->format('d F, Y');
                        })->editColumn('status_id', function ($bookings){
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
                                return "<a href='#' data-id='".$bookings['id']."' class='btn btn-default confirmation' style='margin-right:5px;display:inline;'>Revoke Confirmation</a>";
                            }
                            elseif($bookings['status_id'] == 3){
                                return "<a href='#' data-id='".$bookings['id']."' class='btn btn-info confirmation' style='margin-right:5px;display:inline;'>Confirm</a><a href='#' data-id='".$bookings['id']."' class='btn btn-danger cancel_booking' style='display:inline;'>Cancel</a>";
                            }
                            elseif($bookings['status_id'] == 2){
                                return $bookings['getBookingStatus']['display_name'];
                            }
                            elseif($bookings['status_id'] == 4){
                                return $bookings['getBookingStatus']['display_name'];
                            } 
                            
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

            if($data == 1)
            {
                $notification_data = ["user" => '', "message" => "Your booking for ".$listing->title." on ".$date." at ".$time." has been confirmed. Click here to make payment.", "action" => url('/cart')];
            }

            if($data == 3)
            {
                $notification_data = ["user" => '', "message" => "Confirmation of your booking request for ".$listing->title." on ".$date." at ".$time." has been revoked.", "action" => url('/cart')];
            }

            $user = User::find($booking['user_id']);

            $user->notify(new NotifyShopper($notification_data));

            return response()->json(['status' => 'success']);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 'danger' , 'message' => 'Something went wrong. Please try again later.']);
        }
    }

    public function cancelBooking($id, $data)
    {
        try
        {
            $booking = Bookings::find($id);
            $booking->status_id = $data;
            $booking->save();

            $booking_user = User::where('id', $booking['user_id'])->first();
            $cart_items = Cart::session($booking_user['id'])->getContent();
            
            foreach ($cart_items as $c)
            {
                if($c['attributes']['booking_id'] == $booking['id'])
                {
                    $cart_item_id = $c['id'];
                    break;
                }
            }

            $remove_cart_item = Cart::session($booking_user['id'])->remove($cart_item_id);

            $listing = Listings::where('id', $booking['listing_id'])->first();
            $time_slot = ListingTimes::where('id', $booking['time_slot'])->first();
            $date = Carbon::create($booking['date'])->format("d/m/Y");

            $time = Carbon::create($time_slot['start_time'])->format("g:i a")."-".Carbon::create($time_slot['end_time'])->format("g:i a");

            $notification_data = ["user" => '', "message" => "Your booking for ".$listing->title." on ".$date." at ".$time." has been cancelled.", "action" => ''];

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
