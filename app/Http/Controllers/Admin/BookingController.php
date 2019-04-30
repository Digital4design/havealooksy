<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\Host\NotifyHost;
use App\Notifications\Shopper\NotifyShopper;
use Yajra\Datatables\Datatables;
use App\Models\ListingTimes;
use App\Models\Bookings;
use App\Models\Listings;
use App\User;
use Carbon;

class BookingController extends Controller
{
    public function getBookingsView()
    {
    	return view('admin.bookings_view');
    }

    public function getAllBookings()
    {
    	$bookings = Bookings::with(['getBookingStatus'])->get();
    	return Datatables::of($bookings)
                        ->editColumn('date', function ($bookings){
                            return Carbon::create($bookings['date'])->format('d F, Y');
    					})->editColumn('status_id', function ($bookings){
                            if($bookings['date'] < Carbon::today() && $bookings['status_id'] != 2 && $bookings['status_id'] != 4)
                            {
                                return "Booking date has passed.<br><a href='#' data-id='".$bookings['id']."' class='cancel_booking'>Cancel Booking</a>";
                            }
                            return $bookings['getBookingStatus']['display_name'];
    					})->editColumn('time_slot', function ($bookings){
    						$time_slot = ListingTimes::where('id', $bookings['time_slot'])
    									->first();
    						$time_slot = Carbon::create($time_slot['start_time'])->format("g:i a")."-".Carbon::create($time_slot['end_time'])->format("g:i a");
                            return $time_slot;
    					})->editColumn('listing_id', function ($bookings){
    						return "<a href='".url('admin/listings/view/'.$bookings['listing_id'])."' class='view_eye'><i class='fa fa-eye'></i></a>";
                        })->editColumn('user_id', function ($bookings){
                            return "<a href='".url('admin/users/view/'.$bookings['user_id'])."' class='view_eye'><i class='fa fa-eye'></i></a>";
                        })->editColumn('created_at', function ($bookings){
                            $date = date("d/m/Y g:i a", strtotime($bookings['created_at']));
                            return $date;
    					})->rawColumns(['status_id' => 'status_id', 'listing_id' => 'listing_id', 'user_id' => 'user_id'])->make(true);
    }

    public function cancelBooking($id)
    {
        $booking = Bookings::find($id);
        $booking->status_id = 4;
        $booking->save();

        $listing = Listings::find($booking['listing_id']);

        $notification_data_host = ["user" => '', "message" => "Booking request for '".$listing['title']."' on ".Carbon::create($booking['date'])->format('d/m/Y')."  has been cancelled.", "action" => url('host/bookings')];

        $notification_data_shopper = ["user" => '', "message" => "Booking request for '".$listing['title']."' on ".Carbon::create($booking['date'])->format('d/m/Y')."  has been cancelled.", "action" => url('shopper/bookings')];

        $host = User::find($listing['user_id']);
        $shopper = User::find($booking['user_id']);

        $host->notify(new NotifyHost($notification_data_host));
        $shopper->notify(new NotifyShopper($notification_data_shopper));

        return response()->json(['status' => 'success', 'message' => 'Booking has been cancelled successfully.']);
    }
}
