<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Models\Listings;
use App\Models\Categories;
use Validator;

class ListingController extends Controller
{
    public function getListings()
    {
    	$all_listings = Listings::select("*")->get();

        return Datatables::of($all_listings)
        				->addColumn('category', function ($all_listings){
                                return Categories::where('id', $all_listings['category_id'])
                                        ->pluck('name')->first();
            			})->make(true);
    }

    public function addListing()
    {
    	$categories = Categories::with(['childCategories'])->where('status', '1')->where('parent_id', '0')->get();
    	return view('seller.add_listing_view')->with('categories', $categories);
    }

    public function saveListing(Request $request)
    {
    	$validator = Validator::make($request->all(),[
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required'],
            'location' => ['required', 'string'],  
            'price' => ['required', 'numeric'],  
            'category' => ['required'],  
            'status' => ['required'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png'],  
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try
        {
        	$file = $request->file('image');
            $filename = 'listing-'.time().'.'.$file->getClientOriginalExtension();

        	Listings::create([
                'title' => $request->title,
                'description' => $request->description,
                'location' => $request->location,
                'price' => $request->price,
                'category_id' => $request->category,
                'status' => $request->status,
                'image' => $filename,
            ]);

            $file->move('images/listings',$filename);

        	return redirect()->route('listings')->with(['status' => 'success' , 'message' => 'Listing added successfully.']);
        }
        catch(\Exception $e)
        {
            return redirect()->route('listings')->with(['status' => 'danger' , 'message' => 'Something went wrong. Please try again later.']);
        }
    }
}
