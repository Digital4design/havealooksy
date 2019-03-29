<?php

namespace App\Http\Controllers\Buyer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Listings;

class DashboardController extends Controller
{
    public function index()
    {
    	$categories = Categories::where('status', '1')->get();
        $fav_listings = Listings::where('is_favorite', '1')->where('status', '1')->get();

    	return view('buyer.home')->with(['categories' => $categories, 'fav_listings' => $fav_listings]);
    }
}
