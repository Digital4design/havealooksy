<?php

namespace App\Http\Controllers;

use App\Notifications\Admin\NotifyAdmin;
use App\Notifications\Host\NotifyHost;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\ListingGuests;
use Cartalyst\Stripe\Stripe;
use App\Models\ListingTimes;
use App\Models\Categories;
use App\Models\Listings;
use App\Models\Bookings;
use Stripe\Error\Card;
use Validator;
use App\User;
use Session;
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

    public function __construct()
    {
        $this->admin = User::whereHas('roles', function($q){
                            $q->where('name', 'admin');
                       })->first();
    }

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

            /* Create booking entry */
            $booking = Bookings::create([
                'date' => $request->date,
                'no_of_seats' => $total_guests,
                'time_slot' => $request->time,
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

    /* Stripe Payment */
    public function stripePaymentView()
    {
        $data = Bookings::with(['getBookedListingUser', 'getBookingStatus'])
                        ->where('user_id', Auth::user()->id)
                        ->where('status_id', 1)
                        ->get();

        $total = 0;
        $bookings_done = [];
        foreach ($data as $d)
        {
            $total += $d['getBookedListingUser']['price'];
            $bookings_done[] = $d['listing_id']; 
        }

        return view('frontapp.stripe_payment_view')->with(['data' => $data, 'total' => $total, 'bookings_done' => $bookings_done]);
    }

    public function postPaymentWithStripe(Request $request)
    {   
        $validator = Validator::make($request->all(), [
                        'card_no' => 'required',
                        'ccExpiryMonth' => 'required',
                        'ccExpiryYear' => 'required',
                        'cvvNumber' => 'required',
                    ], ['card_no.required' => 'Crad number is required.', 'ccExpiryYear.required' => 'Expiry year is required.', 'ccExpiryMonth.required' => 'Expiry Month is required.', 'cvvNumber.required' => 'CVV number is required.']);

        if ($validator->passes()) {
            $input = $request->all();
            $input = Arr::except($input, ['_token']);
            $stripe = Stripe::make(env('STRIPE_SECRET_KEY'));

            try {
                /*$token = $stripe->tokens()->create([
                        'card' => [
                            'number' => $request->get('card_no'),
                            'exp_month' => $request->get('ccExpiryMonth'),
                            'exp_year' => $request->get('ccExpiryYear'),
                            'cvc' => $request->get('cvvNumber'),
                        ],
                    ]);*/

                $token = $stripe->tokens()->create([
                        'card' => [
                            'number' => '4242424242424242',
                            'exp_month' => '12',
                            'exp_year' => '2020',
                            'cvc' => '123',
                        ],
                    ]);

                if (!isset($token['id'])) {
                    return redirect()->route('stripe_payment');
                }
                $charge = $stripe->charges()->create([
                            'card' => $token['id'],
                            'currency' => 'USD',
                            /*'amount' => $request->amount,*/
                            'amount' => 1,
                            'description' => 'Charge for '.Auth::user()->email,
                        ]);

                if ($charge['status'] == 'succeeded') { 

                    /* Remove cart items for whom payment is done */
                    foreach ($request->bookings_done as $value)
                    {
                        $get_cart_item = Cart::session(Auth::user()->id)->get($value);
                        $booking_id = $get_cart_item['attributes']['booking_id'];
                        $listing_id = $get_cart_item['id'];
                        
                        $remove_cart_item = Cart::session(Auth::user()->id)->remove($value);

                        $booking_update = Bookings::find($booking_id);
                        $booking_update->status_id = 2;
                        $booking_update->save();

                        $listing_booked = Listings::where('id', $listing_id)->first();

                        $notification_data_admin = ["user" => '', "message" => "A booking for ".$listing_booked->title." has been reserved.", "action" => url('admin/bookings')];

                        $notification_data_host = ["user" => '', "message" => "A booking for ".$listing_booked->title." has been reserved.", "action" => url('host/bookings')];

                        $user = User::find($listing_booked['user_id']);

                        $this->admin->notify(new NotifyAdmin($notification_data_admin));
                        $user->notify(new NotifyHost($notification_data_host));
                    }

                    \Session::put('success', 'Payment Successful.');
                    return redirect()->route('checkout');
                } else {
                    \Session::put('error', 'Payment Failed.');
                    return redirect()->route('checkout');
                }
            } catch (Exception $e) {
                \Session::put('pay-error', $e->getMessage());
                return redirect()->route('checkout');
            } catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
                \Session::put('pay-error', $e->getMessage());
                return redirect()->route('checkout');
            } catch (\Cartalyst\Stripe\Exception\MissingParameterException $e) {
                \Session::put('pay-error', $e->getMessage());
                return redirect()->route('checkout');
            }
        } else {
            return back()->withErrors($validator)->withInput();
        }
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
