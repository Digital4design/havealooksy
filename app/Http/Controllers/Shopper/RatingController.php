<?php

namespace App\Http\Controllers\Shopper;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\Admin\NotifyAdmin;
use Yajra\Datatables\Datatables;
use App\Models\RatingsAndReviews;
use App\Models\Bookings;
use App\Models\Listings;
use App\User;
use Validator;
use Carbon;
use Auth;

class RatingController extends Controller
{
    public function __construct()
    {
        $this->admin = User::whereHas('roles', function($q){
                            $q->where('name', 'admin');
                       })->first();
    }

    public function getRatingsView()
    {
    	return view('shopper.ratings_view');
    }

    public function getProductsRatings()
    {
    	$bookings = Bookings::with(['getBookedListingUser'])
    						->where('status_id', '2')
    						->where('date', '<', Carbon::today())
    						->where('user_id', Auth::user()->id)
    						->get();

    	return Datatables::of($bookings)
    					->addColumn('product', function ($bookings){
                            return $bookings['getBookedListingUser']['title'];
    					})->addColumn('location', function ($bookings){
                            return $bookings['getBookedListingUser']['location'];
    					})->addColumn('price', function ($bookings){
                            return $bookings['getBookedListingUser']['price'];
    					})->addColumn('date', function ($bookings){
    						$date = Carbon::create($bookings['date'])->format("d/m/Y");
                            return $date;
                        })->addColumn('rating', function ($bookings){
    						$feedback = RatingsAndReviews::where('posted_by', Auth::user()->id)
    										->where('listing_id', $bookings['getBookedListingUser']['id'])
    										->first();
                            if($feedback){
                            	return "<a href='#' data-id='".$feedback['id']."' data-target='#show-rating' data-toggle='modal' class='show-review view_eye'><i class='fa fa-eye'></i></a>";
                            }
                            return "<a href='#' data-id='".$bookings['listing_id']."' data-target='#post-rating' data-toggle='modal' class='btn btn-danger post-rating'>Rate Now</a>";
    					})->rawColumns(['rating' => 'rating', 'action' => 'action'])->make(true);
    }

    public function postReview(Request $request)
    {
    	$validator = Validator::make($request->all(),
        [
            'rating' => ['required'],
            'review' => ['required'],
        ], ['rating.required' => 'Please select a rating.', 'review.required' => 'Please write a review.']);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        try
        {
        	RatingsAndReviews::create([
        		'rating' => $request->rating,
        		'review' => $request->review,
        		'listing_id' => $request->listing_id,
        		'posted_by' => Auth::user()->id,
        	]);

            $listing = Listings::where('id', $request->listing_id)->first();

            /* Notify Admin */
            $notification_data_admin = ["user" => '', "message" => "A new review has been posted for ".$listing['title'].".", "action" => url('admin/ratings')];
            $this->admin->notify(new NotifyAdmin($notification_data_admin));

        	return response()->json(['status' => 'success', 'message' => 'Review posted successfully.']);
        }
        catch(\Exception $e)
        {
        	// return response()->json(['status' => 'danger','message' => 'Something went wrong! Please try again later.']);
            return response()->json(['status' => 'danger','message' => $e->getMessage()]);
        }
    }

    public function getReview($id)
    {
    	$get_data = RatingsAndReviews::where('id', $id)->first();

    	$result = view('shopper.renders.rating_review_render')->with(['data' => $get_data])->render();

    	return response()->json(['status' => 'success', 'result' => $result]);
    }
}
