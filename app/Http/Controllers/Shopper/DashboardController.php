<?php

namespace App\Http\Controllers\Shopper;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Categories;
use App\Models\Listings;
use Validator;
use App\User;
use Redirect;
use Session;
use Auth;

class DashboardController extends Controller
{
    public function index()
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

    public function dashboardView()
    {
    	return view('shopper.dashboard');
    }

    public function profile()
    {
    	$user_data = User::where('id', Auth::user()->id)->first();
    	return view('shopper.profile')->with('user_data', $user_data);
    }

    public function editProfile(Request $request)
    {
    	$validator = Validator::make($request->all(),[
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'min:5', 'max:10'],  
            'postalcode' => ['required', 'numeric'],  
        ]);
        if ($validator->fails()) {
             return back()->withErrors($validator)->withInput();
        }
        try
        {
        	$save_profile = User::find(Auth::user()->id);
        	$save_profile->first_name = $request->firstname;
        	$save_profile->last_name = $request->lastname;
        	$save_profile->user_name = $request->username;
        	$save_profile->postal_code = $request->postalcode;
        	$save_profile->save();

        	return back()->with(['status' => 'success' , 'message' => 'Profile updated successfully.']);
        }
        catch(\Exception $e)
        {
            return back()->with(['status' => 'danger' , 'message' => 'Something went wrong. Please try again later.']);
        }
    }

    public function changePassword()
    {
    	return view('shopper.change_password');
    }

    public function savePassword(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'old_password' => ['required'],
            'new_password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['required', 'string', 'min:8', 'same:new_password'],    
        ]);
        if ($validator->fails()) {
             return back()->withErrors($validator)->withInput();
        }
        try
        {
            $user = User::find(Auth::user()->id);
            if (Hash::check($request->old_password, $user['password']))
            {
                $user->password = Hash::make($request->new_password);
                $user->save();
                return back()->with(['status' => 'success' , 'message' => 'Password updated successfully.']);
            }
            return back()->with(['status' => 'danger' , 'message' => 'Incorrect old password.']);
        }
        catch(\Exception $e)
        {
            return back()->with(['status' => 'danger' , 'message' => 'Something went wrong. Please try again later.']);
        }
    }

    public function changeProfilePicture(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'profile_picture' => ['required', 'image', 'mimes:jpg,jpeg,png'],    
        ]);
        if ($validator->fails()) {
             return response()->json($validator->errors());
        }
        try
        {
            $user = User::find(Auth::user()->id);

            if($user->profile_picture)
            {   
                if(file_exists(public_path('images/profile_pictures/'.$user->profile_picture)))
                {   
                    $del_pic = unlink(public_path('images/profile_pictures/'.$user->profile_picture));
                }
            }

            $file = $request->file('profile_picture');
            $filename = 'user-'.time().'.'.$file->getClientOriginalExtension();
            $file->move('public/images/profile_pictures/',$filename);

            $user->profile_picture = $filename;
            $user->save();
            
            return response()->json(['status' => 'success','message' => 'Profile Picture updated successfully']);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 'danger','message' => 'Something went wrong. Please try again later.']);
        }
    }

    public function removeProfilePicture()
    {
        $user = User::find(Auth::user()->id);
        if(file_exists(public_path('images/profile_pictures/'.$user->profile_picture)))
        {   
            $del_pic = unlink(public_path('images/profile_pictures/'.$user->profile_picture));
            $user->profile_picture = null;
            $user->save();
            return response()->json(['status' => 'success','message' => 'Profile Picture removed successfully']);
        }
        return response()->json(['status' => 'danger','message' => 'Something went wrong. Please try again later.']);
    }
}
