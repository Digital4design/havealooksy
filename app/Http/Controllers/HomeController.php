<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Listings;
use Validator;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::guest())
        {
            $categories = Categories::where('status', '1')->get();
            $fav_listings = Listings::where('is_favorite', '1')->where('status', '1')
                                    ->where('is_approved', '1')
                                    ->get();
            $new_listings = Listings::where('status', '1')
                                    ->where('is_approved', '1')
                                    ->take(4)->orderBy('created_at', 'desc')
                                    ->get();
            return view('index')->with(['categories' => $categories, 'fav_listings' => $fav_listings, 'new_listings' => $new_listings]);
        }
        else
        {
            return redirect('/validate-user');
        } 
    }

    /**
    *   Checking User Role & Redirecting to their 
    *   respective dashboards
    */
    public function checkUserRole()
    {   
        $this->middleware('auth');

        if(Auth::check()){
            //Get Login User role here
            $role = Auth::user()->roles->first();
            if(!empty($role)){
                return redirect('/'.$role->name);
            }
        }
        Auth::logout();
        return redirect('/');
    }

    /* Get Products of a category */
    public function getProducts($id)
    {
        $listings = Listings::where('category_id', $id)->where('status', '1')->where('is_approved', '1')->get();
        $category = Categories::where('id', $id)->first();

        return view('frontapp.product-page')->with(['listings' => $listings, 'category' => $category]);
    }

    /* Get Product Details */
    public function getProductDetails($id)
    {
        $listing_data = Listings::with(['getCategory', 'getListerRole'])->where('id', $id)->first();

        $all_listings_of_category = Listings::where('category_id', $listing_data['category_id'])
                                            ->where('status', '1')->where('id', '<>', $id)
                                            ->where('is_approved', '1')->get();

        return view('frontapp.product-details')->with(['listing_data' => $listing_data, 'all_listings' => $all_listings_of_category]);
    }

    /* Apply Filters */
    public function applyFilters(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'price_filter' => ['required'],
        ], ['price_filter.required' => 'Please select price range.']);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $price_filter = $request->price_filter;

        foreach ($price_filter as $value) 
        {   
            $priceRange = sscanf($value, '%d-%d');
            $listings[] = Listings::where('category_id', $request->category_id)->where('status', '1')->whereBetween('price', [$priceRange[0], $priceRange[1]])->get();
        }

        $filtered_listings = view('frontapp.renders.listings_render')->with('listings_list', $listings)->render();

        if($filtered_listings)
        {
            return response()->json(['status' => 'success', 'filtered_listings' => $filtered_listings]);
        }

        return response()->json(['status' => 'danger', 'message' => 'No matches found.']);
    }

    public function messagesView()
    {
        return redirect(Auth::user()->roles->first()->name.'/chat');
    }

    public function messagesChatView($id)
    {
        if(Auth::user()->id == $id){
            return redirect(Auth::user()->roles->first()->name.'/chat');
        }
        return redirect(Auth::user()->roles->first()->name.'/chat/get-chat/'.$id);
    }

    public function viewCart()
    {
        return view('frontapp.cart');
    }

    public function searchWebsite(Request $request)
    {
        $industry = $request->industry;
        $location = $request->location;

        if($industry != "" && $location != "")
        {
            $listings = Listings::with(['getCategory'])
                            ->whereHas('getCategory', function($q) use($industry){
                                $q->where('name', 'like', '%'.$industry.'%');
                            })->orWhere('location', 'like', '%'.$location.'%')
                            ->where('status', '1')
                            ->where('is_approved', '1')
                            ->get();
        }
        elseif ($industry != "") 
        {
            $listings = Listings::with(['getCategory'])
                            ->whereHas('getCategory', function($q) use($industry){
                                $q->where('name', 'like', '%'.$industry.'%');
                            })->where('status', '1')
                            ->where('is_approved', '1')
                            ->get();
        }
        elseif ($location != "") 
        {
            $listings = Listings::where('location', 'like', '%'.$location.'%')->where('status', '1')->where('is_approved', '1')->get();
        }
        else
        {
            $listings = Listings::where('status', '1')->where('is_approved', '1')->get();
        }

        return view('frontapp.search-results-view')->with(['listings' => $listings]);
    }
}
