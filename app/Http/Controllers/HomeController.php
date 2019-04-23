<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListingGuests;
use App\Models\ListingTimes;
use App\Models\Categories;
use App\Models\Listings;
use App\Models\Bookings;
use Validator;
use Auth;
use Cart;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

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
            $fav_listings = Listings::with(['getImages', 'getCategory'])->where('status', '1')
                                    ->where('is_approved', '1')
                                    ->get();
            $new_listings = Listings::with(['getImages', 'getCategory'])->where('status', '1')
                                    ->where('is_approved', '1')
                                    ->take(4)->orderBy('created_at', 'desc')
                                    ->get();
            $founder_picks = Listings::with(['getImages', 'getCategory'])->where('status', '1')
                                    ->where('is_approved', '1')
                                    ->where('founder_pick', '1')
                                    ->take(4)->orderBy('created_at', 'desc')
                                    ->get();
            return view('index')->with(['categories' => $categories, 'fav_listings' => $fav_listings, 'new_listings' => $new_listings, 'founder_picks' => $founder_picks]);
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
        $listings = Listings::with(['getImages'])->where('category_id', $id)->where('status', '1')->where('is_approved', '1')->get();
        $category = Categories::where('id', $id)->first();

        return view('frontapp.product-page')->with(['listings' => $listings, 'category' => $category]);
    }

    /* Get Product Details */
    public function getProductDetails($id)
    {
        $listing_data = Listings::with(['getCategory', 'getListerRole', 'getImages'])->where('id', $id)->first();

        $all_listings_of_category = Listings::where('category_id', $listing_data['category_id'])
                                            ->where('status', '1')->where('id', '<>', $id)
                                            ->where('is_approved', '1')->get();

        return view('frontapp.product-details')->with(['listing_data' => $listing_data, 'all_listings' => $all_listings_of_category]);
    }

    /* Get Listing Availability Details */
    public function getProductAvailability($id)
    {
        $guests = ListingGuests::where('listing_id', $id)->first();
        $times = ListingTimes::where('listing_id', $id)->get();

        $listing_details = view('frontapp.renders.listing_details_render')->with(['guests' => $guests, 'times' => $times])->render();

        return response()->json(['status' => 'success', 'listing_details' => $listing_details]);
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
        if(Cart::session(Auth::user()->id)->isEmpty())
        {
            $data = 'No items added to cart.';
            $status = 'empty';
        }
        else
        {
            $data = Cart::session(Auth::user()->id)->getContent();

            foreach ($data as $d)
            {
                $bkng = Bookings::with(['getBookingStatus'])->where('id', $d['attributes']['booking_id'])->first();
                $d['status'] = $bkng['getBookingStatus']['name'];
            }

            $status = 'not-empty';
        }
        return view('frontapp.cart')->with(['status' => $status, 'data' => $data]);
    }

    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'time' => ['required'],   
        ], ['time.required' => 'You must choose a time slot.']);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        try
        {
            if(Auth::guest())
            {
                return response()->json(['status' => 'login']);
            }

            
            $listing = Listings::with(['getGuests', 'getTimes', 'getImages'])->where('id', $request->listing_id)->first();

            $total_guests = $adults = $children = $infants = 0;
            if(isset($request->guest['adults'])){
                $total_guests += $request->guest['adults'];
                $adults = $request->guest['adults'];
            }
            if(isset($request->guest['children'])){
                $total_guests += $request->guest['children'];
                $adults = $request->guest['children'];
            }
            if(isset($request->guest['infants'])){
                $total_guests += $request->guest['infants'];
                $adults = $request->guest['infants'];
            }

            if($total_guests > $listing['getGuests']['total_count'])
            {
                return response()->json(['status' => 'danger', 'message' => 'Guest count must not exceed Maximum allowed guests']);
            }

            if(Cart::session(Auth::user()->id)->get($listing['id']))
            {
                return response()->json(['status' => 'danger', 'message' => 'This experience has been already added to cart.']);
            }

            $start_time = substr($request->time, 0, 5);
            $end_time = substr($request->time, 6);
            $get_time_slot = ListingTimes::where('listing_id', $listing['id'])
                                        ->where('start_time', $start_time)
                                        ->where('end_time', $end_time)
                                        ->first();

            /* Create booking entry */
            $booking = Bookings::create([
                'date' => $request->date,
                'no_of_seats' => $total_guests,
                'time_slot' => $get_time_slot['id'],
                'status_id' => 3, /* Waiting for Host confirmation */
                'listing_id' => $listing['id'],
                'user_id' => Auth::user()->id,
            ]);

            Cart::session(Auth::user()->id)
                ->add($listing['id'], $listing['title'], $listing['price'], 1, array('description' => $listing['description'], 'image' => $listing['getImages'][0]['name'], 'adults' => $adults, 'children' => $children, 'infants' => $infants, 'time_slot' => $request->time, 'booking_id' => $booking['id']));

            return response()->json(['status' => 'success', 'message' => 'Your request for the experience has been submitted for confirmation.']);
        }
        catch(\Exception $e)
        {
            // return response()->json(['status' => 'danger','message' => 'Something went wrong! Please try again later.']);
            return response()->json(['status' => 'danger','message' => $e->getMessage()]);
        }
    }

    public function removeFromCart(Request $request)
    {
        $cart_item = Cart::session(Auth::user()->id)->get($request->cart_item_id);

        $remove_booking = Bookings::find($cart_item['attributes']['booking_id']);
        $remove_booking->delete();

        Cart::session(Auth::user()->id)->remove($request->cart_item_id);
        return redirect()->back();
    }

    public function searchWebsite(Request $request)
    {
        $industry = $request->industry;
        $location = $request->location;

        if($industry != "" && $location != "")
        {
            $listings = Listings::with(['getCategory', 'getImages'])
                            ->whereHas('getCategory', function($q) use($industry){
                                $q->where('name', 'like', '%'.$industry.'%');
                            })->orWhere('location', 'like', '%'.$location.'%')
                            ->where('status', '1')
                            ->where('is_approved', '1')
                            ->get();
        }
        elseif ($industry != "") 
        {
            $listings = Listings::with(['getCategory', 'getImages'])
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
            $listings = Listings::with(['getImages'])->where('status', '1')->where('is_approved', '1')->get();
        }

        return view('frontapp.search-results-view')->with(['listings' => $listings]);
    }
}
