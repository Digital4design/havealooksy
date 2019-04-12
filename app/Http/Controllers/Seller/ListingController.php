<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Models\Categories;
use App\Models\Listings;
use Validator;
use Auth;

class ListingController extends Controller
{
    public function getListings()
    {
    	$all_listings = Listings::where('user_id', Auth::user()->id)->where('is_approved', 1)->get();

        return Datatables::of($all_listings)
        				->editColumn('status', function ($all_listings){
                            if($all_listings['status'] == 1)
                                return 'Active';
                            if($all_listings['status'] == 0)
                                return 'Deactive';
                        })->editColumn('is_favorite', function ($all_listings){
                            if($all_listings['is_favorite'] == 1)
                                return 'Favorite';
                            if($all_listings['is_favorite'] == 0)
                                return 'Non-Favorite';
        				})->addColumn('category', function ($all_listings){
                                return Categories::where('id', $all_listings['category_id'])
                                        ->pluck('name')->first();
                        })->addColumn('activate_deactivate', function ($all_listings){
                            if($all_listings['status'] == 1){
                                $status = 'Deactivate';
                                $btn_color = 'default';
                            }
                            if($all_listings['status'] == 0){
                                $status = 'Activate';
                                $btn_color = 'danger';
                            }
                            return "<button type='button' data-id='".$all_listings['id']."' class='btn btn-".$btn_color." active-deactive' type='button'>".$status."</button>";
                        })->addColumn('action', function ($all_listings){
                            return "<a href='".route('editListing', $all_listings['id'])."' class='btn btn-info' style='margin-right:5px;'><i class='fa fa-edit'></i></a><button type='button' data-id='".$all_listings['id']."' class='btn btn-warning button_delete'><i class='fa fa-trash-o'></i></button>";
                        })->editColumn('image', function ($all_listings){
                            return "<a href='".asset('public/images/listings/'.$all_listings['image'])."' style='font-size:1.3em;' target='_blank'><i class='fa fa-eye'></i></a>";
                        })->addColumn('is_favorite_listing', function ($all_listings){
                            if($all_listings['is_favorite'] == 1)
                                return "<a href='#' data-id='".$all_listings['id']."' class='is-favorite'><i class='fa text-yellow fa-star'></i></a>";
                            if($all_listings['is_favorite'] == 0)
                                return "<a href='#' data-id='".$all_listings['id']."' class='is-favorite'><i class='fa text-yellow fa-star-o'></i></a>";
            			})->rawColumns(['activate_deactivate' => 'activate_deactivate', 'action' => 'action', 'image' => 'image', 'is_favorite_listing' => 'is_favorite_listing'])->make(true);
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
                'user_id' => Auth::user()->id,
            ]);

            $file->move('public/images/listings',$filename);

        	return redirect()->route('listings')->with(['status' => 'success' , 'message' => 'Listing has been successfully submitted for approval.']);
        }
        catch(\Exception $e)
        {
            return redirect()->route('listings')->with(['status' => 'danger' , 'message' => 'Something went wrong. Please try again later.']);
        }
    }

    public function changeStatus($id, $status)
    {   
        $change_status = Listings::find($id);
        $change_status->status = $status;
        $change_status->save();

        return response()->json(['status' => 'success', 'listing_status' => $status]);
    }

    public function changeFavoriteStatus($id, $status)
    {
        $fav_status = Listings::find($id);
        $fav_status->is_favorite = $status;
        $fav_status->save();

        return response()->json(['status' => 'success', 'fav_status' => $status]);
    }

    public function editListingView($id)
    {
    	$categories = Categories::with(['childCategories'])->where('status', '1')->where('parent_id', '0')->get();
    	$listing_data = Listings::where('id', $id)->first();
    	return view('seller.edit_listing')->with(['categories' => $categories, 'listing_data' => $listing_data]);
    }

    public function removeListingImage($id)
    {
        $listing = Listings::find($id);

        if(file_exists(public_path('images/listings/'.$listing->image)))
        {   
            $del_pic = unlink(public_path('images/listings/'.$listing->image));
            $listing->image = null;
            $listing->save();
            return response()->json(['status' => 'success','message' => 'Listing Image removed successfully']);
        }
        return response()->json(['status' => 'danger','message' => 'Something went wrong. Please try again later.']);
    }

    public function updateListing(Request $request)
    {
    	$validator = Validator::make($request->all(),[
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required'],
            'location' => ['required', 'string'],  
            'price' => ['required', 'numeric'],  
            'category' => ['required'],  
            'status' => ['required'],
            'image' => ['image', 'mimes:jpg,jpeg,png'],  
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try
        {
        	$listing = Listings::find($request->listing_id);
        	$listing->title = $request->title;
        	$listing->description = $request->description;
        	$listing->location = $request->location;
        	$listing->price = $request->price;
        	$listing->category_id = $request->category;
        	$listing->status = $request->status;

        	if($request->hasFile('image')){
        		$file = $request->file('image');
            	$filename = 'listing-'.time().'.'.$file->getClientOriginalExtension();
            	$file->move('public/images/listings',$filename);

            	$listing->image = $filename;
        	}

        	$listing->save();

        	return redirect()->route('listings')->with(['status' => 'success' , 'message' => 'Listing updated successfully.']);
        }
        catch(\Exception $e)
        {
            return redirect()->route('listings')->with(['status' => 'danger' , 'message' => 'Something went wrong. Please try again later.']);
        }
    }

    public function deleteListing($id)
    {
    	try
        {
            $listing = Listings::find($id);
            $listing->deleted_by = Auth::user()->id;
            $listing->save();
            $listing->delete();

            return response()->json(['status' => 'success','message' => 'Listing deleted successfully.']);
   //          if (file_exists(public_path('images/listings/'.$listing->image)))
			// {
   //          	$del_image = unlink(public_path('images/listings/'.$listing->image));
   //          	$listing->delete();
   //          	return response()->json(['status' => 'success','message' => 'Listing deleted successfully.']);
   //          }
   //          return response()->json(['status' => 'danger','message' => 'Listing cannot be deleted!']);  
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 'danger','message' => 'Something went wrong. Please try again later.']);
        }
    }
}
