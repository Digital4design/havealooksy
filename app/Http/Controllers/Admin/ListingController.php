<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Models\ListingImages;
use App\Models\ListingGuests;
use App\Models\ListingTimes;
use App\Models\Categories;
use App\Models\Listings;
use Validator;
use App\User;
use Carbon;
use Auth;

class ListingController extends Controller
{
    public function getListingsView()
    {
    	return view('admin.listings_view');
    }

    public function getAllListings()
    {
    	$all_listings = Listings::with(['getGuests', 'getTimes'])->select("*")->get();

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
                        })->editColumn('founder_pick', function ($all_listings){
                            if($all_listings['founder_pick'] == 1)
                                return 'Yes';
                            if($all_listings['founder_pick'] == 0)
                                return 'No';
						})->addColumn('category', function ($all_listings){
                                return Categories::where('id', $all_listings['category_id'])
                                        ->pluck('name')->first();
                        })->addColumn('guest_count', function($all_listings){
                                return $all_listings['getGuests']['total_count'];
                        })->addColumn('guests', function($all_listings){
                                $names = 'Adults';
                                if($all_listings['getGuests']['children'] == 1)
                                    $names .= ', Children';
                                if($all_listings['getGuests']['infants'] == 1)
                                    $names .= ', Infants';
                                return $names;
                        })->addColumn('time_slots', function($all_listings){
                                $time_slots = Carbon::createFromFormat('H:i:s', $all_listings['getTimes'][0]['start_time'])->format('g:i a')."-".Carbon::createFromFormat('H:i:s', $all_listings['getTimes'][0]['end_time'])->format('g:i a');
                                foreach ($all_listings['getTimes'] as $key => $value) {
                                    $start_time = Carbon::createFromFormat('H:i:s', $value['start_time'])->format('g:i a');
                                    $end_time = Carbon::createFromFormat('H:i:s', $value['end_time'])->format('g:i a');
                                    if($key != 0)
                                        $time_slots .= ", ".$start_time."-".$end_time;
                                }
                                return $time_slots;
                        })->addColumn('approved_unapproved', function ($all_listings){
                            if($all_listings['is_approved'] == 1){
                                $approval_class = "text-green fa-check-square-o";   
                            }
                            if($all_listings['is_approved'] == 0){
                                $approval_class = "text-red fa-square-o";
                            }
                            return "<a href='#' data-id='".$all_listings['id']."' class='approve-unapprove'><i class='fa ".$approval_class."'</i></a>";
                        })->addColumn('founder_pick_button', function ($all_listings){
                            if($all_listings['founder_pick'] == 1){
                                $fndr_class = 'btn-default';
                                $fndr_label = 'Remove'; 
                            }
                            if($all_listings['founder_pick'] == 0){
                                $fndr_class = 'bg-olive';
                                $fndr_label = 'Add'; 
                            }
                            return "<a href='#' data-id='".$all_listings['id']."' class='founder_pick_btn btn btn-sm ".$fndr_class."' style='margin-left:15px;'>".$fndr_label."</a>";
                        })->addColumn('action', function ($all_listings){
                            return "<a href='".url('admin/listings/view/'.$all_listings['id'])."' class='btn bg-teal' style='margin-right:5px;'><i class='fa fa-eye'></i></a><a href='".route('editListingAdmin', $all_listings['id'])."' class='btn btn-info' style='margin-right:5px;'><i class='fa fa-edit'></i></a><button type='button' data-id='".$all_listings['id']."' class='btn btn-warning button_delete'><i class='fa fa-trash-o'></i></button>";
                        })->addColumn('images', function ($all_listings){
                            return "<a href='#' data-toggle='modal' data-target='#image-modal' class='listing_images' data-id='".$all_listings['id']."' style='font-size:1em;padding:10px;'><i class='glyphicon glyphicon-picture'></i></a>";
                        })->rawColumns(['approved_unapproved' => 'approved_unapproved', 'action' => 'action', 'images' => 'images', 'founder_pick_button' => 'founder_pick_button'])->make(true);
    }

    public function getListingImages($id)
    {
        $get_images = ListingImages::where('listing_id', $id)->get();
        $images = view('host.renders.listing_images_render')->with('get_images', $get_images)->render();
        return response()->json(['status' => 'success', 'images' => $images]);
    }

    public function changeApprovalSetting($id, $status)
    {
    	$change_approval = Listings::find($id);
        $change_approval->is_approved = $status;
        $change_approval->save();

        return response()->json(['status' => 'success', 'listing_approval_status' => $status]);
    }

    public function changeFounderPickStatus($id, $status)
    {   
        // dd($status);
        $founder_pick_status = Listings::find($id);
        $founder_pick_status->founder_pick = $status;
        $founder_pick_status->save();

        return response()->json(['status' => 'success']);
    }

    public function viewListing($id)
    {
        $listing = Listings::with(['getGuests', 'getTimes', 'getImages', 'getCategory'])->where('id', $id)->first();
        return view("admin.view_listing")->with('listing', $listing);
    }

    public function editListingView($id)
    {
        $categories = Categories::with(['childCategories'])->where('status', '1')->where('parent_id', '0')->get();
        $listing_data = Listings::with(['getImages'])->where('id', $id)->first();
        return view('admin.edit_listing')->with(['categories' => $categories, 'listing_data' => $listing_data]);
    }

    public function removeListingImage($id)
    {
        $listing_image = ListingImages::find($id);

        if(file_exists(public_path('images/listings/'.$listing_image->name)))
        {   
            $del_pic = unlink(public_path('images/listings/'.$listing_image->name));
            $listing_image->delete();
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
            'images.*' => ['image', 'mimes:jpg,jpeg,png'],
            'people_count' => ['required', 'not_in:0'],
            'people_allowed' => ['required'],
            'start_time1' => ['required'],  
            'end_time1' => ['required'],  
        ], ['images.image' => 'Only images can be uploaded with extensions - .jpg, .jpeg, .png', 'people_count.not_in' => 'People count cannot be 0.', 'start_time1.required' => 'Start time input is required.', 'end_time1.required' => 'End time input is required.']);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try
        {
            /* Check if lisitng has atleast one image */
            $check_images = ListingImages::where('listing_id', $request->listing_id)->get()->count();
            if($check_images == 0){
                if(!$request->hasFile('images')){
                    return back()->with(['status' => 'danger', 'message' => 'You must select at least one image.']);
                }
            }

            /* Check if start time or end time is equal to 0:00 */
            if($request->start_time1 == '0:00' || $request->end_time1 == '0:00' || $request->start_time2 == '0:00' || $request->end_time2 == '0:00' || $request->start_time3 == '0:00' || $request->end_time3 == '0:00' || $request->start_time4 == '0:00' || $request->end_time4 == '0:00')
            {
                return back()->with(['status' => 'danger', 'message' => 'Time must be greater than 0:00.']);
            }

            $listing = Listings::find($request->listing_id);
            $listing->title = $request->title;
            $listing->description = $request->description;
            $listing->location = $request->location;
            $listing->price = $request->price;
            $listing->category_id = $request->category;
            $listing->save();

            $children = $infants = '0';
            foreach ($request->people_allowed as $key => $value) {
                if($value == "Children")
                    $children = 1;
                if($value == "Infants")
                    $infants = 1;
            }

            $guests_id = ListingGuests::where('listing_id', $request->listing_id)->first();
            $listing_guests = ListingGuests::find($guests_id->id);
            $listing_guests->children = $children;
            $listing_guests->infants = $infants;
            $listing_guests->total_count = $request->people_count;
            $listing_guests->save();

            $times_id = ListingTimes::where('listing_id', $request->listing_id)->get();

            foreach($times_id as $val){
                $listing_times = ListingTimes::find($val->id);
                $listing_times->delete();
            }

            $this->addTimeSlot($request->start_time1, $request->end_time1, $listing->id);

            if($request->start_time2 != '' && $request->end_time2 != ''){
                $this->addTimeSlot($request->start_time2, $request->end_time2, $listing->id);
            }
            if($request->start_time3 != '' && $request->end_time3 != ''){
                $this->addTimeSlot($request->start_time3, $request->end_time3, $listing->id);
            }
            if($request->start_time4 != '' && $request->end_time4 != ''){
                $this->addTimeSlot($request->start_time4, $request->end_time4, $listing->id);
            }

            if($request->hasFile('images')){
                foreach($request->file('images') as $file)
                {
                    $filename = 'listing-'.time().uniqid().'.'.$file->getClientOriginalExtension();

                    ListingImages::create([
                        'name' => $filename,
                        'listing_id' => $request->listing_id,
                    ]);

                    $file->move('public/images/listings',$filename);
                }
            }

            return redirect()->route('listingsAdmin')->with(['status' => 'success' , 'message' => 'Listing updated successfully.']);
        }
        catch(\Exception $e)
        {
            return redirect()->route('listingsAdmin')->with(['status' => 'danger' , 'message' => 'Something went wrong. Please try again later.']);
        }
    }

    public function addTimeSlot($start, $end, $id)
    {
        $start = date("H:i", strtotime($start));
        $end = date("H:i", strtotime($end));
        
        ListingTimes::create([
            'start_time' => $start,
            'end_time' => $end,
            'listing_id' => $id,
        ]);
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
