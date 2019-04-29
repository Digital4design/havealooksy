<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Models\RatingsAndReviews;

class RatingController extends Controller
{
    public function getRatingsView()
    {
    	return view('admin.ratings_view');
    }

    public function getAllRatings()
    {
    	$ratings = RatingsAndReviews::with(['getReviewer', 'getReviewedListing'])
    								->get();

    	return Datatables::of($ratings)
    					->editColumn('listing_id', function ($ratings){
                            return "<a href='".url('admin/listings/view/'.$ratings['listing_id'])."' class='view_detail'>".$ratings['getReviewedListing']['title']."</a>";
                        })->editColumn('rating', function ($ratings){
                            return $ratings['rating'];
                        })->editColumn('review', function ($ratings){
                            return $ratings['review'];
                        })->editColumn('posted_by', function ($ratings){
                        	return "<a href='".url('admin/users/view/'.$ratings['posted_by'])."' class='view_detail'>".$ratings['getReviewer']['first_name']."</a>";
                        })->editColumn('approved', function ($ratings){
                        	if($ratings['approved'] == 1){
                        		$label = "Discard";
                        		$btn_class = "btn-default";
                        	}
                        	if($ratings['approved'] == 0){
                        		$label = "Approve";
                        		$btn_class = "btn-info";
                        	}
                        	return "<a href='#' data-id='".$ratings['id']."' class='btn ".$btn_class." approval'>".$label."</a>";
                        })->editColumn('spam', function ($ratings){
                        	if($ratings['spam'] == 1){
                        		$label = "Remove from Spam";
                        		$btn_class = "btn-default";
                        	}
                        	if($ratings['spam'] == 0){
                        		$label = "Add to Spam";
                        		$btn_class = "btn-danger";
                        	}
                        	return "<a href='#' data-id='".$ratings['id']."' class='btn ".$btn_class." spam'>".$label."</a>";
                        })->addColumn('approval_status', function ($ratings){
                        	if($ratings['approved'] == 1){
                        		return "Approved";
                        	}
                        	if($ratings['approved'] == 0){
                        		return "Discarded";
                        	}
                        })->addColumn('spam_status', function ($ratings){
                        	if($ratings['spam'] == 1){
                        		return "Yes";
                        	}
                        	if($ratings['spam'] == 0){
                        		return "No";
                        	}
    					})->rawColumns(['listing_id' => 'listing_id', 'posted_by' => 'posted_by', 'approved' => 'approved', 'spam' => 'spam'])->make(true);
    }

    public function changeApproval($id, $data)
    {
    	$rating = RatingsAndReviews::find($id);
    	$rating->approved = $data;
    	$rating->save();

    	return response()->json(['status' => 'success']);
    }

    public function markSpam($id, $data)
    {
    	$rating = RatingsAndReviews::find($id);
    	$rating->spam = $data;
    	$rating->save();

    	return response()->json(['status' => 'success']);
    }
}
