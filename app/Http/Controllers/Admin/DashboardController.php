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
                        })->addColumn('block_unblock', function ($all_users){
                            if($all_users['status'] == 1){
                                $status = 'Block';
                                $btn_color = 'danger';
                            }
                            if($all_users['status'] == 0){
                                $status = 'Unblock';
                                $btn_color = 'info';
                            }
                            return "<button type='button' data-id='".$all_users['id']."' class='btn btn-".$btn_color." block-unblock'>".$status."</button>";
                        })->rawColumns(['block_unblock' => 'block_unblock'])->make(true);
    }

    public function changeUserStatus($id, $status)
    {
        $change_user_status = User::find($id);
        $change_user_status->status = $status;
        $change_user_status->save();

        return response()->json(['status' => 'success', 'user_status' => $status]);
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
                        })->addColumn('parent_category', function ($all_categories){
                            if($all_categories['parent_id'] != 0)
                                return Categories::where('id', $all_categories['parent_id'])
                                        ->pluck('name')->first();
                            if($all_categories['parent_id'] == 0)
                                return '-';
                        })->addColumn('activate_deactivate', function ($all_categories){
                            if($all_categories['status'] == 1){
                                $status = 'Deactivate';
                                $btn_color = 'default';
                            }
                            if($all_categories['status'] == 0){
                                $status = 'Activate';
                                $btn_color = 'danger';
                            }
                            return "<button type='button' data-id='".$all_categories['id']."' class='btn btn-".$btn_color." active-deactive' type='button'>".$status."</button>";
                        })->addColumn('action', function ($all_categories){
                            return "<button type='button' data-id='".$all_categories['id']."' class='btn btn-info button_edit' style='margin-right:1em;' data-toggle='modal' data-target='#edit-category'><i class='fa fa-edit'></i></button><button type='button' data-id='".$all_categories['id']."' class='btn btn-warning button_delete'><i class='fa fa-trash-o'></i></button>";
                        })->rawColumns(['activate_deactivate' => 'activate_deactivate','action' => 'action'])->make(true);
    }

    public function addCategory(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'category_name' => ['required', 'string', 'max:255'],
            'status' => ['required'],
        ]);

        if ($validator->fails()) {
             return response()->json($validator->errors());
        }

        try
        {
            Categories::create([
                'name' => $request->category_name,
                'parent_id' => $request->parent_category,
                'status' => $request->status,
            ]);
            
            return response()->json(['status' => 'success','message' => 'Category added successfully.']);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 'danger','message' => 'Something went wrong. Please try again later.']);
        }
    }

    public function changeStatus($id, $status)
    {   
        $change_status = Categories::find($id);
        $change_status->status = $status;
        $change_status->save();

        return response()->json(['status' => 'success', 'category_status' => $status]);
    }

    public function deleteCategory($id)
    {
        try
        {
            $category = Categories::find($id)->delete();
            return response()->json(['status' => 'success','message' => 'Category deleted successfully.']);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 'danger','message' => 'Something went wrong. Please try again later.']);
        }
    }

    public function getCategoryData($id)
    {
        $get = Categories::where('id', $id)
                        ->with(['parentCategory'])
                        ->first();

        $all_categories = Categories::where('id', '!=', $id)->get();
        return response()->json(['status' => 'success','data' => $get, 'all_categories' => $all_categories]);
    }

    public function editCategory(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'edit_category_name' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
             return response()->json($validator->errors());
        }

        try
        {
            $edit_category = Categories::find($request->category_id);
            $edit_category->name = $request->edit_category_name;
            $edit_category->parent_id = $request->edit_parent_category;
            $edit_category->save();
            
            return response()->json(['status' => 'success','message' => 'Category updated successfully.']);
        }
        catch(\Exception $e)
        {
            return response()->json(['status' => 'danger','message' => 'Something went wrong. Please try again later.']);
        }
    }
}
