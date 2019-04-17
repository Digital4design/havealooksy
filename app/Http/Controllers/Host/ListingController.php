<?php

namespace App\Http\Controllers\Host;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Carbon;
use App\Models\ListingImages;
use App\Models\ListingGuests;
use App\Models\ListingTimes;
use App\Models\Categories;
use App\Models\Listings;
use Validator;
use Auth;

class ListingController extends Controller
{
    public function getListings()
    {
    	$all_listings = Listings::with(['getImages', 'getGuests', 'getTimes'])->where('user_id', Auth::user()->id)->where('is_approved', 1)->get();
        
        return Datatables::of($all_listings)
        				->editColumn('status', function ($all_listings){
                            if($all_listings['status'] == 1)
                                return 'Active';
                            if($all_listings['status'] == 0)
                                return 'Deactive';
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
                                $time_slots = Carbon::createFromFormat('H:i:s', $all_listings['getTimes'][0]['start_time'])->format('H:i')."-".Carbon::createFromFormat('H:i:s', $all_listings['getTimes'][0]['end_time'])->format('H:i');
                                foreach ($all_listings['getTimes'] as $key => $value) {
                                    $start_time = Carbon::createFromFormat('H:i:s', $value['start_time'])->format('H:i');
                                    $end_time = Carbon::createFromFormat('H:i:s', $value['end_time'])->format('H:i');
                                    if($key != 0)
                                        $time_slots .= ", ".$start_time."-".$end_time;
                                }
                                return $time_slots;
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
                        })->addColumn('images', function ($all_listings){
                            return "<a href='#' data-toggle='modal' data-target='#image-modal' class='listing_images' data-id='".$all_listings['id']."' style='font-size:1em;padding:10px;'><i class='glyphicon glyphicon-picture'></i></a>";
                        })->addColumn('action', function ($all_listings){
                            return "<a href='".route('editListing', $all_listings['id'])."' class='btn btn-info' style='margin-right:5px;'><i class='fa fa-edit'></i></a><button type='button' data-id='".$all_listings['id']."' class='btn btn-warning button_delete'><i class='fa fa-trash-o'></i></button>";
            			})->rawColumns(['activate_deactivate' => 'activate_deactivate', 'action' => 'action', 'images' => 'images'])->make(true);
    }

    public function getListingImages($id)
    {
        $get_images = ListingImages::where('listing_id', $id)->get();
        $images = view('host.renders.listing_images_render')->with('get_images', $get_images)->render();
        return response()->json(['status' => 'success', 'images' => $images]);
    }

    public function addListing()
    {
    	$categories = Categories::with(['childCategories'])->where('status', '1')->where('parent_id', '0')->get();
    	return view('host.add_listing_view')->with('categories', $categories);
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
            'images' => ['required'],  
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

            /* Check if start time or end time is equal to 0:00 */
            if($request->start_time1 == '0:00' || $request->end_time1 == '0:00' || $request->start_time2 == '0:00' || $request->end_time2 == '0:00' || $request->start_time3 == '0:00' || $request->end_time3 == '0:00' || $request->start_time4 == '0:00' || $request->end_time4 == '0:00')
            {
                return back()->with(['status' => 'danger', 'message' => 'Time must be greater than 0:00.']);
            }

        	$listing = Listings::create([
                'title' => $request->title,
                'description' => $request->description,
                'location' => $request->location,
                'price' => $request->price,
                'category_id' => $request->category,
                'status' => $request->status,
                'user_id' => Auth::user()->id,
            ]);

            $children = $infants = '0';
            foreach ($request->people_allowed as $key => $value) {
                if($value == "Children")
                    $children = 1;
                if($value == "Infants")
                    $infants = 1;
            }

            ListingGuests::create([
                'adults' => '1',
                'children' => $children,
                'infants' => $infants,
                'total_count' => $request->people_count,
                'listing_id' => $listing->id,
            ]);



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

            foreach($request->file('images') as $file)
            {
                $filename = 'listing-'.time().uniqid().'.'.$file->getClientOriginalExtension();

                ListingImages::create([
                    'name' => $filename,
                    'listing_id' => $listing->id,
                ]);

                $file->move('public/images/listings',$filename);
            }

        	return redirect()->route('listings')->with(['status' => 'success' , 'message' => 'Listing has been successfully submitted for approval.']);
        }
        catch(\Exception $e)
        {
            // return redirect()->route('listings')->with(['status' => 'danger' , 'message' => 'Something went wrong. Please try again later.']);
            return redirect()->route('listings')->with(['status' => 'danger' , 'message' => $e->getMessage()]);
        }
    }

    public function addTimeSlot($start, $end, $id)
    {
        ListingTimes::create([
            'start_time' => $start,
            'end_time' => $end,
            'listing_id' => $id,
        ]);
    }   

    public function changeStatus($id, $status)
    {   
        $change_status = Listings::find($id);
        $change_status->status = $status;
        $change_status->save();

        return response()->json(['status' => 'success', 'listing_status' => $status]);
    }

    public function editListingView($id)
    {
    	$categories = Categories::with(['childCategories'])->where('status', '1')->where('parent_id', '0')->get();
    	$listing_data = Listings::with(['getImages', 'getGuests', 'getTimes'])->where('id', $id)->first();
    	return view('host.edit_listing')->with(['categories' => $categories, 'listing_data' => $listing_data]);
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
