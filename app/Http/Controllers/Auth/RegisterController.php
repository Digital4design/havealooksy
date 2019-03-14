<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\UserRoleRelation;
use Socialite;
use App\Role;
use Auth;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'first_name' => ['required', 'string','min:2','max:255'],
            'last_name' => ['required', 'string','min:2','max:255'],
            'postal_code' => ['required','min:2', 'max:10'],
            'user_name' => ['required', 'string', 'min:2','max:255'],
            //'phone_number' => ['required','numeric','min:10','max:15'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'user_type' => ['required'],
        ]);
        $validator = Validator::make($request->all(), $rules);
       
       if ($validator->fails()) {
           return back()->withErrors($validator)->withInput();
       }

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $role_id = Role::where('name', $data['user_type'])->first();
        
        $newUserData = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'postal_code' => $data['postal_code'],
            'user_name' => $data['user_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // set Role for New Register Doctor 
        $roleArray = array(
                    'user_id' => $newUserData->id,
                    'role_id' => $role_id['id'],
                    );
        
        UserRoleRelation::insert($roleArray);
        return $newUserData;
    }
}
