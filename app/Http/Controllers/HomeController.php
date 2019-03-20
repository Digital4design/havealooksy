<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Categories;
use App\Models\Listings;

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
            $fav_listings = Listings::where('is_favorite', '1')->where('status', '1')->get();

            return view('index')->with(['categories' => $categories, 'fav_listings' => $fav_listings]);
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
}
