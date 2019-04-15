<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Models\Categories;
use App\Models\Listings;
use Validator;
use App\User;
use Auth;

class ListingController extends Controller
{
    public function getListingsView()
    {
    	return view('admin.listings_view');
    }

    public function getAllListings()
    {
    	$all_listings = Listings::select("*")->get();

    	return Datatables::of($all_listings)
    					->editColumn('status', function ($all_listings){
                            if($all_listings['status'] == 1)
                                return 'Active';
                            if($all_listings['status'] == 0)
                                return 'Deactive';
                        })->editColumn('is_approved', function ($all_listings){
                            if($all_listings['is_approved'] == 1)
                                return 'Approved';
                            if($all_listings['is_approved'] == 0)
                                return 'Unapproved';
						})->addColumn('category', function ($all_listings){
                                return Categories::where('id', $all_listings['category_id'])
                                        ->pluck('name')->first();
                        })->addColumn('approved_unapproved', function ($all_listings){
                            if($all_listings['is_approved'] == 1){
                                $approval_class = "text-green fa-check-square-o";   
                            }
                            if($all_listings['is_approved'] == 0){
                                $approval_class = "text-red fa-square-o";
                            }
                            return "<a href='#' data-id='".$all_listings['id']."' class='approve-unapprove'><i class='fa ".$approval_class."'</i></a>";

                        })->addColumn('action', function ($all_listings){
                            return "<a href='".route('editListingAdmin', $all_listings['id'])."' class='btn btn-info' style='margin-right:5px;'><i class='fa fa-edit'></i></a><button type='button' data-id='".$all_listings['id']."' class='btn btn-warning button_delete'><i class='fa fa-trash-o'></i></button>";
                        })->editColumn('image', function ($all_listings){
                            return "<a href='".asset('public/images/listings/'.$all_listings['image'])."' style='font-size:1em;padding:10px;' data-lightbox='".$all_listings['title']."'><i class='glyphicon glyphicon-picture'></i></a>";
                        })->rawColumns(['approved_unapproved' => 'approved_unapproved', 'action' => 'action', 'image' => 'image'])->make(true);
    }

    public function changeApprovalSetting($id, $status)
    {
    	$change_approval = Listings::find($id);
        $change_approval->is_approved = $status;
        $change_approval->save();

        return response()->json(['status' => 'success', 'listing_approval_status' => $status]);
    }

    public function editListingView($id)
    {
        $categories = Categories::with(['childCategories'])->where('status', '1')->where('parent_id', '0')->get();
        $listing_data = Listings::where('id', $id)->first();
        return view('admin.edit_listing')->with(['categories' => $categories, 'listing_data' => $listing_data]);
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

            if($request->hasFile('image')){
                $file = $request->file('image');
                $filename = 'listing-'.time().'.'.$file->getClientOriginalExtension();
                $file->move('public/images/listings',$filename);

                $listing->image = $filename;
            }

            $listing->save();

            return redirect()->route('listingsAdmin')->with(['status' => 'success' , 'message' => 'Listing updated successfully.']);
        }
        catch(\Exception $e)
        {
            return redirect()->route('listingsAdmin')->with(['status' => 'danger' , 'message' => 'Something went wrong. Please try again later.']);
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
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 'danger','message' => 'Something went wrong. Please try again later.']);
        }
    }
}
