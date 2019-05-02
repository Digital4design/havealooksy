<?php

namespace App\Http\Controllers;

use App\Notifications\Admin\NotifyAdmin;
use App\Notifications\Host\NotifyHost;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\RatingsAndReviews;
use App\Models\ListingGuests;
use Cartalyst\Stripe\Stripe;
use App\Models\ListingTimes;
use App\Models\Categories;
use App\Models\Listings;
use App\Models\Bookings;
use App\Models\OrderItems;
use App\Models\Wishlist;
use App\Models\Orders;
use Stripe\Error\Card;
use Validator;
use App\User;
use Session;
use Carbon;
use Auth;
use Cart;
use Mail;

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
            // $fav_listings = Listings::with(['getImages', 'getCategory', 'getRatings'])
            //                         ->where('status', '1')
            //                         ->where('is_approved', '1')
            //                         ->whereHas('getRatings', function($q){
            //                             $q->where('approved', '1')
            //                               ->where('spam', '0');
            //                         })->get();

            $fav_listings = Listings::leftJoin('listing_images' ,'listing_images.listing_id', '=', 'listings.id')
                            ->leftJoin('ratings_and_reviews' ,'ratings_and_reviews.listing_id', '=', 'listings.id')
                            ->where('ratings_and_reviews.approved', '1')
                            ->where('ratings_and_reviews.spam', '0')
                            ->where('listings.status', '1')
                            ->where('listings.is_approved', '1')
                            ->select('listing_images.name as listing_image', 'listings.*')
                            ->selectRaw('avg(ratings_and_reviews.rating) as avg_rating')
                            ->groupBy('ratings_and_reviews.listing_id')
                            ->orderBy('avg_rating', 'desc')
                            ->take(5)
                            ->get();
            // dd($fav_listings);
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

        $avg_rating = RatingsAndReviews::where('listing_id', $id)
                                        ->where('approved', '1')
                                        ->where('spam', '<>', '1')
                                        ->selectRaw('avg(rating) as avg')
                                        ->groupBy('listing_id')
                                        ->first();

        $ratings_data = RatingsAndReviews::with(['getReviewer'])->where('listing_id', $id)
                                        ->where('approved', '1')
                                        ->where('spam', '<>', '1')
                                        ->get();
        
        if(Auth::guest())
        {
            return view('frontapp.product-details')->with(['listing_data' => $listing_data, 'avg_rating' => $avg_rating, 'ratings_data' => $ratings_data, 'all_listings' => $all_listings_of_category, 'wishlist' => '0']);
        }
        
        $check_wishlist = Wishlist::where('listing_id', $id)
                            ->where('user_id', Auth::user()->id)
                            ->first();

        if($check_wishlist)
        {
            return view('frontapp.product-details')->with(['listing_data' => $listing_data, 'avg_rating' => $avg_rating, 'ratings_data' => $ratings_data, 'all_listings' => $all_listings_of_category, 'wishlist' => '1']);
        }

        return view('frontapp.product-details')->with(['listing_data' => $listing_data, 'avg_rating' => $avg_rating, 'ratings_data' => $ratings_data, 'all_listings' => $all_listings_of_category, 'wishlist' => '0']);
    }

    /* Get Listing Availability Details */
    public function getProductAvailability($id, $date)
    {
        $clicked_date = Date("Y-m-d", $date);
        $guests = ListingGuests::where('listing_id', $id)->first();

        /* Check if all time slots are not empty */
        $check_bookings = Bookings::where('listing_id', $id)
                            ->where('status_id', '2')
                            ->where('date', $clicked_date)
                            ->select('time_slot')
                            ->selectRaw('sum(no_of_seats) as seats_filled')
                            ->groupBy('time_slot')
                            ->get();
        
        if(!$check_bookings->isEmpty())
        {
            foreach ($check_bookings as $value)
            {
                if($value['seats_filled'] == $guests['total_count'])
                {
                    $filled_slot[] = $value['time_slot'];
                }
            }

            if(isset($filled_slot))
            {
                $get_times = ListingTimes::where('listing_id', $id)->whereNotIn('id', $filled_slot)->get();

                if($get_times->isEmpty())
                {
                    return response()->json(['status' => 'empty', 'message' => 'No free time slot available. Choose any other date.']);
                }
            } 
        }

        /* Return non-empty time-slots */
        $times = ListingTimes::where('listing_id', $id)->get();

        foreach ($times as $t)
        {
            $bookings = Bookings::where('listing_id', $id)
                            ->where('status_id', '2')
                            ->where('date', $clicked_date)
                            ->where('time_slot', $t['id'])
                            ->select('time_slot')
                            ->selectRaw('sum(no_of_seats) as seats_filled')
                            ->groupBy('time_slot')
                            ->first();

            if($bookings['seats_filled'] != 0)
            {
                $seats_left = $guests['total_count']-$bookings['seats_filled'];
                $t['seats_left'] = $seats_left;
            }
            else
            {
                $t['seats_left'] = $guests['total_count'];
            }
        }

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
                return response()->json(['status' => 'danger', 'message' => 'Guest count must not exceed Maximum allowed guests.']);
            }

            /* Check seats availablity */
            $seats_filled = Bookings::where('listing_id', $request->listing_id)
                            ->where('status_id', '2')
                            ->where('date', $request->date)
                            ->where('time_slot', $request->time)
                            ->selectRaw('sum(no_of_seats) as total')
                            ->groupBy('time_slot')
                            ->first();

            $seats_left = $listing['getGuests']['total_count']-$seats_filled['total'];

            if($seats_left < $total_guests)
            {  
                return response()->json(['status' => 'danger', 'message' => 'Selected time slot has only '.$seats_left.' seats left.']);
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

            /* Notify Host */
            $listing_booked = Listings::where('id', $listing['id'])->first();

            $notification_data_host = ["user" => '', "message" => "A new booking request for ".$listing_booked->title.".", "action" => url('host/bookings/booking-list')];
            
            $user = User::find($listing_booked['user_id']);
            $user->notify(new NotifyHost($notification_data_host));

            return response()->json(['status' => 'success', 'message' => 'Your request for the experience has been submitted for confirmation.']);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 'danger','message' => 'Something went wrong! Please try again later.']);
            // return response()->json(['status' => 'danger','message' => $e->getMessage()]);
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

                    /* Save Order */
                    $order = Orders::create([
                        'order_number' => uniqid("order".mt_rand(0,9999)),
                        'user_id' => Auth::user()->id,
                        'order_amount' => $request->amount,
                        'order_status' => 'Completed',
                    ]); 

                    /* Remove cart items for whom payment is done */
                    foreach ($request->bookings_done as $value)
                    {
                        $get_cart_item = Cart::session(Auth::user()->id)->get($value);
                        $booking_id = $get_cart_item['attributes']['booking_id'];
                        $listing_id = $get_cart_item['id'];
                        
                        $remove_cart_item = Cart::session(Auth::user()->id)->remove($value);

                        /* Update booking status */
                        $booking_update = Bookings::find($booking_id);
                        $booking_update->status_id = 2;
                        $booking_update->save();

                        /* Save Order Items */
                        OrderItems::create([
                            'order_item' => $booking_id,
                            'order_id' => $order->id, 
                        ]);

                        /* Notify Host */
                        $listing_booked = Listings::where('id', $listing_id)->first();

                        $notification_data_host = ["user" => '', "message" => "A booking for ".$listing_booked->title." has been reserved.", "action" => url('host/bookings/booking-calendar')];
                        $user = User::find($listing_booked['user_id']);
                        $user->notify(new NotifyHost($notification_data_host));
                    }

                    /* Notify Admin */
                    $notification_data_admin = ["user" => '', "message" => "A new order has been placed.", "action" => url('admin/orders')];
                    $this->admin->notify(new NotifyAdmin($notification_data_admin));

                    return redirect()->to('/order-success')->with(['order_status' => 'success', 'order_number' => $order->order_number]);
                } 
                else {
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

    public function orderSuccess()
    {
        return view('frontapp.order_success_view');
    }

    public function wishlistView()
    {
        $wishlist = Wishlist::with(['getListing', 'getListingImages'])
                            ->whereHas("getListing", function($q){
                                $q->where('is_approved', '1')->where('status', '1');
                            })->where('user_id', Auth::user()->id)->get();

        return view('frontapp.wishlist_view')->with(['status' => 'success', 'wishlist' => $wishlist]);
    }

    public function addToWishlist($id)
    {
        try
        {
            $listing = Listings::where('id', $id)->first();

            Wishlist::create([
                'listing_id' => $id,
                'user_id' => Auth::user()->id,
            ]);

            return redirect()->to('/wishlist');
        }
        catch(\Exception $e)
        {
            return redirect()->back()->with(['status' => 'danger','message' => 'Something went wrong! Please try again later.']);
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

    public function contactFormView()
    {
        return view('frontapp.contact_form');
    }

    public function sendContactMessage(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'subject' => ['required', 'string'],  
            'message' => ['required'],   
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try
        {
            $emailData = [
                    'name' => $request->name,
                    'email_message' => $request->message,
                    'subject' => $request->subject,
                ];

            Mail::send(['html'=>'frontapp.contact_email'], $emailData, function($message) use($request){
                $message->to(env('MAIL_USERNAME'), 'Looksy')->subject('Looksy - '.$request->subject);
                $message->from($request->email, $request->name);
            });

            return redirect()->back()->with(['status' => 'success' , 'message' => 'Message sent successfully.']);
        }
        catch(\Exception $e)
        {
            // return redirect()->back()->with(['status' => 'danger' , 'message' => 'Something went wrong. Please try again later.']);
            return redirect()->back()->with(['status' => 'danger' , 'message' => $e->getMessage()]);
        }
    }
}
