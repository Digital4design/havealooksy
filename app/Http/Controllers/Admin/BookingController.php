<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Models\ListingTimes;
use App\Models\Bookings;
use App\Models\Listings;
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
    					->editColumn('status_id', function ($bookings){
                            return $bookings['getBookingStatus']['name'];
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
    					})->rawColumns(['listing_id' => 'listing_id', 'user_id' => 'user_id'])->make(true);
    }
}
