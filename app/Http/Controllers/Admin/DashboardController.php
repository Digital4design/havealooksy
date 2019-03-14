<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;
use Auth;
use Validator;
use Yajra\Datatables\Datatables;
use App\Models\Categories;

class DashboardController extends Controller
{
    public function index()
    {
    	return view('admin.dashboard');
    }

    public function profile()
    {
    	$user_data = User::where('id', Auth::user()->id)->first();
    	return view('admin.profile')->with('user_data', $user_data);
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
        return view('admin.change_password');
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
            $user = User::find(Auth::user()->id)->first();
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

    public function getUsersView()
    {
        return view('admin.users_list');
    }

    public function getUsers()
    {
    	$all_users = User::with(['getRole'])
    					->whereHas('roles', function($q){
    						$q->where('name', 'buyer')->orWhere('name', 'seller');
    					})->get();

        return Datatables::of($all_users)
                        ->addColumn('user_type', function ($all_users){
                            return $all_users['getRole']['display_name'];
                        })->make(true);
    }

    public function getCategoriesView()
    {
        return view('admin.category_list');
    }

    public function getCategories()
    {
        $all_categories = Categories::select("*")->get();

        return Datatables::of($all_categories)
                        ->editColumn('status', function ($all_categories){
                            if($all_categories['status'] == 1)
                                return 'Active';
                            if($all_categories['status'] == 0)
                                return 'Deactive';
                        })->editColumn('parent_id', function ($all_categories){
                            return Categories::where('id', $all_categories['parent_id'])
                                        ->select('name')->first();
                        })->make(true);
    }

    public function addCategory(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'name' => ['required', 'string', 'max:255'],
            'status' => ['required']
        ]);

        if ($validator->fails()) {
             return response()->json($validator->errors());
        }

        try
        {
            
            
            return response()->json(['status' => 'success','message' => 'Category added successfully']);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 'danger','message' => 'Something went wrong. Please try again later.']);
        }
    }
}
